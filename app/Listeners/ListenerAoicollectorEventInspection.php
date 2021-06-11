<?php

namespace IAServer\Listeners;

use IAServer\Events\AoicollectorEventInspection;
use IAServer\Events\PlantaConsumeApi;
//use Illuminate\Support\Facades\Log;

class ListenerAoicollectorEventInspection
{
    public function __construct()
    {
        //
    }

    /**
     * Se pueden agregar varios Jobs a esta lista, para que se ejecuten cuando se consume el API
     *
     * @param PlantaConsumeApi $event
     */
    public function handle(AoicollectorEventInspection $event)
    {
        //Log::notice($event->datos);
    }
}
