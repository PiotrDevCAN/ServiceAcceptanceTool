@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/accessRequests.js')}}"></script>

<x-action-list-buttons createUrl="{{ route('admin.access.create') }}" exportUrl="{{ route('admin.access.export') }}"/>

@isset($pending)
	<x-access.request-table name="accessesPendingTable" open="true" header="Pending Requests List" :records="$pending" />
@endisset

@isset($approved)
	<x-access.request-table name="accessesApprovedTable" open="false" header="Approved Requests List" :records="$approved" />
@endisset

@isset($rejected)
	<x-access.request-table name="accessesRejectedTable" open="false" header="Rejected Requests List" :records="$rejected" />
@endisset

<!-- Overlay -->
<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editModal">
    <div id='overlayContent'>
        <x-access.form name="accessForm" :record="$record" />
    </div>
</div>

@endsection
