<?php

namespace App\Services;

use App\Models\Checklist;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Services\Contracts\MainCategoriesServiceInterface;

// class MainCategoriesService implements MainCategoriesServiceInterface {
class MainCategoriesService {

    public function prepareMainCategories(Checklist $checklist, ServiceCategory $category = null)
    {
        // Example 1
        // $articles = Article::query()->where('active', true)
        // ->when($onlyUnread, function (Builder $query): Builder {
        //     return $query->where('unread', true);
        // })
        // ->get();

        // Example 2
        // $articles = Article::query()->where('active', true)
        // ->when($myCondition, function (Builder $query) use ($param1, $param2): Builder {
        //     return $query->where('unread', true)
        //         ->orWhere('param1', $param1)
        //         ->orWhere('param2', $param2);
        // })
        // ->get();

        // $checklistId = $checklist->id;
        // $mainCategories = ServiceCategory::with(['services', 'checklists'])
        //     ->with(['checklists' => function ($query) use($checklistId) {
        //         $query->where('checklist_categories.checklist_id', $checklistId);
        //     }])
        //     ->whereType($checklist->type)
        //     ->orderBy('sequence', 'asc')
        //     ->get();

        $query = ServiceCategory::with(['parent', 'services'])
            // ->withCount(['services as servicesYes' => function ($query) use($checklistId) {
            //     $query->where('checklist_services.checklist_id', $checklistId);
            //     $query->where('checklist_services.status', 'Yes');
            // }])
            // ->withCount(['services as servicesNo' => function ($query) use($checklistId) {
            //     $query->where('checklist_services.checklist_id', $checklistId);
            //     $query->where('checklist_services.status', 'No');
            // }])
            ->whereType($checklist->type);
            if ($category !== null) {
                $query->whereId($category->id);
            }
            $query->orderBy('sequence', 'asc');

            $mainCategories = $query->get();

        // load required relations
        // $checklist->load('categories', 'services');

        // an existing checklist should have assigned categories
        $checklistCategories = $checklist->categories;

        // an existing checklist should have assigned services
        $checklistServices = $checklist->services;

        // check if a specific main category is assigned to current checklist
        $mainCategories->each(function ($mainCategory, $key) use ($checklistCategories, $checklistServices) {

            if ($checklistCategories->contains($mainCategory)) {
                // dump('object found');
                $checklistCategory = $checklistCategories->find($mainCategory);
                $mainCategory->pivot_id = $checklistCategory->pivot->id;
                $mainCategory->status = $checklistCategory->pivot->status;
                $mainCategory->in_scope = $checklistCategory->pivot->in_scope;
            } else {
                // dump('object not found');
                $mainCategory->pivot_id = '';
                $mainCategory->status = ServiceCategory::STATUS_NOT_COMPLETE;
                $mainCategory->in_scope = ServiceCategory::IN_SCOPE_NO;
            }

            $mainCategory->services_in_scope_yes = 0;
            $mainCategory->services_in_scope_no = 0;
            $mainCategory->services_not_in_scope = 0;
            $mainCategory->ready_to_complete = 0;

            $mainCategoryServices = $mainCategory->services;
            $mainCategoryServices->each(function ($mainCategoryService, $key) use ($mainCategory, $checklistServices) {

                if ($checklistServices->contains($mainCategoryService)) {
                    // dump('object found');
                    $checklistCategoryService = $checklistServices->find($mainCategoryService);
                    $mainCategoryService->pivot_id = $checklistCategoryService->pivot->id;
                    $mainCategoryService->status = $checklistCategoryService->pivot->status;
                    $mainCategoryService->evidence = $checklistCategoryService->pivot->evidence;
                    $mainCategoryService->completition_date = $checklistCategoryService->pivot->completition_date;
                    $mainCategoryService->user_input = $checklistCategoryService->pivot->user_input;

                    switch ($mainCategoryService->status) {
                        case ServiceCategory::IN_SCOPE_YES:
                            $mainCategory->services_in_scope_yes++;
                            break;
                        case ServiceCategory::IN_SCOPE_NO:
                            $mainCategory->services_in_scope_no++;
                            break;
                    }
                } else {
                    // dump('object not found');
                    $mainCategoryService->pivot_id = '';
                    $mainCategoryService->status = Service::IN_SCOPE_NOT_IN_SCOPE;
                    $mainCategoryService->evidence = '';
                    $mainCategoryService->completition_date = '';
                    $mainCategoryService->user_input = '';

                    $mainCategory->services_not_in_scope++;
                }

                if ($mainCategory->services_in_scope_yes > 0 && $mainCategory->services_in_scope_no == 0) {
                    $mainCategory->ready_to_complete = 1;
                } else {
                    $mainCategory->ready_to_complete = 0;
                }
            });
        });

        return array(
            'checklistCategories' => $checklistCategories,
            'checklistServices' => $checklistServices,
            'mainCategories' => $mainCategories
        );
    }
}
