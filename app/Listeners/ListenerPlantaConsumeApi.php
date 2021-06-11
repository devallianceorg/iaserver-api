<?php

namespace IAServer\Listeners;

use IAServer\Events\PlantaConsumeApi;
use IAServer\Jobs\JobAvisoDeLanzamiento;

class ListenerPlantaConsumeApi
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
    public function handle(PlantaConsumeApi $event)
    {		
//        $job = new JobAvisoDeLanzamiento($event->datos);
//        dispatch($job);
    }
}
