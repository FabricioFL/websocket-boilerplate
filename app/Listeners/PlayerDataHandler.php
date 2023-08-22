<?php

namespace App\Listeners;

use App\Events\PlayerDataEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PlayerDataHandler
{
    /**
     * Handle the event.
     */
    public function handle(PlayerDataEvent $event): void
    {
        broadcast(new PlayerDataEvent($event->Data))->toOthers();
    }
}
