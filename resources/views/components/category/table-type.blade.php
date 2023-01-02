<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="true" data-paging="false" data-searching="true" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Id</th>
            <th>Parent Category</th>
            <th>Category</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($records as $key => $category)
        <tr data-id="{{ $category->id }}">
            <td><p class="ibm-ind-link ibm-icononly ibm-nospacing">
                {{ $category->id }}
            </td>
            <td>
                {{ $category->parent->name }} ({{ $category->services->count() }})
            </td>
            <td>
                {{ $category->name }}
            </td>
            <td>
                {{ $category->type }}
            </td>
        </tr>
        @if ($category->sequence && $category->children->count())
            @foreach ($category->children as $key => $subCategory)
            <tr data-id="{{ $subCategory->id }}">
                <td><p class="ibm-ind-link ibm-icononly ibm-nospacing">
                    {{ $subCategory->id }}
                </td>
                <td class="ibm-center">
                    {{ $subCategory->parent->name }} ({{ $subCategory->services->count() }})
                </td>
                <td>
                    {{ $subCategory->name }}
                </td>
                <td>
                    {{ $subCategory->type }}
                </td>
            </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th>Parent Category</th>
            <th>Category</th>
            <th>Type</th>
        </tr>
    </tfoot>
</table>
