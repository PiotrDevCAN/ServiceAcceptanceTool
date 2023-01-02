<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="true" data-paging="false" data-searching="false" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Created By</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $key => $checklist)
        <tr data-id="{{ $checklist->id }}">
            <td><p class="ibm-ind-link ibm-icononly ibm-nospacing">
                {{ $checklist->id }}
            </td>
            <td>{{ $checklist->name }}</td>
            <td>{{ $checklist->created_by }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Created By</th>
        </tr>
    </tfoot>
</table>
