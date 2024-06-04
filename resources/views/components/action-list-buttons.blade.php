<p class="ibm-btn-row ibm-ind-link">
    @if (isset($setCategoryStatus) and !empty($setCategoryStatus))
        <a id="mark_category_in_scope" class="mark_category_in_scope ibm-btn-pri ibm-download-link ibm-btn-green-50" href="{{ $exportUrl }}">Mark as In Scope</a>
        <a id="mark_category_not_in_scope" class="mark_category_not_in_scope ibm-btn-pri ibm-download-link ibm-btn-red-50" href="{{ $exportUrl }}">Mark as Not In Scope</a>
        <a id="mark_category_completed" class="mark_category_completed ibm-btn-pri ibm-confirm-link ibm-btn-green-50" href="{{ $exportUrl }}">Mark as Completed</a>
        <a id="mark_category_not_completed" class="mark_category_not_completed ibm-btn-pri ibm-clock-link ibm-btn-red-50" href="{{ $exportUrl }}">Mark as Not Completed</a>
    @endif

    @if (isset($setServiceStatus) and !empty($setServiceStatus))
        <a id="mark_service_in_scope_yes" class="mark_service_in_scope_yes ibm-btn-pri ibm-download-link ibm-btn-green-50" href="{{ $exportUrl }}">Mark Status as Yes</a>
        <a id="mark_service_in_scope_no" class="mark_service_in_scope_no ibm-btn-pri ibm-download-link ibm-btn-red-50" href="{{ $exportUrl }}">Mark Status as No</a>
        <a id="mark_service_not_in_scope" class="mark_service_not_in_scope ibm-btn-sec ibm-download-link ibm-btn-red-50" href="{{ $exportUrl }}">Mark Status as Not In Scope</a>
    @endif

    @if (isset($setServiceOverviewStatus) and !empty($setServiceOverviewStatus))
        <a id="mark_service_in_scope_yes_{{ $record->id }}" class="mark_service_in_scope_yes ibm-btn-pri ibm-download-link ibm-btn-green-50" href="{{ $exportUrl }}">Mark Status as Yes</a>
        <a id="mark_service_in_scope_no_{{ $record->id }}" class="mark_service_in_scope_no ibm-btn-pri ibm-download-link ibm-btn-red-50" href="{{ $exportUrl }}">Mark Status as No</a>
        <a id="mark_service_not_in_scope_{{ $record->id }}" class="mark_service_not_in_scope ibm-btn-sec ibm-download-link ibm-btn-red-50" href="{{ $exportUrl }}">Mark Status as Not In Scope</a>
    @endif

    {{-- Categories --}}
    @if (isset($setParentCategory) and !empty($setParentCategory))
        <a id="change_parent_category_{{ $prefix ?? '' }}" class="ibm-btn-pri ibm-star-none-link ibm-btn-teal-50" href="{{ $exportUrl }}">Change Parent Category</a>
    @endif
    @if (isset($setType) and !empty($setType))
        <a id="change_tt_type_{{ $prefix ?? '' }}" class="ibm-btn-pri ibm-task-link ibm-btn-teal-50" href="{{ $exportUrl }}">Change T&T Type</a>
    @endif
    @if (isset($delCategory) and !empty($delCategory))
        <a id="delete_category_{{ $prefix ?? '' }}" class="ibm-btn-sec ibm-task-link ibm-btn-red-50" href="{{ $exportUrl }}">Delete</a>
    @endif

    {{-- Sections --}}
    @if (isset($delSection) and !empty($delSection))
        <a id="delete_section" class="ibm-btn-sec ibm-task-link ibm-btn-red-50" href="{{ $exportUrl }}">Delete</a>
    @endif

    {{-- Services --}}
    @if (isset($setCategory) and !empty($setCategory))
        <a id="change_category_{{ $prefix ?? '' }}" class="ibm-btn-pri ibm-blog-link ibm-btn-teal-50" href="{{ $exportUrl }}">Change Category</a>
    @endif
    @if (isset($setSection) and !empty($setSection))
        <a id="change_section_{{ $prefix ?? '' }}" class="ibm-btn-pri ibm-blog-link ibm-btn-teal-50" href="{{ $exportUrl }}">Change Section</a>
    @endif
    @if (isset($delService) and !empty($delService))
        <a id="delete_service_{{ $prefix ?? '' }}" class="ibm-btn-sec ibm-task-link ibm-btn-red-50" href="{{ $exportUrl }}">Delete</a>
    @endif

    @if (isset($createUrl) and !empty($createUrl))
        <a id="create" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="{{ $createUrl }}">Create Entry</a>
    @endif

    @if (isset($exportUrl) and !empty($exportUrl))
        <a id="export" class="ibm-btn-sec ibm-download-link ibm-btn-red-50" href="{{ $exportUrl }}">Export</a>
    @endif
</p>
