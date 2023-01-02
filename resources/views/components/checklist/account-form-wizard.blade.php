{{ Form::open(['route' => [Route::currentRouteName(), ''], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            @include('components.checklist.account-form-card')
            {{-- <x-checklist.account-form-card :record="$newRecord" :types="$types" :states="$states" :accounts="$accounts" :newRecord="$record"/> --}}
        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>

    <p><b>Click Save to Add the Account.</b></p>
    {{-- @include('components.form-buttons') --}}

{{ Form::close() }}
