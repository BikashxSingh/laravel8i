<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use App\Models\User;
use App\Models\Message;
use App\Events\ChatMessage;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Events\PersonalMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserListResource;
use App\Http\Resources\MessageListResource;

class ChatFirstExampleController extends Controller
{
    //
    public function __construct()
    {
        if (request()->is('api*')) {
            $this->middleware(['auth:api']);
        } else {
            $this->middleware('auth')->except('chat', 'chatSendMessage');
        }
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function chat()
    {
        // return view('chat-first-example.chat');
        if (request()->is('api/*')) {
            // return redirect()->json(['.data']);
        } else {
            return view('chat-first-example.chat');
        }
    }

    public function chatSendMessage(Request $request)
    {
        event(
            new ChatMessage(
                $request->input('username'),
                $request->input('message')
            )
        );
        return ["success" => true];
    }


    // public function chatPage()
    // {
    //     $users = User::take(10)->get();
    //     return view('chat-first-example.chat', ['users' => $users]);
    // }

    public function chatUsers()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        // $users = User::all();
        if (request()->is('api/*')) {
            return UserListResource::collection($users);
        } else {
            return view('chat-first-example.chat-users', compact('users'));
        }
    }

    // public function fetchMessage(Request $request)
    // {
    // }


    public function personalChat($id)
    {
        $my_id = Auth::id();
        $user_id = $id;
        $user = User::find($id);

        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // $user = User::where('id', $id)->with('messages')->first();
        // // return $user;
        // if (request()->is('api/*')) {
        //     return new UserResource($user);
        // } else {
        //     return view('chat-first-example.personal-chat', compact('user'));
        // }

        // $messagesSR = Message::where(['from'=> $user_id, 'to'=> $my_id])->orWhere(function ($query) use ($user_id, $my_id) {
        //     //sent from this user
        //     $query->where('from', $my_id);
        //     $query->where('to', $user_id);
        // })
        // // ->with('user')
        // ->get();

        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            //received from other this user
            $query->where('from', $user_id);
            $query->where('to', $my_id);
        })->orWhere(function ($query) use ($my_id, $user_id) {
            //sent to other this user
            $query->where('from', $my_id);
            $query->where('to', $user_id);
        })
            ->with('user')
            ->orderBy('to', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();


        // $receivedMessages = Message::where(function ($query) use ($user_id, $my_id) {
        //     //received from other this user
        //     $query->where('from', $user_id);
        //     $query->where('to', $my_id);
        // })
        // ->with('user')
        // ->get();
        // $sentMessages = Message::where(function ($query) use ($my_id, $user_id) {
        //     //sent to other this user
        //     $query->where('from', $my_id);
        //     $query->where('to', $user_id);
        // })
        // ->with('user')
        // ->get();

        // dd($messages);
        if (request()->is('api/*')) {
            //     return ['Sent' => MessageListResource::collection($sentMessages), 
            //     'Received' => MessageListResource::collection($receivedMessages)
            // ];
            return MessageListResource::collection($messages);
        } else {
            // return view('chat-first-example.personal-chat', compact('sentMessage', 'receivedMessages'));
            return view('chat-first-example.personal-chat', compact('messages', 'user'));
        }
    }



    public function sendMessage(Request $request)
    {
        $message = [
            "to" => $request->userid,
            "from" => Auth::user()->id,
            //    "name" => Auth::user()->name,
            "message" => $request->message
        ];

        $messages = Message::create([
            'to' => $request->userid,
            'from' => Auth::user()->id,
            'message' => $request->message,
            'is_read' => 0
        ]);

        // dd(
        //     event(new PersonalMessage($message))
        // );
        event(new PersonalMessage($message));
        return "message sent";
    }







    /**
     * Fetch all messages
     *
     * @return Message
     */
    // public function fetchMessages()
    // {
    //     return Message::with('user')->get();
    // }

    // /**
    //  * Persist message to database
    //  *
    //  * @param  Request $request
    //  * @return Response
    //  */
    // public function sendMessage(Request $request, $toUser_Id)
    // {
    //     // dd($request->all());
    //     $fromUser = Auth::user();
    //     $toUser = User::where('id', $toUser_Id)->first();

    //     $message = Message::create([
    //         'from' => $fromUser->id,
    //         'to' => $toUser_Id,
    //         'message' => $request->input('message')
    //     ]);
    //     event(
    //         new PersonalMessage(
    //             $toUser,
    //             $request->input('message')
    //         )
    //     );
    //     // return ["success" => true];

    //     // broadcast(new PersonalMessage($fromUser, $message))->toOthers();
    //     // broadcast(new PersonalMessage($user, $message))->toOthers();


    //     return ['status' => 'Message Sent!'];
    // }

}
