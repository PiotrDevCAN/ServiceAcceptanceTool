<?php

namespace App\Listeners\Request;

use App\Events\OvertimeRequestSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOvertimeRequestSubmittedNotification
{
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
     * @param  OvertimeRequestSubmitted  $event
     * @return void
     */
    public function handle(OvertimeRequestSubmitted $event)
    {
        $to = 'RECIPIENT_PERSON';
        Mail::to($to)
//             ->cc($moreUsers)
//             ->bcc($evenMoreUsers)
            ->send(new \App\Mail\Request\OvertimeRequestSubmitted($event->request));
    }
}
