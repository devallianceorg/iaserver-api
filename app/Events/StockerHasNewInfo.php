<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class StockerHasNewInfo extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $stocker;

    public function __construct($stocker)
    {
        $this->stocker = $stocker;
    }

    public function broadcastOn()
    {
        $barcode = $this->stocker->barcode;
        return ["stocker:broadcast:$barcode:info"];
    }

    public function onQueue()
    {
        return 'low';
    }
}
