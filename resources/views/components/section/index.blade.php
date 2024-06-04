@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/sections.js')}}"></script>

<x-action-list-buttons createUrl="{{ route('admin.section.create') }}" exportUrl="{{ route('admin.section.export') }}"/>

@isset($records)
	<x-section.table-simple name="sectionsTable" :records="$records" />
@endisset

<!-- Overlay -->
<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editModal">
    <div id='overlayContent'>
        <x-section.form name="sectionForm" :record="$record" />
    </div>
</div>

@include('components/modals/massUpdateAction')

@endsection
