<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="false" data-paging="false" data-searching="false" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Category</th>
            <th>Completed</th>
            <th>Not Completed</th>
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
                <td>
                    {{ $category->name }}
                </td>
                <td>
                    {{ $category->services_completed }}
                </td>
                <td>
                    {{ $category->services_not_completed }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Category</th>
            <th>Completed</th>
            <th>Not Completed</th>
        </tr>
    </tfoot>
</table>
