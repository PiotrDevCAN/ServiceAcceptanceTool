<div data-widget="showhide" data-type="panel" class="ibm-show-hide ibm-alternate">
    <h2 data-open="true">Sections List</h2>
    <div class="ibm-container-body">
        <table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="true" data-paging="false" data-searching="true" data-widget="datatable" id="{{ $name }}">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $key => $section)
                <tr data-id="{{ $section->id }}">
                    <td><p class="ibm-ind-link ibm-icononly ibm-nospacing">
                        {{ $section->id }}
                    </td>
                    <td>{{ $section->name }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Section</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
