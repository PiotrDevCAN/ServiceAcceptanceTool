@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/checkList.js')}}"></script>

<div class="ibm-fluid">
    <div class="ibm-col-12-12">

        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
	            <h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">Check List</h3>

                <div data-widget="dyntabs" class="ibm-graphic-tabs">
                    <!-- Tabs here: -->
                    <div class="ibm-tab-section">
                        <div class="ibm-fluid">
                            <div class="ibm-col-12-12">
                                <ul class="ibm-tabs" role="tablist">
                                    <li><a aria-selected="true" role="tab" href="#instructions">Instructions</a></li>
                                    <li><a role="tab" href="#account-details">Account Details</a></li>
                                    <li><a role="tab" href="#account-status">Account Status</a></li>
                                    <li><a role="tab" href="#services-overview">Services Overview</a></li>
                                    <li><a role="tab" href="#services-pending">Pending Items</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Tabs contents divs: -->
                    <div id="instructions" class="ibm-tabs-content">
                        <div class="ibm-fluid">
                            <div class="ibm-col-12-12">
                                <div class="ibm-card">
                                    <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                                        <ol>
                                            <li>Fill in the required Details in the <b>Account Status</b> tab</li>
                                            <li>Select the services which are In Scope in <b>Services Overview</b> tab</li>
                                            <li>Answer all the questions in the checklist for every <b>Category</b> which are In Scope</li>
                                            <li><b>Account Status</b> tab would show the overall transition status</li>
                                            <li><b>Pending Items</b> tab would show the items which are incomplete</li>
                                            <li>For evidences - update the repository location of the documents</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="account-details" class="ibm-tabs-content">
                        <x-checklist.account-form :record="$record"/>
                    </div>
                    <div id="account-status" class="ibm-tabs-content">
                        <x-checklist.account-status :record="$record"/>
                    </div>
                    <div id="services-overview" class="ibm-tabs-content">
                        @if (!empty($record->id))
                            <x-checklist.tab-heading :record="$record"/>
                            <x-action-list-buttons createUrl="" exportUrl="{{ route('checklist.overviewExport', ['checklist' => $record->id]) }}" setCategoryStatus=true/>
                            <div class="ibm-fluid" id="servicesOverviewTable_table_container">
                                <x-checklist.table-overview :record="$record"/>
                            </div>
                        @else
                            <div class="ibm-fluid">
                                <div class="ibm-col-12-12">
                                    <div class="ibm-card">
                                        <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                                            <p>Firstly, select type of checklist and save changes.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div id="services-pending" class="ibm-tabs-content">
                        @if (!empty($record->id))
                            <x-checklist.tab-heading :record="$record"/>
                            <x-action-list-buttons createUrl="" exportUrl="{{ route('checklist.pendingExport', ['checklist' => $record->id]) }}" setServiceStatus=true/>
                            <div class="ibm-fluid" id="pendingServicesTable_table_container">
                                <x-checklist.service-pending :record="$record"/>
                            </div>
                            <p class="ibm-btn-row ibm-ind-link ibm-right">
                                <a id="details" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="{{ route('checklist.overviewForChecklist', ['checklist' => $record->id]) }}">Show all items</a>
                            </p>
                        @else
                            <div class="ibm-fluid">
                                <div class="ibm-col-12-12">
                                    <div class="ibm-card">
                                        <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                                            <p>Firstly, select type of checklist and save changes.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overlay -->
<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="createAccountModal">
    <div id='createAccountModalContent'>
        <x-checklist.account-form-wizard :record="$newRecord" />
    </div>
</div>

<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editCategoryModal">
    <div id='editCategoryContent'>
        <x-checklist.service-overview-form :record="$newRecord" />
    </div>
</div>

<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editServiceModal">
    <div id='editServiceModalContent'>
        <x-checklist.service-pending-form :record="$newRecord" />
    </div>
</div>

<div class="ibm-common-overlay ibm-overlay-alt" data-widget="overlay" id="changeChecklistTypeModal">
    <div id='editServiceModalContent'>
        <x-checklist.change-type-form name="checklistTypeForm" :record="$newRecord" />
    </div>
</div>

@include('components/modals/massUpdateAction')

@endsection
