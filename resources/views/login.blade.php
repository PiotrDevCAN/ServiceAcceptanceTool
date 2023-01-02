@extends('layout')

@section('content')

<div class="ibm-fluid" data-always="true" data-items=".ibm-card">
	<div class="ibm-col-12-12">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">

				<p class="ibm-h3 ibm-light ibm-textcolor-red-60">Sign In</p>
                {{ Form::open(['url' => URL::to('authenticate', array(), true), 'method' => 'post', 'id' => 'signinForm', 'class'  => 'ibm-column-form' ]) }}

				<!-- if there are login errors, show them here -->
                <p>
                    {{ $errors->first('email') }}
                    {{ $errors->first('password') }}
                </p>

				<p>
					{{ Form::label('email', 'User Name*', ['class' => 'ibm-required']) }}
			 		{{ Form::text('email', old('email'), ['placeholder' => 'Email']) }}
				</p>

				<p>
                    {{ Form::label('password', 'Password*', ['class' => 'ibm-required']) }}
                    {{ Form::password('password', ['placeholder' => 'Password']) }}
                </p>

                <p>
                    <label class="ibm-column-field-label" id="remember_label">Remember me</label>
                    <span class="ibm-input-group">
                        <input data-init="false" class="ibm-styled-checkbox" id="remember" name="checkbgrp" type="checkbox" value="1" /> <label for="remember"></label>
                    </span>
                </p>

				<p>
					{{ Form::submit('OK', ['class' => 'ibm-btn-pri ibm-btn-red-50', 'name' => 'submitForm']) }}
					{{ Form::button('Cancel', ['class' => 'ibm-btn-sec ibm-btn-red-50', 'name' => 'cancel', 'onclick' => ""]) }}
				</p>

				@if($targetPageTitle)
					<p>You will be redirected to: <a href="{{ $targetPageTitle }}">page</a></p>
                    <input type="hidden" name="targetPageTitle" value="{{ $targetPageTitle }}">
				@endif

				{{ Form::close() }}

			</div>
		</div>
	</div>
</div>

@endsection
