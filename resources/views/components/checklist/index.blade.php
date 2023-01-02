@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/checkLists.js')}}"></script>

<div class="ibm-fluid" id="checklistIndex">
    <div class="ibm-col-12-12">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <p>To edit CheckList select an item from the list</p>
            </div>
        </div>

        <x-action-list-buttons createUrl="{{ route('checklist.create') }}" exportUrl="{{ route('admin.checklist.export') }}"/>

        @isset($records)
            <x-checklist.table-show-hide name="checklistsTable" :records="$records"/>
        @endisset

    </div>
</div>

@endsection
