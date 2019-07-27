<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Broadcasting\PresenceChannel;
use App\Freight;

class Send implements ShouldBroadcast {

    use SerializesModels;
    public $freight;
    public $user;
    public $driver;

    public function __construct(Freight $freight) {
        $this->freight = $freight;
        $this->user = Auth::user();
    }

    public function broadcastOn() {
        return new PresenceChannel('map');
    }
}