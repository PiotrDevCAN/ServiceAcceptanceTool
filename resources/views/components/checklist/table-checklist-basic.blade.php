<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="false" data-ordering="true" data-paging="false" data-searching="false" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Checklist Name</th>
            <th>Checklist Type</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $key => $checklist)
        <tr data-id="{{ $checklist->id }}">
            <td>{{ $checklist->name }}</td>
            <td>
                @foreach ($types as $key => $value)
                    @if ($checklist->type == $value['type'])
                        {{ $value['name'] }}
                    @endif
                @endforeach
            </td>
            <td>{{ $checklist->created_by }}</td>
            <td>{{ $checklist->created_at }}</td>
            <td>{{ $checklist->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
    </tfoot>
</table>
