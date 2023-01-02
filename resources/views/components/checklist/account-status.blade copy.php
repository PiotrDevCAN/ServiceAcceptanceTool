<div class="ibm-fluid">
    <div class="ibm-col-12-12">
        <div class="ibm-card">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-h4">Account Status</h3>
                <div class="ibm-fluid">
                    <div class="ibm-col-12-6">
                        <p>The amount of Completed: <b>
                        @if (!empty($record->in_scope_yes_count))
                            {{ $record->in_scope_yes_count }}
                        @elseif
                            0
                        @endif
                        </b></p>
                        <p>The amount of Not Completed: <b>
                        @if (!empty($record->in_scope_no_count))
                            {{ $record->in_scope_no_count }}
                        @elseif
                            0
                        @endif
                        </b></p>
                        <p>The amount of Not In Scope: <b>
                        @if (!empty($record->not_in_scope_count))
                            {{ $record->not_in_scope_count }}
                        @elseif
                            0
                        @endif
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
                <p>Completed: {{ $record->in_scope_yes_count }}</p>
                <p>Not Completed: {{ $record->in_scope_no_count }}</p>
                <p>Not in scope: {{ $record->not_in_scope_count }}</p>

                <p>Total of completed and not completed: {{ $record->in_scope_yes_count + $record->in_scope_no_count }}</p>
                @if (($record->in_scope_yes_count + $record->in_scope_no_count) != 0)
                <p>%of completed: {{ ($record->in_scope_yes_count / ($record->in_scope_yes_count + $record->in_scope_no_count)) * 100 }} %</p>
                <p>%of not completed: {{ ($record->in_scope_no_count / ($record->in_scope_yes_count + $record->in_scope_no_count)) * 100 }} %</p>
                @else
                <p>%of completed: 0 %</p>
                <p>%of not completed: 0 %</p>
                @endif

                <form id="accountStatus">
                    <input type="hidden" id="total_completed" name="total_completed" value="{{ $record->in_scope_yes_count }}"/>
                    <input type="hidden" id="total_not_completed" name="total_not_completed" value="{{ $record->in_scope_no_count }}"/>
                    <input type="hidden" id="total_not_in_scope" name="total_not_in_scope" value="{{ $record->not_in_scope_count }}"/>
                    <input type="hidden" id="total_in_scope" name="total_in_scope" value="{{ $record->in_scope_yes_count + $record->in_scope_no_count }}"/>
                    @if (($record->in_scope_yes_count + $record->in_scope_no_count) != 0)
                        <input type="hidden" id="total_completed_pct" name="total_completed_pct" value="{{ ($record->in_scope_yes_count / ($record->in_scope_yes_count + $record->in_scope_no_count)) * 100 }}"/>
                        <input type="hidden" id="total_not_completed_pct" name="total_not_completed_pct" value="{{ ($record->in_scope_no_count / ($record->in_scope_yes_count + $record->in_scope_no_count)) * 100 }}"/>
                    @else
                        <input type="hidden" id="total_completed_pct" name="total_completed_pct" value="0"/>
                        <input type="hidden" id="total_not_completed_pct" name="total_not_completed_pct" value="0"/>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
