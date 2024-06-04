@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/serviceOverviewByChecklist.js')}}"></script>

<div class="ibm-fluid" id="serviceOverviewChecklist">
    <div class="ibm-col-12-12">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <form id="checklistAccountForm" class="ibm-column-form" method="post" action="">
                    <p class="ibm-h4 ibm-bold">Details of selected checklist</p>
                    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>
                    <div class="ibm-fluid">
                        <div class="ibm-col-12-6">
                            <p>
                                <label class="ibm-column-field-label">Checklist Name:</label>
                                <span class="ibm-bold">
                                    {{ $record->name }}
                                </span>
                            </p>
                            <p>
                                <label class="ibm-column-field-label">Checklist Type:</label>
                                <span class="ibm-bold">
                                    @foreach ($types as $key => $value)
                                        @if ($record->type == $value['type'])
                                            {{ $value['name'] }}
                                        @endif
                                    @endforeach
                                </span>
                            </p>
                            <p>
                                <label class="ibm-column-field-label">Account Name:</label>
                                <span class="ibm-bold">
                                    {{ $record->account->name }}
                                </span>
                            </p>
                            <p>
                                <label class="ibm-column-field-label">Transition State:</label>
                                <span class="ibm-bold">
                                    {{ $record->account->transition_state }}
                                </span>
                            </p>
                        </div>
                        <div class="ibm-col-12-6">
                            <p>
                                <label class="ibm-column-field-label">Go Live Date:</label>
                                <span class="ibm-bold">
                                    @empty($record->account->go_live_date)@else{{ $record->account->go_live_date->format('Y-m-d') }}@endempty
                                </span>
                            </p>
                            <p>
                                <label class="ibm-column-field-label">Account DPE:</label>
                                <span class="ibm-bold">
                                    <a href="mailto:{{ $record->account->account_dpe_intranet_id }}">{{ $record->account->account_dpe }}</a>
                                </span>
                            </p>
                            <p>
                                <label class="ibm-column-field-label">T&amp;T Focal:</label>
                                <span class="ibm-bold">
                                    <a href="mailto:{{ $record->account->tt_focal_intranet_id }}">{{ $record->account->tt_focal }}</a>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>
                    <div class="ibm-fluid">
                        <div class="ibm-col-12-6">
                            <p class="ibm-bold">To manage both Status and In Scope state of listed categories please visit an appropriate tab in the Check List page!</p>
                        </div>
                        <div class="ibm-col-12-6">
                            <p class="ibm-btn-row ibm-ind-link ibm-center">
                                <a id="services_overview" class="ibm-btn-pri ibm-edit-link ibm-btn-red-50" href="{{ route('checklist.edit', ['checklist' => $record->id]) }}#services-overview">Manage Check List Services</a>
                            </p>
                        </div>
                    </div>
                    <input type="hidden" id="checklist_id" name="checklist_id" value="{{ $record->id }}"/>
                    <input type="hidden" id="account_id" name="account_id" value="{{ $record->account->id }}"/>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="categories-overview" class="ibm-tabs-content">
    <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
        <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
            <div class="ibm-fluid">
                <div class="ibm-col-12-9">
                    <p class="ibm-h4 ibm-bold">List of all categories assigned to selected checklist</p>
                </div>
                <div class="ibm-col-12-3">
                    <x-action-list-buttons createUrl="" exportUrl="{{ route('checklist.overviewForChecklistExport', ['checklist' => $record->id]) }}"/>
                </div>
            </div>
        </div>
    </div>
    @isset($mainCategories)
    <div id="categories-overview-showhide" data-widget="showhide" data-type="panel" class="ibm-show-hide ibm-alternate">
        @foreach ($mainCategories as $key => $category)
            @if ($category->parent_id == 0 || $category->parent_id == 151)
                <h2 id="category_heading_{{ $category->id }}">
            @else
                <h2 id="category_heading_{{ $category->id }}" style="padding-left: 40px; background-color: #ececec">
            @endif
                <span class="ibm-regular">Category name:</span> {{ $category->name }} |
                <span class="ibm-regular">Category in scope:</span> {{ $category->in_scope }} |
                <span class="ibm-regular">Category status:</span> {{ $category->status }}
                @if ($category->ready_to_complete == 1 || $category->status == 'Complete')
                    <span class="ibm-confirm-link ibm-textcolor-green-50" style="position: relative; margin-left:10px;"></span>
                @else
                    <span class="ibm-clock-link ibm-textcolor-red-50" style="position: relative; margin-left:10px;"></span>
                @endif
            </h2>
            <div class="ibm-container-body" id="servicesTable_{{ $category->id }}_container">
                <hr>
                <div class="ibm-fluid" id="servicesTable_{{ $category->id }}_summary">
                    <div class="ibm-col-12-6">
                        <p>
                            Completed Questions: <b class="services_in_scope_yes">{{ $category->services_in_scope_yes }}</b>
                        </p>
                        <p>
                            Not Completed Questions: <b class="services_in_scope_no">{{ $category->services_in_scope_no }}</b>
                        </p>
                        <p>
                            Questions Not in Scope: <b class="services_not_in_scope">{{ $category->services_not_in_scope }}</b>
                        </p>
                    </div>
                    <div class="ibm-col-12-6">
                        <p>
                            Category readiness to closing: <b class="ready_to_complete">
                                @if ($category->ready_to_complete == 1) Yes
                                @else No
                                @endif
                            </b>
                        </p>
                        <!--
                        <p class="ibm-btn-row ibm-ind-link">
                            <a id="alter-category-{{ $category->id }}" class="alter-category ibm-btn-pri ibm-edit-link ibm-btn-red-50" href="#" data-id="{{ $category->id }}" data-pivot_id="{{ $category->pivot_id }}">Alter Category</a>
                        </p>
                        -->
                    </div>
                </div>
                <hr>
                <x-action-list-buttons createUrl="" exportUrl="" setServiceOverviewStatus=true :record="$category"/>
                <hr>
                <div class="ibm-fluid" id="servicesTable_{{ $category->id }}_table_container">
                    <!-- Table Begin -->
                    <x-checklist.service-overview :record="$category" />
                    <!-- Table End -->
                </div>
            </div>
        @endforeach
    </div>
    @endisset
</div>

<!-- Overlay -->
<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editCategoryModal">
    <div id='editCategoryContent'>
        <x-checklist.service-overview-form :record="$record" />
    </div>
</div>

<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editServiceModal">
    <div id='overlayContent'>
        <x-checklist.service-pending-form :record="$record" />
    </div>
</div>

@include('components/modals/massUpdateAction')

@endsection
