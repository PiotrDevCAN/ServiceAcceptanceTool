<?php

namespace App\Observers;

use Illuminate\Support\Facades\Mail;
use App\Models\ServiceCategory;
use App\Observers\Traits\UserData;
use App\Mail\ServiceCategory\Created;
use App\Mail\ServiceCategory\Updated;
use App\Mail\ServiceCategory\Saved;
use App\Mail\ServiceCategory\Deleted;

class ServiceCategoryObserver
{
    use UserData;

    /**
     * Handle the ServiceCategory "created" event.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return void
     */
    public function created(ServiceCategory $serviceCategory)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Created($serviceCategory));
    }

    /**
     * Handle the ServiceCategory "updated" event.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return void
     */
    public function updated(ServiceCategory $serviceCategory)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Updated($serviceCategory));
    }

    public function saved(ServiceCategory $serviceCategory)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Saved($serviceCategory));
    }

    /**
     * Handle the ServiceCategory "deleted" event.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return void
     */
    public function deleted(ServiceCategory $serviceCategory)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Deleted($serviceCategory));

        // Reassign Checklist Services to General category
        $serviceCategory->children->each->update(['parent_id' => 0]);

        // Reassing Services to General category
        $serviceCategory->services->each->update(['category_id' => 0]);

        // Delete Checklist Categories
        $serviceCategory->checklistCategories->each->delete();
    }

    /**
     * Handle the ServiceCategory "restored" event.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return void
     */
    public function restored(ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Handle the ServiceCategory "force deleted" event.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return void
     */
    public function forceDeleted(ServiceCategory $serviceCategory)
    {
        //
    }
}
