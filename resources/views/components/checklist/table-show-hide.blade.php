<div data-widget="showhide" data-type="panel" class="ibm-show-hide ibm-alternate">
    @foreach ($records as $key => $account)
        <h2 @if ($key == 0) data-open="true" @endif>
            Account name: {{ $account->name }}
        </h2>
        <div class="ibm-container-body">
            <div class="ibm-fluid">
                <x-checklist.table-checklist-basic name="{{ $name }}_{{ $account->id }}" :records="$account->checklists" :types="$types"/>
            </div>
        </div>
    @endforeach
</div>
