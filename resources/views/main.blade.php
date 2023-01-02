@extends('layout')

@section('content')

<div class="ibm-fluid" data-widget="setsameheight" data-items=".ibm-card">
    <div class="ibm-col-12-4">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">My Accounts</h3>
                <div data-widget="showhide" data-type="panel" class="ibm-show-hide">
                    @foreach ($accounts as $key => $account)
                        <h2>{{ $account->name }}</h2>
                        <div class="ibm-container-body">
                            <p><a href="{{ route('checklist.checklistForAccount', ['account' => $account->id]) }}">Edit item</a></li>
                            <p>Amount of Related Checklists: <b>{{ $account->checklists_count }}</b></p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="ibm-col-12-4">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">My Checklists</h3>
                <div data-widget="showhide" data-type="panel" class="ibm-show-hide">
                    @foreach ($accountsChecklists as $key => $account)
                        @foreach ($account->userChecklists as $key => $checklist)
                            <h2>{{ $checklist->name }}</h2>
                            <div class="ibm-container-body">
                                <p><a href="{{ route('checklist.edit', ['checklist' => $checklist->id]) }}">Edit item</a></p>
                                <p>Amount of Pending Items: <b>{{ $checklist->in_scope_no_count }}</b></p>
                                <p>Amount of Categories In Scope: <b>{{ $checklist->checklist_categories_in_scope_yes_count }}</b></p>
                                <p>Amount of Completed Categories: <b>{{ $checklist->checklist_categories_completed_count }}</b></p>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="ibm-col-12-4">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">My Pending Services</h3>
                <ul class="ibm-colored-list ibm-linkcolor-default">
                    @foreach ($accountsPendingServices as $key => $account)
                        @foreach ($account->userChecklists as $key => $checklist)
                            @foreach ($checklist->inScopeNo as $key => $service)
                                <li><a href="{{ route('checklist.edit', ['checklist' => $checklist->id]) }}#services-pending">{{ $service->name }}</a></li>
                            @endforeach
                        @endforeach
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="ibm-fluid">
    <div class="ibm-col-12-6">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
	        	<h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">My Access</h3>
                @auth
                <p>Name : <b>{{ $user->cn[0] }}</b></p>
	        	<p>Userid : <b>{{ $user->mail[0] }}</b></p>
	        	<p>CNUM : <b>{{ $user->uid[0] }}</b></p>
                <p>The user role: <b>@if ($user->hasUserRole()) Granted @else Not granted @endif</b></p>
                <p>The administrator role: <b>@if ($user->hasAdminRole()) Granted @else Not granted @endif</b></p>
                @endauth
            </div>
        </div>
    </div>

    <div class="ibm-col-12-6">
        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
	        	<h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">Pending Admin Access Requests</h3>
                @auth
                    <ul class="ibm-colored-list ibm-linkcolor-default">
                        @foreach ($pending as $key => $request)
                            <li>{{ $request->employee }} {{ $request->status }} {{ $request->type }}</li>
                        @endforeach
                    </ul>
                @endauth
            </div>
        </div>
    </div>
</div>

<div class="ibm-fluid">
    <div class="ibm-col-12-12">

        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
	            <h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">Usage</h3>
                <p>The purpose of this checklist is to manage the services out of Transition and Transformation into BAU without any issues and to provide uninterrupted service to the client</p>
            </div>
        </div>

        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">How it works?</h3>
                <p>This checklist has a list of check items covering most of the services supported. Click on the button to the right to access the checklist.</p>
                <p>Follow the instructions provided and select the services which are expected to go live and complete the checklist from a service readiness perspective. On completion you would get an overview of the transition status and the pending items for go live.</p>
            </div>
        </div>

        <div class="ibm-card ibm-border-red-60" style="background: linear-gradient(to right, #d74108 0, #a53725 10px, #fff 10px);">
            <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
                <h3 class="ibm-bold ibm-h4 ibm-textcolor-red-50">Help required?</h3>
                <p>Any assistance required to complete the checklist or on the pending items you can engage the Delivery Excellence by clicking the below link</p>
            </div>
        </div>
    </div>
</div>

@endsection
