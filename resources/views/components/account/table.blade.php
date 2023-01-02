<div data-widget="showhide" data-type="panel" class="ibm-show-hide ibm-alternate">
    <h2 data-open="true">Accounts List</h2>
    <div class="ibm-container-body">
        <table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="true" data-paging="false" data-searching="true" data-widget="datatable" id="{{ $name }}">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Account</th>
                    <th>Transition State</th>
                    <th>Go Live Date</th>
                    <th>Account DPE</th>
                    <th>T&amp;T Local</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $key => $account)
                <tr data-id="{{ $account->id }}">
                    <td><p class="ibm-ind-link ibm-icononly ibm-nospacing">
                        {{ $account->id }}
                    </td>
                    <td>{{ $account->name }}</td>
                    <td>{{ $account->transition_state }}</td>
                    <td>@empty($account->go_live_date)@else{{ $account->go_live_date->format('Y-m-d') }}@endempty</td>
                    <td>{{ $account->account_dpe }}</td>
                    <td>{{ $account->tt_focal }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Account</th>
                    <th>Transition State</th>
                    <th>Go Live Date</th>
                    <th>Account DPE</th>
                    <th>T&amp;T Local</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
