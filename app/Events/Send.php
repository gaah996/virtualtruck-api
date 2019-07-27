<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Broadcasting\Channel;
use App\Freight;

class Send implements ShouldBroadcast {

    use SerializesModels;
    public $freight;
    public $user;

    public function __construct(Freight $freight) {
        $this->user = Auth::user();
        $this->freight = $freight;
    }

    public function broadcastOn() {
        return new Channel('Send');
    }

    public function broadcastAs(){
        return 'Send';
    }
}