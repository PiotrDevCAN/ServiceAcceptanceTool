<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="false" data-paging="false" data-searching="false" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Category</th>
            <th>Section</th>
            <th>Question</th>
            <th>Evidence + Additional Input</th>
            <th>Owner</th>
            <th>Completion Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $key => $service)
        <tr data-id="{{ $service->pivot->id }}">
            <td>{{ $service->category->name }}</td>
            <td>{{ $service->section->name }}</td>
            <td>{{ $service->name }}</td>
            <td>{{ $service->pivot->evidence }}</td>
            <td>{{ $record->account->account_dpe }}</td>
            <td>@empty($service->pivot->completition_date)@else{{ $service->pivot->completition_date }}@endempty
            <td>{{ $service->pivot->status }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Category</th>
            <th>Section</th>
            <th>Question</th>
            <th>Evidence + Additional Input</th>
            <th>Owner</th>
            <th>Completion Date</th>
            <th>Status</th>
        </tr>
    </tfoot>
</table>
