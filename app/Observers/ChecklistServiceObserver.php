<?php

namespace App\Observers;

use Illuminate\Support\Facades\Mail;
use App\Models\ChecklistService;
use App\Observers\Traits\UserData;
use App\Mail\ChecklistService\Created;
use App\Mail\ChecklistService\Updated;
use App\Mail\ChecklistService\Saved;
use App\Mail\ChecklistService\Deleted;

class ChecklistServiceObserver
{
    use UserData;

    /**
     * Handle the ChecklistService "created" event.
     *
     * @param  \App\Models\ChecklistService  $checklistService
     * @return void
     */
    public function created(ChecklistService $checklistService)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Created($checklistService));
    }

    /**
     * Handle the ChecklistService "updated" event.
     *
     * @param  \App\Models\ChecklistService  $checklistService
     * @return void
     */
    public function updated(ChecklistService $checklistService)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Updated($checklistService));
    }

    public function saved(ChecklistService $checklistService)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Saved($checklistService));
    }

    /**
     * Handle the ChecklistService "deleted" event.
     *
     * @param  \App\Models\ChecklistService  $checklistService
     * @return void
     */
    public function deleted(ChecklistService $checklistService)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Deleted($checklistService));
    }

    /**
     * Handle the ChecklistService "restored" event.
     *
     * @param  \App\Models\ChecklistService  $checklistService
     * @return void
     */
    public function restored(ChecklistService $checklistService)
    {
        //
    }

    /**
     * Handle the ChecklistService "force deleted" event.
     *
     * @param  \App\Models\ChecklistService  $checklistService
     * @return void
     */
    public function forceDeleted(ChecklistService $checklistService)
    {
        //
    }
}
