jQuery(document).ready(function($) {
    class ProjectManager {
        constructor() {
            this.initializeSelect2();
            this.initializeDatepickers();
            this.bindEvents();
        }

        initializeSelect2() {
            if ($('#project_assignees').length) {
                $('#project_assignees').select2({
                    placeholder: Select2.assignee_placeholder,
                    allowClear: true
                });
            }
        }

        initializeDatepickers() {
            $('#project_start_date, #dev_delivery_date, #qa_delivery_date').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true
            });

            // Initialize datepickers for repeater fields
            $('.repeater-items').each((index, repeater) => {
                console.log(repeater);
                
                this.initializeDatepicker($(repeater));
            });
        }

        initializeDatepicker(scope) {
            scope.find('.ept_date_picker').each(function() {
                if (!$(this).hasClass('hasDatepicker')) {
                    $(this).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true
                    });
                }
            });
        }

        bindEvents() {
            $(document).on('click', '.add-repeater-row', (e) => this.addScope(e));
            $(document).on('click', '.remove-repeater-row', (e) => this.removeScope(e));
        }

        addScope(e) {
            e.preventDefault();

            let $button = $(e.currentTarget);
            let $repeaterField = $button.closest('.repeater-field');
            let $repeaterItems = $repeaterField.find('.repeater-items');
            let $firstItem = $repeaterItems.find('.repeater-item').first();

            let newItem = $firstItem.clone();
            newItem.find('.repeater-input-field').val('');

            let currentIndex = $repeaterItems.find('.repeater-item').length;
            newItem.find('.repeater-input-field').each(function() {
                $(this).removeClass('hasDatepicker');
                $(this).removeAttr('id');
                let name = $(this).attr('name');
                if (name) {
                    let updatedName = name.replace(/\[\d+\]/, '[' + currentIndex + ']');
                    $(this).attr('name', updatedName);
                }
            });

            $repeaterItems.append(newItem);
            this.initializeDatepicker(newItem);
        }

        removeScope(e) {
            e.preventDefault();

            let $button = $(e.currentTarget);
            let $repeaterItems = $button.closest('.repeater-items');
            let $repeaterItem = $button.closest('.repeater-item');

            if ($repeaterItems.find('.repeater-item').length > 1) {
                $repeaterItem.remove();

                $repeaterItems.find('.repeater-item').each(function(index) {
                    $(this).find('.repeater-input-field').each(function() {
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
        }
    }
    new ProjectManager();
});