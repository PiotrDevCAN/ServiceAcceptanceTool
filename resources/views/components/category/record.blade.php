@extends('layout')

@section('content')

<script type="module" src="{{ asset('js/components/forms/categoriesModal.js')}}"></script>

<div class="ibm-fluid">
    <div class="ibm-col-12-12">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">Define/Modify Service Category</h3>

                <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>

                <x-category.form name="categoryForm" :record="$record"/>

			</div>
		</div>
	</div>
</div>

@endsection
