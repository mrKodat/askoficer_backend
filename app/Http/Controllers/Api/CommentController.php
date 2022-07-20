<?php

namespace App\Http\Controllers\Api;

use App\Events\SendPushNotificationEvent;
use App\Events\UserPointsUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentVote;
use App\Models\Point;
use App\Models\Question;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->type = $request->type;
        $comment->author_id = $request->author_id;
        $comment->question_id = $request->question_id;
        $comment->content = $request->content;
        $comment->anonymous = $request->anonymous;
        $comment->answer_id = $request->answer_id;
        $comment->save();

        if ($request->type == 'Answer')
            return response()->json(["message" => "Answer submitted successfully"], 201);
        else if ($request->type == 'Reply')
            return response()->json(["message" => "Reply submitted successfully"], 201);
    }

    public function addComment(Request $request)
    {
        $rules = [
            'author_id' => 'required',
            'question_id' => 'required',
            'content' => 'required',
            'type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $comment = new Comment;
        $comment->author_id = $request->input('author_id');
        $comment->question_id = $request->input('question_id');
        $comment->content = $request->input('content');
        $comment->anonymous = $request->anonymous;
        $comment->type = $request->input('type');
        $comment->answer_id = $request->input('answer_id');

        if ($request->hasFile('featuredImage')) {
            $image =  $request->file('featuredImage');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $image->move('uploads/featuredImages/', $filename);
            $comment->featuredImage = $filename;
        }

        $comment->save();

        $userName = User::find($request->author_id)->displayname;
        $author_id = Question::find($request->question_id)->author_id;

        event(new UserPointsUpdatedEvent($request->author_id, Point::find(3)->points));

        if ($request->type == 'Answer') {
            if ($author_id != $request->author_id) {
                event(new SendPushNotificationEvent($author_id, config('app.name'), $userName . ' has answered your question.', $request->question_id, null));
                DB::table('panel_notifications')->insert(["message" => "A new comment with id $comment->id has been published", "url" => url('') . "/answers"]);
            }
            return response()->json(["message" => "Answer submitted successfully"], 201);
        } else if ($request->type == 'Reply') {
            if ($author_id != $request->author_id) {
                event(new SendPushNotificationEvent($author_id, config('app.name'), $userName . ' replied to your answer.', $request->question_id, null));
                DB::table('panel_notifications')->insert(["message" => "A new reply with id $comment->id has been published", "url" => url('') . "/replies"]);
            }
            return response()->json(["message" => "Reply submitted successfully"], 201);
        }
    }

    public function voteComment(Request $request)
    {
        $commentId = $request->input('comment_id');
        $userId = $request->input('user_id');
        $vote = $request->input('vote');

        $author_id = Comment::find($commentId)->author_id;
        $userName = User::find($userId)->displayname;

        if ($vote == 1) {
            $alreadyVotedUp = DB::table('comment_votes')->where(['comment_id' => $commentId, 'user_id' => $userId, "vote" => 1])->first();
            if ($alreadyVotedUp) {
                return response()->json(['message' => 'Sorry, you cannot vote on the same answer more than once'], 201);
            }

            $exist = DB::table('comment_votes')->where(['comment_id' => $commentId, 'user_id' => $userId, "vote" => -1])->first();
            if ($exist) {
                DB::table('comment_votes')->where(['comment_id' => $commentId, 'user_id' => $userId])->update(['vote' => 0]);
            } else {
                DB::table('comment_votes')->insert(['comment_id' => $commentId, 'user_id' => $userId, 'vote' => 1]);
                event(new SendPushNotificationEvent($author_id, config('app.name'), $userName . ' has voted up your answer.', $request->question_id, null));
            }
        } else if ($vote == -1) {
            $alreadyVotedDown = DB::table('comment_votes')->where(['comment_id' => $commentId, 'user_id' => $userId, "vote" => -1])->first();
            if ($alreadyVotedDown) {
                return response()->json(['message' => 'Sorry, you cannot vote on the same answer more than once'], 201);
            }

            $exist = DB::table('comment_votes')->where(['comment_id' => $commentId, 'user_id' => $userId, "vote" => 1])->first();
            if ($exist) {
                DB::table('comment_votes')->where(['comment_id' => $commentId, 'user_id' => $userId])->update(['vote' => 0]);
            } else {
                DB::table('comment_votes')->insert(['comment_id' => $commentId, 'user_id' => $userId, 'vote' => -1]);
                event(new SendPushNotificationEvent($author_id, config('app.name'), $userName . ' has voted down your answer.', $request->question_id, null));
            }
        }

        $votes = CommentVote::where('comment_id', '=', $commentId)->sum('vote');
        $comment = Comment::where('id', $commentId)->update(['votes' => $votes]);

        $question = Question::where('id', $comment->question_id)->first();
        if ($vote == 1)
            event(new UserPointsUpdatedEvent($question->author_id, Point::find(6)->points));
        else
            event(new UserPointsUpdatedEvent($question->author_id, -Point::find(6)->points));

        return response()->json(['message' => 'Voting added succesfully'], 201);
    }

    public function getCommentVotes($id)
    {
        $votes = CommentVote::where('comment_id', '=', $id)->sum('vote');
        if (is_null($votes)) {
            return response()->json(["message" => "No comment found!"], 404);
        }
        return response()->json((int)$votes, 200);
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(["message" => "Comment deleted successfully"], 201);
    }
}
