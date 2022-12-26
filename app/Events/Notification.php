<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class Notification implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    protected $userChannels;

    public function __construct()
    {
    }

    public function broadcastOn()
    {
      return new PrivateChannel('reload');
    }

    public function broadcastAs()
    {
      return 'notification-reload';
    }
}