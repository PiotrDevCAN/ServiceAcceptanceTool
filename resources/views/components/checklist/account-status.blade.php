<div class="ibm-fluid">
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
    <div class="ibm-col-12-12" style="display: none;">
        <div class="ibm-card">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <div class="ibm-fluid">
                    <div class="ibm-col-12-6">
                        <h4 class="ibm-h4">Categories</h4>

                        {{-- NEW FIELDS
                        <p>{{ $record->checklist_categories_completed_in_scope_yes_count }} </p>
                        <p>{{ $record->checklist_categories_completed_in_scope_no_count }} </p>
                        <p>{{ $record->checklist_categories_not_completed_in_scope_yes_count }} </p>
                        <p>{{ $record->checklist_categories_not_completed_in_scope_no_count }} </p> --}}

                        <p>The amount of Completed (In Scope): <b>
                            @if (!empty($record->checklist_categories_completed_in_scope_yes_count)) {{ $record->checklist_categories_completed_in_scope_yes_count }} @else 0 @endif
                        </b></p>
                        <p>The amount of Not Completed (In Scope): <b>
                            @if (!empty($record->checklist_categories_not_completed_in_scope_yes_count)) {{ $record->checklist_categories_not_completed_in_scope_yes_count }} @else 0 @endif
                        </b></p>
                        <p>The total amount of items:
                            <b>@if (!empty($record->checklist_categories_in_scope_yes_count)) {{ $record->checklist_categories_in_scope_yes_count }} @else 0 @endif </b> In Scope /
                            <b>@if (!empty($record->checklist_categories_in_scope_no_count)) {{ $record->checklist_categories_in_scope_no_count }} @else 0 @endif </b> Not In Scope /
                            <b>@if (!empty($record->categories_count)) {{ $record->categories_count }} @else 0 @endif </b> Overall
                        </p>
                        <hr>
                        @if (($record->checklist_categories_completed_in_scope_yes_count + $record->checklist_categories_not_completed_in_scope_yes_count) != 0)
                            <p>The percentage of completion: <b>{{ $record->category_completed_pct }} %</b></p>
                            <p>The percentage of remaining: <b>{{ $record->category_not_completed_pct }} %</b></p>
                        @else
                            <p>The percentage of completion: <b>0 %</b></p>
                            <p>The percentage of remaining: <b>0 %</b></p>
                        @endif
                    </div>
                    <div class="ibm-col-12-6">
                        <h4 class="ibm-h4">Services aka Questions</h4>
                        <p>The amount of Completed: <b>
                            @if (!empty($record->in_scope_yes_count)) {{ $record->in_scope_yes_count }} @else 0 @endif
                        </b></p>
                        <p>The amount of Not Completed: <b>
                            @if (!empty($record->in_scope_no_count)) {{ $record->in_scope_no_count }} @else 0 @endif
                        </b></p>
                        <p>The amount of Not In Scope: <b>
                            @if (!empty($record->not_in_scope_count)) {{ $record->not_in_scope_count }} @else 0 @endif
                        </b></p>
                        <p>The amount of Assigned Services: <b>
                            @if (!empty($record->services_count)) {{ $record->services_count }} @else 0 @endif
                        </b></p>
                        <hr>
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
                <h3 class="ibm-h4">Calculation Sheet</h3>
                @isset($mainCategoriesCalculation)
                    <x-checklist.table-calculation name="servicesCalculationTable" :records="$mainCategoriesCalculation"/>
                @endisset
            </div>
        </div>
    </div>
</div>
