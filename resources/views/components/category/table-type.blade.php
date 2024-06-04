<table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="false" data-paging="false" data-searching="true" data-widget="datatable" id="{{ $name }}">
    <thead>
        <tr>
            <th>Selection</th>
            <th>Parent Category</th>
            <th>Category</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($records as $key => $category)
        <tr data-id="{{ $category->id }}">
            <td class="checkbox">
                <span class="ibm-checkbox-wrapper">
                    <input class="ibm-styled-checkbox" id="check_category_{{ $category->id }}" type="checkbox" value="{{ $category->id }}" />
                    <label for="check_category_{{ $category->id }}" class="ibm-field-label"></label>
                </span>
            </td>
            <td>
                {{ $category->parent->name }}
                (@switch($category->parent->type)
                    @case('T&T_NO')
                        Non T&T
                        @break
                    @case('T&T_YES')
                        T&T
                        @break
                    @default
                @endswitch)
            </td>
            <td>
                {{ $category->name }}
            </td>
            <td>
                @switch($category->type)
                    @case('T&T_NO')
                        Non T&T
                        @break
                    @case('T&T_YES')
                        T&T
                        @break
                    @default
                @endswitch
            </td>
        </tr>
        @if ($category->sequence && $category->children->count())
            @foreach ($category->children as $key => $subCategory)
            <tr data-id="{{ $subCategory->id }}">
                <td class="checkbox">
                    <span class="ibm-checkbox-wrapper">
                        <input class="ibm-styled-checkbox" id="check_category_{{ $subCategory->id }}" type="checkbox" value="{{ $subCategory->id }}" />
                        <label for="check_category_{{ $subCategory->id }}" class="ibm-field-label"></label>
                    </span>
                </td>
                <td style="padding-left: 40px;">
                    {{ $subCategory->parent->name }}
                    (@switch($subCategory->parent->type)
                        @case('T&T_NO')
                            Non T&T
                            @break
                        @case('T&T_YES')
                            T&T
                            @break
                        @default
                    @endswitch)
                </td>
                <td>
                    {{ $subCategory->name }}
                </td>
                <td>
                    @switch($subCategory->type)
                        @case('T&T_NO')
                            Non T&T
                            @break
                        @case('T&T_YES')
                            T&T
                            @break
                        @default
                    @endswitch
                </td>
            </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Selection</th>
            <th>Parent Category</th>
            <th>Category</th>
            <th>Type</th>
        </tr>
    </tfoot>
</table>
