<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AoicollectorEventInspection extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    public function broadcastOn()
    {
        return ['AoicollectorEventInspection'];
    }

    public function onQueue()
    {
        return 'low';
    }
}
