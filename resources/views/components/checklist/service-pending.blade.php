<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="false" data-paging="false" data-searching="true" data-widget="datatable" id="{{ $name }}">
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
        @foreach ($records as $key => $service)
        <tr data-id="{{ $service->id }}"
            data-pivot_id="{{ $service->pivot->id }}"
            >
            <td class="checkbox">
                <span class="ibm-checkbox-wrapper">
                    <input class="ibm-styled-checkbox" id="check_service_{{ $service->id }}" type="checkbox" value="{{ $service->id }}" />
                    <label for="check_service_{{ $service->id }}" class="ibm-field-label"></label>
                </span>
            </td>
            <td>{{ $service->category->name }}</td>
            <td>{{ $service->section->name }}</td>
            <td>{{ $service->name }}</td>
            @if ($service->pivot->status == 'Yes')
                <td style="background-color: #4b8400; color:#fff">{{ $service->pivot->status }}</td>
            @elseif ($service->pivot->status == 'No')
                <td style="background-color: #e71d32; color:#fff">{{ $service->pivot->status }}</td>
            @else
                <td style="background-color: #ECECEC; color:#000">{{ $service->pivot->status }}</td>
            @endif
            <td>{{ $service->pivot->evidence }} {{ $service->pivot->user_input }}</td>
            <td>@empty($service->pivot->completition_date)@else{{ $service->pivot->completition_date->format('Y-m-d') }}@endempty
            <td>{{ $service->pivot->owner }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
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
    </tfoot>
</table>
