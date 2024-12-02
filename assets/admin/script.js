jQuery(document).ready(function($) {
    // Initialize Select2
    $('#project_assignees').select2({
        placeholder: Select2.assignee_placeholder,
        allowClear: true
    });

    // Initialize Datepicker
    $('#project_start_date, #dev_delivery_date, #qa_delivery_date').datepicker({
        dateFormat: 'yy-mm-dd', // Format to match HTML5 date input
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true
    });
});