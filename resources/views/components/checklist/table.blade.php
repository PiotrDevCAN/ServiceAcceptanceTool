<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="true" data-paging="false" data-searching="false" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Account Name</th>
            <th>Transition State</th>
            <th>Go Live Date</th>
            <th>Account DPE</th>
            <th>T&amp;T Focal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $key => $checklist)
        <tr data-id="{{ $checklist->id }}">
            <td><p class="ibm-ind-link ibm-icononly ibm-nospacing">
                {{ $checklist->id }}
            </td>
            <td>{{ $checklist->name }}</td>
            <td>{{ $checklist->account->name }}</td>
            <td>{{ $checklist->account->transition_state }}</td>
            <td>@empty($checklist->account->go_live_date)@else{{ $checklist->account->go_live_date->format('Y-m-d') }}@endempty</td>
            <td>{{ $checklist->account->account_dpe }}</td>
            <td>{{ $checklist->account->tt_focal }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Account Name</th>
            <th>Transition State</th>
            <th>Go Live Date</th>
            <th>Account DPE</th>
            <th>T&amp;T Focal</th>
        </tr>
    </tfoot>
</table>
