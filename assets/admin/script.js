jQuery(document).ready(function($) {
    // Initialize Select2
    if($('#project_assignees').length) {
        $('#project_assignees').select2({
            placeholder: Select2.assignee_placeholder,
            allowClear: true
        });
    }

    // Initialize Datepicker
    $('#project_start_date, #dev_delivery_date, #qa_delivery_date').datepicker({
        dateFormat: 'yy-mm-dd', // Format to match HTML5 date input
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true
    });

    // Function to initialize Datepicker
    function initializeDatepicker(scope) {
        scope.find('.ept_date_picker').each(function() {
            if (!$(this).hasClass('hasDatepicker')) {
                $(this).datepicker({
                    dateFormat: 'yy-mm-dd', // Adjust the format as needed
                    changeMonth: true,
                    changeYear: true
                });
            }
        });
    }

     // Add a new repeater item
     $('#add-scope').on('click', function(e) {
        e.preventDefault();

        // Clone the first repeater item
        let newItem = $('.repeater-item').first().clone();
        newItem.find('input').val('');

        // Generate a unique index for new items
        let currentIndex = $('.repeater-item').length;
        newItem.find('input').each(function() {
            $(this).removeClass('hasDatepicker');
            $(this).removeAttr('id');
            let name = $(this).attr('name');
            if (name) {
                let updatedName = name.replace(/\[\d+\]/, '[' + currentIndex + ']');
                $(this).attr('name', updatedName);
            }
        });

        $('.repeater-items').append(newItem);
        initializeDatepicker(newItem);
    });

    // Remove a repeater item
    $(document).on('click', '.remove-scope', function(e) {
        e.preventDefault();

        if ($('.repeater-item').length > 1) {
            $(this).closest('.repeater-item').remove();

            // Update indexes for remaining items
            $('.repeater-item').each(function(index) {
                $(this).find('input').each(function() {
                    let name = $(this).attr('name');
                    if (name) {
                        let updatedName = name.replace(/\[\d+\]/, '[' + index + ']');
                        $(this).attr('name', updatedName);
                    }
                });
            });
        } else {
            alert('You must have at least one scope.');
        }
    });

    // Reinitialize the Datepicker for the new fields
    initializeDatepicker($('.repeater-items'));
});