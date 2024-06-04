{{ Form::open(['route' => [Route::currentRouteName(), $record->id], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            @empty($record->id)
                <input type="hidden" id="id" name="id" value=""/>
            @else
                <input type="hidden" id="id" name="id" value="{{ $record->id }}"/>
            @endempty

            <input type="hidden" id="created_by" name="created_by" value="{{ $record->created_by }}"/>

            @include('components.form-direct-link')

            <x-ibmv18form-input field-name="account" label="Account Name" :value="$record->name" required="required"/>

            <p class='ibm-form-elem-grp' id='TRANSITION_STATEFormGroup'>
                <label for='transition_state'>Transition State <span class="ibm-required">*</span></label>
                <span>
                    <select
                        class='ibm-fullwidth'
                        name='transition_state'
                        id='transition_state'
                        required='required'
                        data-tags="true"
                        data-allow-clear="true"
                    >
                    <option value=''>Select</option>
                    @foreach ($states as $key => $value)
                        <option value='{{ $value }}' {{ $record->transition_state == $value ? 'selected="selected"' : '' }}>{{ $value }}</option>
                    @endforeach
                    </select>
                </span>
            </p>

            <p>
                <label for="go_live_date">Go Live Date <span class="ibm-required">*</span></label>
                <span>
                    <input data-format="yyyy-mm-dd" type="text" value="@empty($record->go_live_date)@else{{ $record->go_live_date->format('Y-m-d') }}@endempty" size="20" id="go_live_date" name="go_live_date">
                </span>
            </p>

            <p>
                <label for="account_dpe">Account DPE <span class="ibm-required">*</span></label>
                <span>
                    <input type='text' id='account_dpe' name='account_dpe_notes_id' class='typeaheadNew ibm-fullwidth' value='{{ $record->account_dpe_notes_id }}' autocomplete='off' placeholder='Start typing a name to perform a lookup' required="required"/>
                </span>
            </p>
            <input type="hidden" id="account_dpe_name" name="account_dpe" value="{{ $record->account_dpe }}"/>
            <input type="hidden" id="account_dpe_intranet_id" name="account_dpe_intranet_id" value="{{ $record->account_dpe_intranet_id }}"/>

            <p>
                <label for="tt_focal">T&amp;T Focal <span class="ibm-required">*</span></label>
                <span>
                    <input type='text' id='tt_focal' name='tt_focal_notes_id' class='typeaheadNew ibm-fullwidth' value='{{ $record->tt_focal_notes_id }}' autocomplete='off' placeholder='Start typing a name to perform a lookup' rrequired="required"/>
                </span>
            </p>
            <input type="hidden" id="tt_focal_name" name="tt_focal" value="{{ $record->tt_focal }}"/>
            <input type="hidden" id="tt_focal_intranet_id" name="tt_focal_intranet_id" value="{{ $record->tt_focal_intranet_id }}"/>

        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>

    <p><b>Click Save to Create the Account.</b></p>
    @include('components.form-buttons')

{{ Form::close() }}
