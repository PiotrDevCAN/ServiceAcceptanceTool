<div data-widget="dyntabs" class="ibm-graphic-tabs">
    <!-- Tabs here: -->
    <div class="ibm-tab-section">
        <div class="ibm-fluid">
            <div class="ibm-col-12-12">
                <ul class="ibm-tabs" role="tablist">
                    <li><a aria-selected="true" role="tab" href="#tt_no">Non T&T</a></li>
                    <li><a role="tab" href="#tt_yes">T&T</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Tabs contents divs: -->
    <div id="tt_no" class="ibm-tabs-content">

        <x-action-list-buttons createUrl="" exportUrl="" setCategory=true setSection=true delService=true prefix="tt_no"/>

        <x-service.table-type name="servicesTableNo" :records="$recordsNo" />
    </div>
    <div id="tt_yes" class="ibm-tabs-content">

        <x-action-list-buttons createUrl="" exportUrl="" setCategory=true setSection=true delService=true prefix="tt_yes"/>

        <x-service.table-type name="servicesTableYes" :records="$recordsYes" />
    </div>
</div>
