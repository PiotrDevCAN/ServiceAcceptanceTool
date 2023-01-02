{{ Form::open(['route' => [Route::currentRouteName(), $record->id], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            <p>
                Warning, changing a new T&T type will cause wipe out all currently assigned categories and services.
            </p>
        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>
    <p class="ibm-btn-row ibm-ind-link">
        <a id="makeTypeChangeRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Change</a>
        <a id="cancelTypeChangeRecord" class="ibm-btn-sec ibm-close-link ibm-btn-red-50" href="#">Cancel</a>
    </p>
{{ Form::close() }}
