@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/accessRequestsManage.js')}}"></script>

<x-action-list-buttons createUrl="{{ route('admin.access.create') }}" exportUrl="{{ route('admin.access.export') }}"/>

@isset($records)
	<x-access.table name="accessesTable" open="true" header="Administrators" :records="$records" />
@endisset

<!-- Overlay -->
<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editModal">
    <div id='overlayContent'>
        <x-access.form name="accessForm" :record="$record" />
    </div>
</div>

@endsection
