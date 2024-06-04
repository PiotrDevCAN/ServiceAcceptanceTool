<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="false" data-paging="false" data-searching="true" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Selection</th>
            <th>Parent Category</th>
            <th>Category</th>
            <th>In Scope</th>
            <th>Completion Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $key => $category)
            <tr data-id="{{ $category->id }}"
                data-pivot_id="{{ $category->pivot_id }}"
                data-name="{{ $category->name }}"
                data-in_scope="{{ $category->in_scope }}"
                data-status="{{ $category->status }}"
                >
                <td class="checkbox">
                    <span class="ibm-checkbox-wrapper">
                        <input class="ibm-styled-checkbox" id="check_category_{{ $category->id }}" type="checkbox" value="{{ $category->id }}" />
                        <label for="check_category_{{ $category->id }}" class="ibm-field-label"></label>
                    </span>
                </td>
                @if ($category->parent_id == 0 || $category->parent_id == 151)
                    <td>{{ $category->parent->name }}</td>
                @else
                    <td style="padding-left: 40px;">{{ $category->parent->name }}</td>
                @endif
                </td>
                <td>
                    {{ $category->name }}
                </td>
                @if ($category->in_scope == 'Yes')
                    <td style="background-color: #4b8400; color:#fff">{{ $category->in_scope }}</td>
                @else
                    <td>{{ $category->in_scope }}</td>
                @endif
                <td>{{ $category->status }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Selection</th>
            <th>Parent Category</th>
            <th>Category</th>
            <th>In Scope</th>
            <th>Completion Status</th>
        </tr>
    </tfoot>
</table>
