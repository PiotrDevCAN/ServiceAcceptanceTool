<div data-widget="showhide" data-type="panel" class="ibm-show-hide ibm-alternate">
    <h2 data-open="{{ $open }}">{{ $header }}</h2>
    <div class="ibm-container-body">
        <table class="ibm-data-table ibm-altrows ibm-padding-small" data-scrollaxis="x" data-info="false" data-ordering="true" data-paging="false" data-searching="false" data-widget="datatable" id="{{ $name }}">
            <thead>
                <tr>
                    <th>Employe</th>
                    {{-- <th>Employe Notes Id</th> --}}
                    <th>Employe Email Address</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Created By</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $key => $request)
                <tr data-id="{{ $request->id }}">
                    <td>{{ $request->employee }}</td>
                    {{-- <td>{{ $request->employee_notes_id }}</td> --}}
                    <td>{{ $request->employee_intranet_id }}</td>
                    <td>{{ $request->status }}</td>
                    <td>{{ $request->type }}</td>
                    <td>{{ $request->created_at }}</td>
                    <td>{{ $request->updated_at }}</td>
                    <td>{{ $request->created_by }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</div>
