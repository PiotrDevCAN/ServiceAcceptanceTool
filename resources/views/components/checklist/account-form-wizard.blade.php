{{ Form::open(['route' => [Route::currentRouteName(), $record->id], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            <x-checklist.account-form-card :record="$record" wizard="1"/>
        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>

    <p><b>Click Save to Create the Account.</b></p>
    <p class="ibm-btn-row ibm-ind-link">
        <a id="createAccountRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Save</a>
        <a href="javascript:;" id='closeCreateAccountModal' class="ibm-close-link ibm-btn-sec ibm-btn-red-50" onclick="IBMCore.common.widget.overlay.hide('createAccountModal', true);">Close</a>
    </p>

{{ Form::close() }}
