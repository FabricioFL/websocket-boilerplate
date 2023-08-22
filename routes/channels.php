<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('connection', function(){
    return ['message' => 'ok'];
});

Broadcast::channel('player.{data}', function($xaxis, $yaxis){
    return ['message' => ['xaxis' => $xaxis,'yaxis' => $yaxis]];
});