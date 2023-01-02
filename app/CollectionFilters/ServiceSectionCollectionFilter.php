<?php

namespace App\CollectionFilters;

use Throwable;
use Touhidurabir\Filterable\Bases\BaseCollectionFilter;
use Illuminate\Support\Collection;

class ServiceSectionCollectionFilter extends BaseCollectionFilter {

    /**
     * Retrieve the rules to validate filters value.
     * If a filter validation fails, the filter is not applied.
     *
     * @return array
     */
    protected function getRules() {
        
        return [];
    }

    
}