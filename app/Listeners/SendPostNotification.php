<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\PostCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendPostNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
        Notification::route('mail', 'priyanshu@gmail.com')
            ->notify( new PostCreatedNotification($event->post) );
    }
}
