<?php

namespace App\Events;

use App\Models\User;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PersonalMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // public $user;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message) //User $user, Message $message)
    {
        $this->message = $message;
        // $this->username = $user->username;
        // $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('personal-chat'.$this->message->to);
    }
    public function broadcastAs()
    {
        return 'data';
        // return 'message';

    }

    // public function broadcastWith()
    // {
    //     return (['username' => $this->username,
    //     'message' => $this->message
    //     ]);
    // }
}
