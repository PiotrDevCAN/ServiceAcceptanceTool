@isset($record->account)
    <div class="ibm-card">
        <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">

            <x-ibmv18form-input field-name="account" label="Account Name" :value="$record->account->name" readonly="readonly"/>

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
                        <option value='{{ $value }}' {{ $record->account->transition_state == $value ? 'selected="selected"' : '' }}>{{ $value }}</option>
                    @endforeach
                    </select>
                </span>
            </p>

            <p>
                <label for="go_live_date">Go Live Date <span class="ibm-required">*</span></label>
                <span>
                    <input data-format="yyyy-mm-dd" type="text" value="@empty($record->account->go_live_date)@else{{ $record->account->go_live_date->format('Y-m-d') }}@endempty" size="20" id="go_live_date" name="go_live_date">
                </span>
            </p>

            <p>
                <label for="account_dpe">Account DPE <span class="ibm-required">*</span></label>
                <span>
                    <input type='text' id='account_dpe' name='account_dpe_notes_id' class='typeaheadNew ibm-fullwidth' value='{{ $record->account->account_dpe_notes_id }}' autocomplete='off' placeholder='Start typing a name to perform a lookup' required="required"/>
                </span>
            </p>
            <input type="hidden" id="account_dpe_name" name="account_dpe" value="{{ $record->account->account_dpe }}"/>
            <input type="hidden" id="account_dpe_intranet_id" name="account_dpe_intranet_id" value="{{ $record->account->account_dpe_intranet_id }}"/>

            <p>
                <label for="tt_focal">T&amp;T Focal <span class="ibm-required @if ($record->type == 'T&T_YES') ibm-hide @endif">*</span></label>
                <span>
                    <input type='text' id='tt_focal' name='tt_focal_notes_id' class='typeaheadNew ibm-fullwidth' value='{{ $record->account->tt_focal_notes_id }}' autocomplete='off' placeholder='Start typing a name to perform a lookup' @if ($record->type == 'T&T_YES') required='required' @endif/>
                </span>
            </p>
            <input type="hidden" id="tt_focal_name" name="tt_focal" value="{{ $record->account->tt_focal }}"/>
            <input type="hidden" id="tt_focal_intranet_id" name="tt_focal_intranet_id" value="{{ $record->account->tt_focal_intranet_id }}"/>
        </div>
    </div>
@else
    <div class="ibm-card">
        <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
            <div class="ibm-fluid">
                <div class="ibm-col-12-8">
                    <p class='ibm-form-elem-grp' id='ACCOUNTFormGroup'>
                        <label for='account'>Account Name <span class="ibm-required">*</span></label>
                        <span>
                            <select
                                class='ibm-fullwidth'
                                name='account'
                                id='account'
                                data-tags="true"
                                data-allow-clear="true"
                                data-minimum-results-for-search="1"
                            >
                            <option value=''>Select</option>
                            @foreach ($accounts as $key => $value)
                                <option value='{{ $value->id }}'>{{ $value->name }}</option>
                            @endforeach
                            </select>
                        </span>
                    </p>
                </div>
                <div class="ibm-col-12-4">
                    <p class="ibm-btn-row ibm-ind-link">
                        <a id="createAccountRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">New Account Setup Wizard</a>
                    </p>
                </div>
                <div class="ibm-col-12-12">
                    <p class="ibm-item-note ibm-bold">In order to create a new account type its name into the field above and fulfill the fields underneath or use a wizard.</p>
                </div>
            </div>
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
                        <option value='{{ $value }}'>{{ $value }}</option>
                    @endforeach
                    </select>
                </span>
            </p>

            <p>
                <label for="go_live_date">Go Live Date <span class="ibm-required">*</span></label>
                <span>
                    <input data-widget="datepicker" data-format="yyyy-mm-dd" type="text" value="" size="20" id="go_live_date" name="go_live_date">
                </span>
            </p>

            <p>
                <label for="account_dpe">Account DPE <span class="ibm-required">*</span></label>
                <span>
                    <input type='text' id='account_dpe' name='account_dpe_notes_id' class='typeaheadNew ibm-fullwidth' value='' autocomplete='off' placeholder='Start typing a name to perform a lookup' required="required"/>
                </span>
            </p>
            <input type="hidden" id="account_dpe_name" name="account_dpe" value=""/>
            <input type="hidden" id="account_dpe_intranet_id" name="account_dpe_intranet_id" value=""/>

            <p>
                <label for="tt_focal">T&amp;T Focal <span class="ibm-required">*</span></label>
                <span>
                    <input type='text' id='tt_focal' name='tt_focal_notes_id' class='typeaheadNew ibm-fullwidth' value='' autocomplete='off' placeholder='Start typing a name to perform a lookup' required="required"/>
                </span>
            </p>
            <input type="hidden" id="tt_focal_name" name="tt_focal" value=""/>
            <input type="hidden" id="tt_focal_intranet_id" name="tt_focal_intranet_id" value=""/>
        </div>
    </div>
@endif
