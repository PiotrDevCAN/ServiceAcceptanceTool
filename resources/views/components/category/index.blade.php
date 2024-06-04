@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/categories.js')}}"></script>

<x-action-list-buttons createUrl="{{ route('admin.category.create') }}" exportUrl="{{ route('admin.category.export') }}"/>

<x-category.table-tabs :recordsYes="$recordsYes" :recordsNo="$recordsNo"/>

<!-- Overlay -->
<div class="ibm-common-overlay ibm-overlay-alt-three" data-widget="overlay" id="editModal">
    <div id='overlayContent'>
        <x-category.form name="categoryForm" :record="$record"/>
    </div>
</div>

@include('components/modals/massUpdateAction')

@include('components/modals/massUpdateParentAction')

@include('components/modals/massUpdateTTTypeAction')

@endsection
