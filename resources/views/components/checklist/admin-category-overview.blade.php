@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/serviceOverviewByChecklist.js')}}"></script>

<div class="ibm-fluid" id="serviceOverviewChecklist">
    <div class="ibm-col-12-12">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <form id="accountForm" class="ibm-column-form" method="post" action="">
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
                                <a id="export" class="ibm-btn-pri ibm-edit-link ibm-btn-red-50" href="{{ route('admin.checklist.edit', ['checklist' => $record->id]) }}#services-overview">Manage Check List Services</a>
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

    <x-action-list-buttons createUrl="" exportUrl="{{ route('admin.checklist.overviewForChecklistExport', ['checklist' => $record->id]) }}"/>

    @isset($mainCategories)
    <div data-widget="showhide" data-type="panel" class="ibm-show-hide ibm-alternate">
        @foreach ($mainCategories as $key => $category)
            <h2>
                Category name: {{ $category->name }} |
                Category status: {{ $category->status }} |
                Category in scope: {{ $category->in_scope }}
            </h2>
            <div class="ibm-container-body">
                <div class="ibm-fluid">
                    <x-checklist.service-overview :record="$category" />
                </div>
            </div>
        @endforeach
    </div>
    @endisset
</div>

<!-- Overlay -->
<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editServiceModal">
    <div id='overlayContent'>
        <x-checklist.service-pending-form :record="$record" />
    </div>
</div>

@endsection
