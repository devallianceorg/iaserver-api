<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PlantaConsumeApi extends Event //implements ShouldBroadcast
{
    use SerializesModels;
    public $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    public function broadcastOn()
    {
        return ['PlantaConsumeApi'];
    }

    public function onQueue()
    {
        return 'low';
    }
}
