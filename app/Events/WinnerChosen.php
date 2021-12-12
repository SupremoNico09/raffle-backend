<?php

namespace App\Events;

use App\Models\Winners;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WinnerChosen implements ShouldBroadcastNow
{
  use Dispatchable, InteractsWithSockets, SerializesModels;



  public function __construct(public Winners $winner)
  {

  }

  public function broadcastOn()
  {
      return ['winners'];
  }

  public function broadcastAs()
  {
      return 'chosen';
  }
}