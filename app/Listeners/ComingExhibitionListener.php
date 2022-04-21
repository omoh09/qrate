<?php

namespace App\Listeners;

use App\Events\ComingExhibition;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ComingExhibitionListener
{

    /**
     * @var string
     */
    public $queue = 'listeners';

    public $delay = 60;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ComingExhibition  $event
     * @return void
     */
    public function handle(ComingExhibition $event)
    {
        //
    }
}
