<p class="ibm-btn-row ibm-ind-link">
    @switch($record->status)
        @case('Pending')
            <a id="approveRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Approve</a>
            <a id="rejectRecord" class="ibm-btn-sec ibm-bee-link ibm-btn-red-50" href="#">Reject</a>
            @break
        @case('Approved')
            <a id="rejectRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Reject</a>
            @break
        @case('Rejected')
            <a id="approveRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Approve</a>
            @break
        @default

            <a id="saveRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Save</a>
            <a id="updateRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Update</a>
            <a id="resetRecord" class="ibm-btn-sec ibm-reset-link ibm-btn-red-50" href="#">Reset</a>

            <a id="approveRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Approve</a>
            <a id="rejectRecord" class="ibm-btn-sec ibm-bee-link ibm-btn-red-50" href="#">Reject</a>
    @endswitch
    <a id="deleteRecord" class="ibm-btn-pri ibm-close-link ibm-btn-red-50" href="#">Delete</a>
</p>
