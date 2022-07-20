<?php

namespace App\Http\Controllers\Api;

use App\Events\SendPushNotificationEvent;
use App\Events\UserPointsUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentVote;
use App\Models\Question;
use App\Models\QuestionVote;
use App\Models\Tag;
use App\Models\Option;
use App\Models\Point;
use App\Models\QuestionOptions;
use App\Models\QuestionTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as Validator;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addQuestion(Request $request)
    {
        $rules = [
            'author_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            // 'category_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $question = new Question;
        $question->author_id = $request->input('author_id');
        $question->title = $request->input('title');
        $question->content = $request->input('content');
        $question->category_id = $request->input('category_id');
        $question->imagePolled = $request->input('imagePolled');
        $question->videoURL = $request->input('videoURL');
        $tags = json_decode($request->input('tag'));
        $question->created_at = $request->input('created_at');
        $question->polled = $request->input('polled');
        $question->isAnonymous = $request->input('anonymous');
        $question->asking = $request->input('asking');

        if ($request->input('polled') == true) {
            $question->type = "Poll";
            $question->pollTitle = $request->input('pollTitle');
        } else {
            $question->type = "Question";
        }

        if ($request->hasFile('featuredImage')) {
            $image =  $request->file('featuredImage');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $image->move('uploads/featuredImages/', $filename);
            $question->featuredImage = $filename;
        }

        $question->save();

        event(new UserPointsUpdatedEvent($question->author_id, Point::find(4)->points));

        $data = [];
        if (!is_null($tags)) {
            foreach ($tags as $tag) {
                $data[] = [
                    'question_id' => $question->id,
                    'tag' => $tag,
                ];
            }
        }

        // if ($request->input('polled') == true) {
        //     foreach ($options as $option) {
        //         DB::table('question_options')->insert(['question_id' => $question->id, 'option' => $option]);
        //     }
        // }

        DB::table('question_tags')->insert($data);

        DB::table('panel_notifications')->insert(["message" => "A new question with id $question->id has been published", "url" => url('') . "/question-edit/$question->id"]);

        return response()->json(["message" => "", "id" => $question->id], 201);
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = Question::find($id);
        $question->title = trim($request->input('title'));
        $question->content = trim($request->input('content'));
        $question->category_id = trim($request->input('category_id'));
        $question->updated_at = trim($request->input('updated_at'));
        if ($request->videoURL != null)
            $question->videoURL = trim($request->input('videoURL'));
        $question->type = "Question";
        $tags = json_decode($request->input('tag'));
        $question->polled = $request->input('polled');
        $question->isAnonymous = $request->input('anonymous');
        if ($request->input('polled') != null) {
            $question->type = "Poll";

            $question->imagePolled = $request->input('imagePolled');
            if (!is_null($request->input('option'))) {
                $options = json_decode($request->input('option'), true);
                $ids = collect($options)->pluck('id');
            }
            $images = $request->file('optionimage');
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

        // $requested_ids = array();

        // foreach ($options as $option) {
        //     $requested_ids[] = $option['id'];
        // }

        // return response()->json($requested_ids, 201);

        // $existingQuestionOptions = DB::table('question_options')->where('question_id', $question->id)->pluck('id')->toArray();
        // $deletableIds = array_diff(array_filter($existingQuestionOptions), array_filter($requested_ids));

        // if (!is_null($deletableIds)) {
        //     foreach ($deletableIds as $deletableId) {
        //         DB::table('question_options')->where('id', $deletableId)->delete();
        //     }
        // }

        // return response()->json(["requested_ids" => $requested_ids, "existingQuestionOptions" => $existingQuestionOptions], 201);

        // $i = 0;
        // foreach ($options as $key => $id) {
        //     $exist = DB::table('question_options')->where('id', $id)->first();

        //     $image =  $images[$key];
        //     if ($image != null) {
        //         $extension = $image->getClientOriginalExtension();
        //         $filename = pathinfo($image, PATHINFO_FILENAME);
        //         $imagename = $filename  . '.' . $extension;
        //         $image->move('uploads/optionimages/', $imagename);
        //     } else {
        //         $imagename = null;
        //     }

        //     if (!is_null($exist)) {
        //         DB::table('question_options')
        //             ->where('id', $id)
        //             ->update([
        //                 'question_id' => $question->id,
        //                 'option' => $options[$i],
        //                 'image' => $imagename,
        //             ]);
        //     } else {
        //         DB::table('question_options')
        //             ->insert([
        //                 'question_id' => $question->id,
        //                 'option' => $options[$i],
        //                 'image' => $imagename,
        //             ]);
        //     }
        //     $i++;
        // }

        return response()->json(["message" => "Question updated successfully", "id" => $question->id], 201);
    }



    public function addQuestionOptions(Request $request)
    {
        $rules = [
            'question_id' => 'required',
            'option' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $option = json_decode($request->input('option'), true);
        // return response()->json($option, 201);

        if ($option['option'] != null) {
            $option = new Option;
            $option->question_id = $request->input('question_id');
            $option->option = $option['option'];

            if ($request->hasFile('image')) {
                $image =  $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = pathinfo($image, PATHINFO_FILENAME);
                $imagename = $filename . '.' . $extension;
                $image->move('uploads/optionimages/', $imagename);
                $option->image = $imagename;
            }

            $option->save();
        }

        return response()->json(["message" => "Question added successfully"], 201);
    }

    public function updateQuestionOptions(Request $request)
    {
        $rules = [
            'question_id' => 'required',
            'option' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $option = collect(json_decode($request->input('option'), true));

        $requested_ids = $option->pluck('id')->toArray();

        $existingQuestionOptions = QuestionOptions::where('question_id', $request->question_id)->pluck('id')->toArray();
        $deletableIds = array_diff($existingQuestionOptions, $requested_ids);


        if (!is_null($deletableIds)) {
            foreach ($deletableIds as $deletableId) {
                DB::table('question_options')->where('id', $deletableId)->delete();
            }
        }

        foreach ($option as $key => $value) {

            if (isset($option[$key]['id'])) {
                // return response()->json('updating question options', 201);
                $existingOption = QuestionOptions::where('id', $option[$key]['id'])->first();
                $existingOption->question_id = $request->question_id;
                $existingOption->option = $option[$key]['option'];

                if ($request->hasFile('image' . str_replace(' ', '_', $option[$key]['option']))) {
                    $image = $request->file('image' . str_replace(' ', '_', $option[$key]['option']));
                    $extension = $image->getClientOriginalExtension();
                    $imagename = pathinfo($image, PATHINFO_FILENAME);
                    $filename =  $imagename  . '.' . $extension;
                    $image->move('uploads/optionimages/', $filename);
                    $existingOption->image = $filename;
                }
                $existingOption->save();
            } else {
                // return response()->json('adding question options', 201);

                $newoption = new QuestionOptions;
                $newoption->question_id = $request->question_id;
                $newoption->option = $option[$key]['option'];

                if ($request->hasFile('image' . str_replace(' ', '_', $option[$key]['option']))) {
                    $image = $request->file('image' . str_replace(' ', '_', $option[$key]['option']));
                    $extension = $image->getClientOriginalExtension();
                    $imagename = pathinfo($image, PATHINFO_FILENAME);
                    $filename =  $imagename  . '.' . $extension;
                    $image->move('uploads/optionimages/', $filename);
                    $newoption->image = $filename;
                }

                $newoption->save();
            }
        }
        return response()->json(["message" => "Question added successfully"], 201);
    }

    public function removeFeaturedImage($id)
    {
        $question = Question::findOrFail($id);
        $oldImagePath = public_path("/uploads/featuredImages/$question->featuredImage");
        unlink($oldImagePath);
        $question->featuredImage = null;
        $question->save();

        return response()->json(["message" => "Featured image deleted successfully"], 201);
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json(["message" => "Question deleted successfully"], 201);
    }

    public function getQuestion($id, $userId)
    {
        $question = Question::where('id', '=', $id)->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->first();
        return response()->json($question, 200);
    }

    public function recentQuestions($userId, $offset)
    {
        $questions = Question::where([['status', '=', '1'], ['asking', '=', null]])
            ->with('answers')
            ->with('user')
            ->with('category')
            ->with('tags')
            ->with('options')
            ->withCount('answers as answersCount')
            ->withCount('userOptions as userOptionsCount')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))
            ->orderBy('created_at', 'DESC')
            ->paginate($offset);
        return response()->json($questions, 200);
    }

    public function mostAnsweredQuestions($userId, $offset)
    {
        $questions = Question::where([['status', '=', '1'], ['asking', '=', null]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->orderBy('answersCount', 'DESC')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->paginate($offset);
        return response()->json($questions, 200);
    }

    public function mostVisitedQuestions($userId, $offset)
    {
        $questions = Question::where([['status', '=', '1'], ['asking', '=', null]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->orderBy('views', 'DESC')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->paginate($offset);
        return response()->json($questions, 200);
    }

    public function noAnsweredQuestions($userId, $offset)
    {
        $questions = Question::where([['status', '=', '1'], ['asking', '=', null]])->with('answers')->whereDoesntHave('answers')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->paginate($offset);
        return response()->json($questions, 200);
    }

    public function mostVotedQuestions($userId, $offset)
    {
        $questions = Question::where([['status', '=', '1'], ['asking', '=', null]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->orderBy('votes', 'DESC')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->paginate($offset);
        return response()->json($questions, 200);
    }

    public function getQuestionByCategory($catId, $userId, $offset)
    {
        $questions = Question::where([['category_id', '=', $catId], ['status', '=', '1'], ['asking', '=', null]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->paginate($offset);
        return response()->json($questions, 200);
    }


    public function getQuestionByTag($tag, $userId, $offset)
    {
        $questions = Question::leftjoin('question_tags', 'question_tags.question_id', 'questions.id')->where([['question_tags.tag', $tag], ['status', '=', '1'], ['asking', '=', null]])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->paginate($offset);
        return response()->json($questions, 200);
    }


    public function getQuestionPollOptions($catId, $offset)
    {
        $questions = Question::where([['category_id', '=', $catId], ['status', '=', '1']])->with('answers')->withCount('answers as answersCount')->with('user')->with('category')->with('tags')->with('options')->paginate($offset);
        return response()->json($questions, 200);
    }

    public function updateQuestionViews($id)
    {
        $question = Question::find($id);
        $question->views = $question->views + 1;
        $question->update();
        return response()->json(['message' => 'Question Views Updated'], 200);
    }

    public function voteQuestion(Request $request)
    {
        $questionId = $request->input('question_id');
        $userId = $request->input('user_id');
        $vote = $request->input('vote');

        $author_id = Question::find($questionId)->author_id;
        $userName = User::find($userId)->displayname;

        if ($vote == 1) {
            $alreadyVotedUp = DB::table('question_votes')->where(['question_id' => $questionId, 'user_id' => $userId, "vote" => 1])->first();
            if ($alreadyVotedUp) {
                return response()->json(['message' => 'Sorry, you cannot vote on the same question more than once'], 201);
            }

            $exist = DB::table('question_votes')->where(['question_id' => $questionId, 'user_id' => $userId, "vote" => -1])->first();
            if ($exist) {
                DB::table('question_votes')->where(['question_id' => $questionId, 'user_id' => $userId])->update(['vote' => 0]);
            } else {
                DB::table('question_votes')->insert(['question_id' => $questionId, 'user_id' => $userId, 'vote' => 1]);
                event(new SendPushNotificationEvent($author_id, config('app.name'), $userName . ' has voted up your question.', $request->question_id, null));
            }
        } else if ($vote == -1) {
            $alreadyVotedDown = DB::table('question_votes')->where(['question_id' => $questionId, 'user_id' => $userId, "vote" => -1])->first();
            if ($alreadyVotedDown) {
                return response()->json(['message' => 'Sorry, you cannot vote on the same question more than once'], 201);
            }

            $exist = DB::table('question_votes')->where(['question_id' => $questionId, 'user_id' => $userId, "vote" => 1])->first();
            if ($exist) {
                DB::table('question_votes')->where(['question_id' => $questionId, 'user_id' => $userId])->update(['vote' => 0]);
            } else {
                DB::table('question_votes')->insert(['question_id' => $questionId, 'user_id' => $userId, 'vote' => -1]);
                event(new SendPushNotificationEvent($author_id, config('app.name'), $userName . ' has voted down your question.', $request->question_id, null));
            }
        }

        $votes = QuestionVote::where('question_id', '=', $questionId)->sum('vote');
        $question = Question::where('id', $questionId)->first();
        $question->update(['votes' => $votes]);

        if ($vote == 1)
            event(new UserPointsUpdatedEvent($question->author_id, Point::find(5)->points));
        else
            event(new UserPointsUpdatedEvent($question->author_id, -Point::find(5)->points));

        return response()->json(['message' => 'Voting added succesfully'], 201);
    }

    public function getQuestionVotes($id)
    {
        $votes = QuestionVote::where('question_id', '=', $id)->sum('vote');
        if (is_null($votes)) {
            return response()->json(["message" => "No question found!"], 404);
        }
        return response()->json((int)$votes, 200);
    }

    public function submitOption(Request $request)
    {
        $questionId = $request->input('question_id');
        $userId = $request->input('user_id');
        $optionId = $request->input('option_id');

        DB::table('question_user_options')->insert(['question_id' => $questionId, 'user_id' => $userId, 'option_id' => $optionId]);
        DB::table('question_options')->where([['question_id', $questionId], ['id', $optionId]])->update(['votes' => DB::raw('votes + 1')]);

        return response()->json(['message' => 'Answer submitted succesfully'], 201);
    }

    public function checkIfOptionSelected(Request $request)
    {
        $questionId = $request->input('question_id');
        $userId = $request->input('user_id');

        $option = DB::table('question_user_options')->where(['question_id' => $questionId, 'user_id' => $userId])->first();
        if ($option != null) {
            return response()->json(["option_id" => $option->option_id], 201);
        } else {
            return response()->json(["option_id" => 0], 201);
        }
    }

    public function displayVoteResult(Request $request)
    {
        $questionId = $request->input('question_id');
        $userId = $request->input('user_id');

        $votesCount = DB::table('question_options')->where([['question_id', $questionId]])->sum('votes');
        $options =  DB::table('question_options')->where([['question_id', $questionId]])->get();

        return response()->json(["options" =>  $options, "votesCount" => (int)$votesCount], 201);
    }

    public function search($userId, $title)
    {
        $user = Question::whereRaw("title like '%$title%'")->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->get();
        if (is_null($user)) {
            return response()->json(["message" => "No question found!"], 404);
        }
        return response()->json($user, 200);
    }

    public function categorysearch($userId, $title)
    {
        $user = Question::whereHas('category', function ($q) use ($title) {
            $q->whereRaw("name like '%$title%'");
        })->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->get();
        if (is_null($user)) {
            return response()->json(["message" => "No question found!"], 404);
        }
        return response()->json($user, 200);
    }

    public function tagsearch($userId, $title)
    {
        $user = Question::whereHas('tags', function ($q) use ($title) {
            $q->whereRaw("tag like '%$title%'");
        })->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->get();
        if (is_null($user)) {
            return response()->json(["message" => "No question found!"], 404);
        }
        return response()->json($user, 200);
    }

    public function addToFavorites(Request $request)
    {
        $questionId = $request->input('question_id');
        $userId = $request->input('user_id');

        $isFavorite = DB::table('question_favorites')->where(['user_id' => $userId, 'question_id' => $questionId])->first();
        if (is_null($isFavorite)) {
            DB::table('question_favorites')->insert(['user_id' => $userId, 'question_id' => $questionId]);
            return response()->json(['message' => 'Question added to favorites'], 201);
        } else {
            DB::table('question_favorites')->where(['user_id' => $userId, 'question_id' => $questionId])->delete();
            return response()->json(['message' => 'Question removed from favorites'], 201);
        }
    }

    public function getUserFavorites($userId, $offset)
    {
        $questions = Question::leftJoin('question_favorites', 'questions.id', 'question_favorites.question_id')->where(['user_id' => $userId])->with('answers')->withCount('answers as answersCount')->withCount('userOptions as userOptionsCount')->with('user')->with('category')->with('tags')->with('options')
            ->withCount(array('favorite as favorite' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }))
            ->withCount(array('votes as votes' => function ($query) {
                $query->select(DB::raw("SUM(vote)"));
            }))->paginate($offset);
        return response()->json($questions, 200);
    }

    public function checkIfIsFavorite($userId, $questionId)
    {
        $exist = DB::table('question_favorites')->where([['user_id', $userId], ['question_id', $questionId]])->first();
        if ($exist) {
            return response()->json(["favorite" => true], 200);
        } else {
            return response()->json(["favorite" => false], 200);
        }
    }

    public function setAsBestAnswer(Request $request)
    {
        $question =  Question::where('id', $request->question_id)->first();
        $question->bestAnswer = $request->answer_id;
        $question->update();

        $comment = Comment::where('id', $request->answer_id)->first();
        event(new UserPointsUpdatedEvent($comment->author_id, Point::find(2)->points));
        $user = User::find($comment->author_id);
        $user->best_answers += 1;
        $user->save();

        return response()->json(["message" => "The Answer was set as Best Successfully"], 200);
    }
}
