<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="false" data-ordering="false" data-paging="false" data-searching="false" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Category</th>
            <th>Section</th>
            <th>Question</th>
            <th>Status</th>
            <th>Evidence</th>
            <th>Completion Date</th>
            <th>Additional Input</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($records))
            @foreach ($records as $key => $service)
            <tr data-id="{{ $service->id }}"
                data-pivot_id="{{ $service->pivot_id }}"
                data-category_name="{{ $service->category->name }}"
                data-category_id="{{ $service->category->id }}"
                data-section_name="{{ $service->section->name }}"
                data-section_id="{{ $service->section->id }}"
                data-name="{{ $service->name }}"
                data-status="{{ $service->status }}"
                data-evidence="{{ $service->evidence }}"
                data-completition_date="@empty($service->completition_date)@else{{ $service->completition_date }}@endempty"
                data-user_input="{{ $service->user_input }}"
                >
                <td>{{ $key + 1 }}</td>
                <td>{{ $service->category->name }}</td>
                <td>{{ $service->section->name }}</td>
                <td>{{ $service->name }}</td>
                @if (!empty($service->pivot_id))
                    <td>{{ $service->status }}</td>
                    <td>{{ $service->evidence }}</td>
                    <td>@empty($service->completition_date)@else{{ $service->completition_date }}@endempty</td>
                    <td>{{ $service->user_input }}</td>
                @else
                    <td>{{ $service->status }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
