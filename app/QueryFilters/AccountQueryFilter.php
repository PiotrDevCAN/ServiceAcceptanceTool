<?php

namespace App\QueryFilters;

use Touhidurabir\Filterable\Bases\BaseQueryFilter;
use Illuminate\Database\Eloquent\Builder;

class AccountQueryFilter extends BaseQueryFilter {

    /**
     * Retrieve the rules to validate filters value.
     * If a filter validation fails, the filter is not applied.
     *
     * @return array
     */
    protected function getRules() {

        return [];
    }

    /**
     * Filter by request param name
     *
     * @param  mixed $value
     * @return object<\Illuminate\Database\Eloquent\Builder>
     */
    public function name($value) {

        // return $this->builder->;
    }
}
