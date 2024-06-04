<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="true" data-paging="false" data-searching="true" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Selection</th>
            <th>Category</th>
            <th>Section</th>
            <th>Question</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $key => $service)
        <tr data-id="{{ $service->id }}">
            <td class="checkbox">
                <span class="ibm-checkbox-wrapper">
                    <input class="ibm-styled-checkbox" id="check_service_{{ $service->id }}" type="checkbox" value="{{ $service->id }}" />
                    <label for="check_service_{{ $service->id }}" class="ibm-field-label"></label>
                </span>
            </td>
            <td>{{ $service->category->name }}</td>
            <td>{{ $service->section->name }}</td>
            <td>{{ $service->name }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Selection</th>
            <th>Category</th>
            <th>Section</th>
            <th>Question</th>
        </tr>
    </tfoot>
</table>
