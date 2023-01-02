@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/accounts.js')}}"></script>

<x-action-list-buttons createUrl="{{ route('admin.account.create') }}" exportUrl="{{ route('admin.account.export') }}"/>

@isset($records)
	<x-account.table name="accountsTable" :records="$records" />
@endisset

<!-- Overlay -->
<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editModal">
    <div id='overlayContent'>
        <x-account.form name="accountForm" :record="$record" />
    </div>
</div>

@endsection
