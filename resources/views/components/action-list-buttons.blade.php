<p class="ibm-btn-row ibm-ind-link">
    @if (!empty($createUrl))
        <a id="create" class="ibm-btn-sec ibm-bee-link ibm-btn-red-50" href="{{ $createUrl }}">Create Entry</a>
    @endif
    @if (!empty($exportUrl))
        <a id="export" class="ibm-btn-pri ibm-download-link ibm-btn-red-50" href="{{ $exportUrl }}">Export</a>
    @endif
</p>
