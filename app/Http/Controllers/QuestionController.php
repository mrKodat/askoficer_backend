<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOptions;
use App\Models\QuestionTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class QuestionController extends Controller
{
    public function index(Question $questions)
    {
        return view('questions.questions-index', ['questions' => Question::all()]);
    }

    public function questionedit(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $author = User::findOrFail($question->author_id);
        $categories = Category::all();
        $tags = QuestionTag::where('question_id', $id)->get()->pluck('tag')->implode(',');
        // $tags = implode(",", $alltags);
        $selectedtag = DB::table('question_tags')
            ->where('question_tags.question_id', '=', $question->id)
            ->join('tags', 'tags.id', '=', 'question_tags.tag')
            ->select('tags.*')
            ->get();
        $options = DB::table('question_options')->where('question_id', '=', $question->id)->get();
        return view('questions.question-edit', compact('question', 'author', 'categories', 'tags', 'selectedtag', 'options'));
    }

    public function questionupdate(Request $request, $id)
    {

        $question = Question::find($id);
        $question->title = trim($request->input('title'));
        $question->content = trim($request->input('content'));
        $question->category_id = trim($request->input('category_id'));
        if ($request->videoURL != null)
            $question->videoURL = trim($request->input('videoURL'));
        $question->status = $request->input('status');
        $question->type = "Question";
        $tags = explode(",", $request->tags);
        $question->polled = $request->has('polled');
        if ($request->has('polled')) {
            $question->type = "Poll";
            $options = $request->option;
            $question->imagePolled = 0;
            if (isset($request->imagePolled)) {
                $question->imagePolled = 1;
                $options = $request->imageoption;
            }
        } else {
            $question->type = "Question";
        }

        if ($request->hasFile('featuredImage')) {
            if ($question->featuredImage != null) {
                $oldImagePath = public_path("/uploads/featuredImages/$question->featuredImage");
                unlink($oldImagePath);
            }
            $featuredImage =  $request->file('featuredImage');
            $extension = $featuredImage->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $featuredImage->move('uploads/featuredImages/', $filename);
            $question->featuredImage = $filename;
        }

        $question->update();

        DB::table('question_tags')->where('question_id', '=', $question->id)->delete();

        if (!is_null($tags)) {
            $data = [];
            foreach ($tags as $tag) {
                $data[] = [
                    'question_id' => $question->id,
                    'tag' => $tag,
                ];
            }

            DB::table('question_tags')->insert($data);
        }

        if ($request->has('polled')) {
            $ids = collect($options)->pluck('id')->toArray();
            $existingQuestionOptions = DB::table('question_options')->where('question_id', $question->id)->pluck('id')->toArray();
            $deletableIds = array_diff($existingQuestionOptions, $ids);

            if (!is_null($deletableIds)) {
                foreach ($deletableIds as $deletableId) {
                    DB::table('question_options')->where('id', $deletableId)->delete();
                }
            }

            foreach ($options as $key => $value) {

                // dd($options);
                if (isset($options[$key]['id'])) {

                    $existingOption = QuestionOptions::where('id', $options[$key]['id'])->first();
                    $existingOption->question_id = $question->id;
                    $existingOption->option = $options[$key]['value'];

                    if (isset($options[$key]['image'])) {
                        $image = $options[$key]['image'];
                        $extension = $image->getClientOriginalExtension();
                        $imagename = pathinfo($image, PATHINFO_FILENAME);
                        $filename =  $imagename  . '.' . $extension;
                        $image->move('uploads/optionimages/', $filename);
                        $existingOption->image = $filename;
                    }
                    $existingOption->save();
                } else {
                    $option = new QuestionOptions;
                    $option->question_id = $question->id;
                    $option->option = $options[$key]['value'];

                    if (isset($options[$key]['image'])) {
                        $image = $options[$key]['image'];
                        $extension = $image->getClientOriginalExtension();
                        $imagename = pathinfo($image, PATHINFO_FILENAME);
                        $filename =  $imagename  . '.' . $extension;
                        $image->move('uploads/optionimages/', $filename);
                        $option->image = $filename;
                    }

                    $option->save();
                }
            }
        }

        return redirect('/questions')->with('status', 'Question updated successfully');
    }

    public function questiondelete($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect('/questions')->with('status', 'Question deleted successfully');
    }

    public function questionadd(Request $request)
    {
        $question = new Question;
        $question->author_id = trim($request->input('author_id'));
        $question->title = trim($request->input('title'));
        $question->content = trim($request->input('content'));
        $question->category_id = trim($request->input('category_id'));
        if ($request->videoURL != null)
            $question->videoURL = trim($request->input('videoURL'));
        $question->status = $request->input('status');
        if ($request->tags != null)
            $tags = explode(",", $request->tags);
        $question->polled = $request->has('polled');
        if ($request->has('polled')) {
            if ($request->has('imagePolled')) {
                $question->type = "Poll";
                $question->imagePolled = $request->has('imagePolled');
                $imageoptions = $request->input('imageoption');
                $images = $request->file('optionimage');
            } else {
                $question->type = "Poll";
                // $question->pollTitle = $request->input('pollTitle');
                $options =  array_filter($request->input('option'));
            }
        } else {
            $question->type = "Question";
        }

        if ($request->featuredImage != null) {
            if ($request->hasFile('featuredImage')) {
                $featuredImage =  $request->file('featuredImage');
                $extension = $featuredImage->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $featuredImage->move('uploads/featuredImages/', $filename);
                $question->featuredImage = $filename;
            }
        }

        $question->save();

        $data = [];
        if ($request->tags != null) {
            foreach ($tags as $tag) {
                $data[] = [
                    'question_id' => $question->id,
                    'tag' => $tag,
                ];
            }
            DB::table('question_tags')->insert($data);
        }

        if ($request->has('polled')) {
            if ($request->has('imagePolled')) {
                $images = $request->file('imageoption');

                $i = 0;
                foreach ($imageoptions as $key => $option) {

                    if (isset($images[$key]['optionimage'])) {
                        $image = $images[$key]['optionimage'];
                        $extension = $image->getClientOriginalExtension();
                        $imagename = pathinfo($image, PATHINFO_FILENAME);
                        $filename = $imagename  . '.' . $extension;
                        $image->move('uploads/optionimages/', $filename);
                    }
                    DB::table('question_options')->insert(['question_id' => $question->id, 'option' => $imageoptions[$key]['value'], 'image' => $filename]);

                    $i++;
                }
            } else {
                foreach ($options as $key => $option) {
                    DB::table('question_options')->insert(['question_id' => $question->id, 'option' => $options[$key]['value']]);
                }
            }
        }

        return redirect('/questions')->with('status', 'Question added successfully');
    }
}
