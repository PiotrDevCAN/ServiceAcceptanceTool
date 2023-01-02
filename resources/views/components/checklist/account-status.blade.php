<div class="ibm-fluid">
    <div class="ibm-col-12-12">
        <div class="ibm-card">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-h4">Account Status</h3>
                <div class="ibm-fluid">
                    <div class="ibm-col-12-6">
                        <p>The amount of Completed: <b>
                        @if (!empty($record->in_scope_yes_count)) {{ $record->in_scope_yes_count }} @else 0 @endif
                        </b></p>
                        <p>The amount of Not Completed: <b>
                        @if (!empty($record->in_scope_no_count)) {{ $record->in_scope_no_count }} @else 0 @endif
                        </b></p>
                        <p>The amount of Not In Scope: <b>
                        @if (!empty($record->not_in_scope_count)) {{ $record->not_in_scope_count }} @else 0 @endif
                        </b></p>
                    </div>
                    <div class="ibm-col-12-6">
                    @if (($record->in_scope_yes_count + $record->in_scope_no_count) != 0)
                        <p>The percentage of completion: <b>{{ $record->completed_pct }} %</b></p>
                        <p>The percentage of remaining: <b>{{ $record->not_completed_pct }} %</b></p>
                    @else
                        <p>The percentage of completion: <b>0 %</b></p>
                        <p>The percentage of remaining: <b>0 %</b></p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ibm-col-12-12">
        <div class="ibm-card">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-h4">Overall Status of items</h3>
                <div id="graphPieChart" class="graphPieChart"></div>
            </div>
        </div>
    </div>
    <div class="ibm-col-12-12">
        <div class="ibm-card">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-h4">Service Wise Status</h3>
                <div id="graphBarChart" class="graphBarChart"></div>
            </div>
        </div>
    </div>
    <div class="ibm-col-12-12">
        <div class="ibm-card">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-h4">Calculation Sheet</h3>
                @isset($mainCategoriesCalculation)
                    <x-checklist.table-calculation name="servicesCalculationTable" :records="$mainCategoriesCalculation"/>
                @endisset
            </div>
        </div>
    </div>
</div>
