jQuery(document).ready(function($) {
    // Add new store row
    $('#add-pickup-store').on('click', function() {
        var index = $('.pickup-store-row').length;
        var row = '<div class="pickup-store-row" data-index="' + index + '">' +
            '<input type="text" name="pickup_store_name[]" placeholder="Store Name">' +
            '<input type="text" name="pickup_store_location[]" placeholder="Store Location (Google Maps URL)">' +
            '<button type="button" class="button cancel-store-row">Cancel</button>' +
            '</div>';
        $('#pickup-stores').append(row);
    });

    // Remove store row
    $(document).on('click', '.cancel-store-row', function() {
        $(this).closest('.pickup-store-row').remove();
    });

    // Make store rows sortable
    $('#pickup-stores').sortable({
        update: function(event, ui) {
            // Update indexes after sorting
            $('.pickup-store-row').each(function(index) {
                $(this).attr('data-index', index);
            });
        }
    });
});