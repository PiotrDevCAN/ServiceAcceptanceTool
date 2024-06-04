<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="false" data-ordering="false" data-paging="false" data-searching="false" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Selection</th>
            <th>Category</th>
            <th>Section</th>
            <th>Question</th>
            <th>Completion Status</th>
            <th>Evidence + Additional Input</th>
            <th>Completion Date</th>
            <th>Owner</th>
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
                <td class="checkbox">
                    <span class="ibm-checkbox-wrapper">
                        <input class="ibm-styled-checkbox" id="check_category_{{ $service->id }}" type="checkbox" value="{{ $service->id }}" />
                        <label for="check_category_{{ $service->id }}" class="ibm-field-label"></label>
                    </span>
                </td>
                <td>{{ $service->category->name }}</td>
                <td>{{ $service->section->name }}</td>
                <td>{{ $service->name }}</td>
                @if ($service->status == 'Yes')
                    <td style="background-color: #4b8400; color:#fff">{{ $service->status }}</td>
                @elseif ($service->status == 'No')
                    <td style="background-color: #e71d32; color:#fff">{{ $service->status }}</td>
                @else
                    <td style="background-color: #ECECEC; color:#000">{{ $service->status }}</td>
                @endif
                @if (!empty($service->pivot_id))
                    <td>{{ $service->evidence }} {{ $service->user_input }}</td>
                    <td>@empty($service->completition_date)@else{{ $service->completition_date->format('Y-m-d') }}@endempty</td>
                    <td>{{ $service->owner }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
