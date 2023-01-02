@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/checkLists.js')}}"></script>

<div class="ibm-fluid">
    <div class="ibm-col-12-12">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <form id="accountForm" class="ibm-column-form" method="post" action="">
                    <p class="ibm-h4 ibm-bold">Details of selected account</p>
                    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>
                    <div class="ibm-fluid">
                        <div class="ibm-col-12-6">
                            <p>
                                <label class="ibm-column-field-label">Account Name:</label>
                                <span class="ibm-bold">
                                    {{ $record->name }}
                                </span>
                            </p>
                            <p>
                                <label class="ibm-column-field-label">Transition State:</label>
                                <span class="ibm-bold">
                                    {{ $record->transition_state }}
                                </span>
                            </p>
                            <p>
                                <label class="ibm-column-field-label">Go Live Date:</label>
                                <span class="ibm-bold">
                                    @empty($record->go_live_date)@else{{ $record->go_live_date->format('Y-m-d') }}@endempty
                                </span>
                            </p>
                        </div>
                        <div class="ibm-col-12-6">
                            <p>
                                <label class="ibm-column-field-label">Account DPE:</label>
                                <span class="ibm-bold">
                                    <a href="mailto:{{ $record->account_dpe_intranet_id }}">{{ $record->account_dpe }}</a>
                                </span>
                            </p>
                            <p>
                                <label class="ibm-column-field-label">T&amp;T Focal:</label>
                                <span class="ibm-bold">
                                    <a href="mailto:{{ $record->tt_focal_intranet_id }}">{{ $record->tt_focal }}</a>
                                </span>
                            </p>
                        </div>
                    </div>
                    <input type="hidden" id="account_id" name="account_id" value="{{ $record->id }}"/>
                </form>
            </div>
        </div>

        @isset($records)
            <x-checklist.table-checklist-basic name="checklistsForAccount" :records="$records" :types="$types"/>
        @endisset
    </div>
</div>

@endsection
