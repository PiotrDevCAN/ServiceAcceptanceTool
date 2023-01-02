<div data-widget="showhide" data-type="panel" class="ibm-show-hide ibm-alternate">
    <h2 data-open="{{ $open }}">{{ $header }} List defined in the Blue Group</h2>
    <div class="ibm-container-body">
        <table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="true" data-ordering="true" data-paging="false" data-searching="false" data-widget="datatable" id="{{ $name }}">
            <thead>
                <tr>
                    <th>Email Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $key => $person)
                <tr data-id="{{ $person }}">
                    <td>{{ $person }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</div>
