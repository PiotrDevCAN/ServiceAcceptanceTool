<?php

namespace App\Observers;

use Illuminate\Support\Facades\Mail;
use App\Models\ChecklistCategory;
use App\Observers\Traits\UserData;
use App\Mail\ChecklistCategory\Created;
use App\Mail\ChecklistCategory\Updated;
use App\Mail\ChecklistCategory\Saved;
use App\Mail\ChecklistCategory\Deleted;

class ChecklistCategoryObserver
{
    use UserData;

    /**
     * Handle the ChecklistCategory "created" event.
     *
     * @param  \App\Models\ChecklistCategory  $checklistCategory
     * @return void
     */
    public function created(ChecklistCategory $checklistCategory)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Created($checklistCategory));
    }

    /**
     * Handle the ChecklistCategory "updated" event.
     *
     * @param  \App\Models\ChecklistCategory  $checklistCategory
     * @return void
     */
    public function updated(ChecklistCategory $checklistCategory)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Updated($checklistCategory));
    }

    public function saved(ChecklistCategory $checklistCategory)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Saved($checklistCategory));
    }

    /**
     * Handle the ChecklistCategory "deleted" event.
     *
     * @param  \App\Models\ChecklistCategory  $checklistCategory
     * @return void
     */
    public function deleted(ChecklistCategory $checklistCategory)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Deleted($checklistCategory));
    }

    /**
     * Handle the ChecklistCategory "restored" event.
     *
     * @param  \App\Models\ChecklistCategory  $checklistCategory
     * @return void
     */
    public function restored(ChecklistCategory $checklistCategory)
    {
        //
    }

    /**
     * Handle the ChecklistCategory "force deleted" event.
     *
     * @param  \App\Models\ChecklistCategory  $checklistCategory
     * @return void
     */
    public function forceDeleted(ChecklistCategory $checklistCategory)
    {
        //
    }
}
