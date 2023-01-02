<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="true" data-paging="false" data-searching="true" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Id</th>
            <th>Category</th>
            <th>Section</th>
            <th>Question</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $key => $service)
        <tr data-id="{{ $service->id }}">
            <td><p class="ibm-ind-link ibm-icononly ibm-nospacing">
                {{ $service->id }}
            </td>
            <td>{{ $service->category->name }}</td>
            <td>{{ $service->section->name }}</td>
            <td>{{ $service->name }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th>Category</th>
            <th>Section</th>
            <th>Question</th>
        </tr>
    </tfoot>
</table>
