<div data-widget="showhide" data-type="panel" class="ibm-show-hide ibm-alternate">
    <h2 data-open="true">Sections List</h2>
    <div class="ibm-container-body">

        <x-action-list-buttons createUrl="" exportUrl="" delSection=true/>

        <table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="true" data-paging="false" data-searching="true" data-widget="datatable" id="{{ $name }}">
            <thead>
                <tr>
                    <th>Selection</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $key => $section)
                <tr data-id="{{ $section->id }}">
                    <td class="checkbox">
                        <span class="ibm-checkbox-wrapper">
                            <input class="ibm-styled-checkbox" id="check_section_{{ $section->id }}" type="checkbox" value="{{ $section->id }}" />
                            <label for="check_section_{{ $section->id }}" class="ibm-field-label"></label>
                        </span>
                    </td>
                    <td>{{ $section->name }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Selection</th>
                    <th>Section</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
