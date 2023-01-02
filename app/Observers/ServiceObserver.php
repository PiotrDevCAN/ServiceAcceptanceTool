<?php

namespace App\Observers;

use Illuminate\Support\Facades\Mail;
use App\Models\Service;
use App\Observers\Traits\UserData;
use App\Mail\Service\Created;
use App\Mail\Service\Updated;
use App\Mail\Service\Saved;
use App\Mail\Service\Deleted;

class ServiceObserver
{
    use UserData;

    /**
     * Handle the Service "created" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function created(Service $service)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Created($service));
    }

    /**
     * Handle the Service "updated" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function updated(Service $service)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Updated($service));
    }

    public function saved(Service $service)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Saved($service));
    }

    /**
     * Handle the Service "deleted" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function deleted(Service $service)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Deleted($service));

        // Delete Checklist Services
        $service->checklistServices->each->delete();
    }

    /**
     * Handle the Service "restored" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function restored(Service $service)
    {
        //
    }

    /**
     * Handle the Service "force deleted" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function forceDeleted(Service $service)
    {
        //
    }
}
