<?php

namespace App\Observers;

use Illuminate\Support\Facades\Mail;
use App\Models\ServiceSection;
use App\Observers\Traits\UserData;
use App\Mail\ServiceSection\Created;
use App\Mail\ServiceSection\Updated;
use App\Mail\ServiceSection\Saved;
use App\Mail\ServiceSection\Deleted;

class ServiceSectionObserver
{
    use UserData;

    /**
     * Handle the ServiceSection "created" event.
     *
     * @param  \App\Models\ServiceSection  $serviceSection
     * @return void
     */
    public function created(ServiceSection $serviceSection)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Created($serviceSection));
    }

    /**
     * Handle the ServiceSection "updated" event.
     *
     * @param  \App\Models\ServiceSection  $serviceSection
     * @return void
     */
    public function updated(ServiceSection $serviceSection)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Updated($serviceSection));
    }

    public function saved(ServiceSection $serviceSection)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Saved($serviceSection));
    }

    /**
     * Handle the ServiceSection "deleted" event.
     *
     * @param  \App\Models\ServiceSection  $serviceSection
     * @return void
     */
    public function deleted(ServiceSection $serviceSection)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Deleted($serviceSection));

        // Reassing Services to General section
        $serviceSection->services->each->update(['section_id' => 0]);
    }

    /**
     * Handle the ServiceSection "restored" event.
     *
     * @param  \App\Models\ServiceSection  $serviceSection
     * @return void
     */
    public function restored(ServiceSection $serviceSection)
    {
        //
    }

    /**
     * Handle the ServiceSection "force deleted" event.
     *
     * @param  \App\Models\ServiceSection  $serviceSection
     * @return void
     */
    public function forceDeleted(ServiceSection $serviceSection)
    {
        //
    }
}
