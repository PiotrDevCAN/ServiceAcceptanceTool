<?php

namespace App\QueryFilters;

use Touhidurabir\Filterable\Bases\BaseQueryFilter;
use Illuminate\Database\Eloquent\Builder;

class ServiceSectionQueryFilter extends BaseQueryFilter {

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