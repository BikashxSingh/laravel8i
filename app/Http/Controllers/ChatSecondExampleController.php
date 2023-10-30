<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatSecondExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // select all users except logged in user
        // $users = User::where('id', '!=', Auth::id())->get();

        // count how many message are unread from the selected user
        $users = DB::select("select users.id, users.name, users.avatar, users.email, count(is_read) as unread 
        from users LEFT JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
        where users.id != " . Auth::id() . " 
        group by users.id, users.name, users.avatar, users.email");

        // $users = Message::where()
        return view('chat-second-example.home', ['users' => $users]);
    }

    public function getMessage($user_id)
    {
        // return $user_id;
        $my_id = Auth::id();
        $user = User::find($user_id);


        // Make read all unread message
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // Get all message from selected user
        // $messages = Message::where(['from' => $user_id, 'to' => $user_id])->get();
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            //received from other this user
            $query->where('from', $user_id);
            $query->where('to', $my_id);
        })->orWhere(function ($query) use ($my_id, $user_id) {
            //sent to other this user
            $query->where('from', $my_id);
            $query->where('to', $user_id);
        })->get();

        // dd($messages);  
        return view('chat-second-example.messages.index', [
            'messages' => $messages,
            'user' => $user,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        // $data = Message::create([
        //     'from' => $from,
        //     'to' => $to,
        //     'message' => $message,
        //     'is_read' => 0
        // ]);

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}
