{{ Form::open(['route' => [Route::currentRouteName(), $record->id], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            <x-checklist.checklist-form-card :record="$record"/>
            <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>
            <x-checklist.account-form-card :record="$record"/>
        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>

    <p><b>Click Save to Save the Check List.</b></p>
    @include('components.form-buttons')

{{ Form::close() }}
