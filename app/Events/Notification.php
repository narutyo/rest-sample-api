<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class Notification implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    protected $userChannels;
    protected $targetModel;

    public function __construct($targetModel)
    {
      $this->targetModel = $targetModel;
      $users = User::all();
      foreach($users as $user) {
        $this->userChannels[] = 'private-App.Models.User.' . $user->uuid;
      }
    }

    public function broadcastOn()
    {
      return $this->userChannels;
    }

    public function broadcastWith()
    {
        return [
            'target' => $this->targetModel,
        ];
    }
}