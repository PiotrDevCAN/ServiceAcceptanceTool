@extends('layout')

@section('content')

<div class="ibm-fluid" data-always="true" data-items=".ibm-card">
	<div class="ibm-col-12-12">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">

				<p class="ibm-h3 ibm-light ibm-textcolor-red-60">Logged off</p>
				<h3 class="ibm-h3">You are now signed off.</h3>
				<p>To sign in again, click the link below</p>
				<p class="ibm-ind-link"><a class="ibm-forward-link" href="{{ route('login') }}">Sign in</a></p>

			</div>
		</div>
	</div>
</div>

@endsection
