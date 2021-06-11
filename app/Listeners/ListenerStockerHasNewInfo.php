<?php

namespace IAServer\Listeners;

use IAServer\Events\StockerHasNewInfo;

class ListenerSendStockerInfoToRedis
{
    public function __construct()
    {
        //
    }

    public function handle(StockerHasNewInfo $event)
    {
        $barcode = $event->stocker->barcode;
        $canal = "stocker:event:$barcode:info";
        try
        {
            \LRedis::set($canal,$event->stocker);
            \LRedis::expire($canal,500);
            \LRedis::publish($canal,$event->stocker);

            return 'done';
        } catch(\Exception $e)
        {
            return ['rediserror'=>$e->getMessage()];
        }
    }
}
