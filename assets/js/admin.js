jQuery(document).ready(function($) {
    // Ensure jQuery UI Sortable is available
    if (typeof $.fn.sortable !== 'undefined') {
        $('#pickup-stores').sortable({
            handle: '.drag-handle', // Restrict dragging to the handle
            placeholder: 'pickup-store-placeholder', // Visual feedback during drag
            update: function(event, ui) {
                // Update data-index attributes after sorting
                $('.pickup-store-row').each(function(index) {
                    $(this).attr('data-index', index);
                });
            }
        });
    } else {
        console.error('jQuery UI Sortable is not loaded.');
    }

    // Add new store row
    $('#add-pickup-store').on('click', function() {
        var index = $('.pickup-store-row').length;
        var row = '<div class="pickup-store-row" data-index="' + index + '">' +
            '<span class="drag-handle">☰</span>' +
            '<input type="text" required name="pickup_store_name[]" placeholder="Store Name">' +
            '<input type="text" required name="pickup_store_location[]" placeholder="Store Location (Google Maps URL)">' +
            '<button type="button" class="button cancel-store-row">Remove</button>' +
            '</div>';
        $('#pickup-stores').append(row);
    });

    // Remove store row
    $(document).on('click', '.cancel-store-row', function() {
        $(this).closest('.pickup-store-row').remove();
    });
});
