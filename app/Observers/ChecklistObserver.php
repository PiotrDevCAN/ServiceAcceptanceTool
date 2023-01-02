<?php

namespace App\Observers;

use Illuminate\Support\Facades\Mail;
use App\Models\Checklist;
use App\Observers\Traits\UserData;
use App\Mail\Checklist\Created;
use App\Mail\Checklist\Updated;
use App\Mail\Checklist\Saved;
use App\Mail\Checklist\Deleted;
use App\Models\ChecklistCategory;
use App\Models\ChecklistService;
use App\Models\Service;
use App\Models\ServiceCategory;

use function PHPUnit\Framework\isNull;

class ChecklistObserver
{
    use UserData;

    /**
     * Handle the Checklist "created" event.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return void
     */
    public function created(Checklist $checklist)
    {
        if (is_null($checklist->duplicated_from)) {

            // possible functions for relations
            // with
            // has
            // whereHas
            // orWhereHas

            /*
            $type = $checklist->type;

            // Create Checklist Categories
            $serviceCategories = ServiceCategory::whereType($type)
                ->get();
            $serviceCategories->each(function ($item, $key) use ($checklist) {
                $category = new ChecklistCategory;
                $category->checklist_id = $checklist->id;
                $category->category_id = $item->id;
                $category->in_scope = ServiceCategory::IN_SCOPE_NO;
                $category->status = ServiceCategory::STATUS_NOT_COMPLETE;
                $category->save();
            });

            // Create Checklist Services
            $services = Service::whereHas('category', function ($query) use($type) {
                $query->where('service_categories.type', $type);
            })
                ->get();
            $services->each(function ($item, $key) use ($checklist) {
                $service = new ChecklistService;
                $service->checklist_id = $checklist->id;
                $service->service_id = $item->id;
                $service->status = Service::IN_SCOPE_NOT_IN_SCOPE;
                $service->evidence = '';
                $service->completition_date = '';
                $service->user_input = '';
                $service->save();
            });
            */

        } else {

            $sourceChecklist = Checklist::find($checklist->duplicated_from);

            // load required relations
            $sourceChecklist->load('checklistCategories', 'checklistServices');

            // Copy assigned Checklist Categories
            $categories = $sourceChecklist->checklistCategories;
            foreach ($categories as $category) {
                $newCategory = $category->replicate([
                    'category'
                ]);
                $newCategory->checklist_id = $checklist->id;
                $newCategory->save();
            }

            // Copy assigned Checklist Services
            $services = $sourceChecklist->checklistServices;
            foreach ($services as $service) {
                $newService = $service->replicate([
                    'service'
                ]);
                $newService->checklist_id = $checklist->id;
                $newService->save();
            }
        }

        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Created($checklist));
    }

    /**
     * Handle the Checklist "updated" event.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return void
     */
    public function updated(Checklist $checklist)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Updated($checklist));
    }

    public function saved(Checklist $checklist)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Saved($checklist));
    }

    /**
     * Handle the Checklist "deleted" event.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return void
     */
    public function deleted(Checklist $checklist)
    {
        $to = $this->getUser();
        Mail::to($to)
        //             ->cc($moreUsers)
        //             ->bcc($evenMoreUsers)
        ->send(new Deleted($checklist));

        // Delete Checklist Services
        $checklist->checklistServices->each->delete();

        // Delete Checklist Categories
        $checklist->checklistCategories->each->delete();
    }

    /**
     * Handle the Checklist "restored" event.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return void
     */
    public function restored(Checklist $checklist)
    {
        //
    }

    /**
     * Handle the Checklist "force deleted" event.
     *
     * @param  \App\Models\Checklist  $checklist
     * @return void
     */
    public function forceDeleted(Checklist $checklist)
    {
        //
    }
}
