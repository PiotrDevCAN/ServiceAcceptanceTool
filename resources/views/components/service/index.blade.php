@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/services.js')}}"></script>

<x-action-list-buttons createUrl="{{ route('admin.service.create') }}" exportUrl="{{ route('admin.service.export') }}"/>

<x-service.table-tabs :recordsYes="$recordsYes" :recordsNo="$recordsNo"/>

@isset($records)
	<x-service.table name="servicesTable" :records="$records" />
@endisset

<!-- Overlay -->
<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editModal">
    <div id='overlayContent'>
        <x-service.form name="serviceForm" :record="$record"/>
    </div>
</div>

@include('components/modals/massUpdateAction')

@include('components/modals/massUpdateCategoryAction')

@include('components/modals/massUpdateSectionAction')

@endsection
