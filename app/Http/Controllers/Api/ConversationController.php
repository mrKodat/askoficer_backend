<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $conversations = Conversation::where('userId', auth()->user()->id)->orWhere('secondUserId', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        $count = count($conversations);
        // $array = [];
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                if (isset($conversations[$i]->messages->last()->id) && isset($conversations[$j]->messages->last()->id) && $conversations[$i]->messages->last()->id < $conversations[$j]->messages->last()->id) {
                    $temp = $conversations[$i];
                    $conversations[$i] = $conversations[$j];
                    $conversations[$j] = $temp;
                }
            }
        }

        return ConversationResource::collection($conversations);
    }

    public function getConversation($userId)
    {

        $conversations = Conversation::where('userId', $userId)->orWhere('secondUserId', $userId)->orderBy('updated_at', 'desc')->get();
        $count = count($conversations);
        // $array = [];
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                if (isset($conversations[$i]->messages->last()->id) && isset($conversations[$j]->messages->last()->id) && $conversations[$i]->messages->last()->id < $conversations[$j]->messages->last()->id) {
                    $temp = $conversations[$i];
                    $conversations[$i] = $conversations[$j];
                    $conversations[$j] = $temp;
                }
            }
        }

        foreach ($conversations as $conversation) {
            $conversation->authId = $userId;
        }
        return ConversationResource::collection($conversations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    function makConversationAsReaded(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required',
        ]);

        $conversation = Conversation::findOrFail($request['conversation_id']);

        foreach ($conversation->messages as $message) {
            $message->update(['read' => true]);
        }

        return response()->json('success', 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'userId' => 'required',
            'message' => 'required'
        ]);
        $conversation = Conversation::create([

            'userId' => $request->userId,
            'secondUserId' => $request->secondUserId
        ]);
        Message::create([

            'body' => $request->message,
            'userId' => $request->userId,
            'conversation_id' => $conversation->id,
            'read' => false,
        ]);
        return new ConversationResource($conversation);
    }

    public function deleteConversation(Request $request)
    {
        Conversation::find($request->conversation_id)->delete();
        return response()->json('Conversation Deleted Successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
