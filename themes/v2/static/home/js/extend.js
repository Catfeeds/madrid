jQuery(document).ready(function($) {
    $('#tuan').change(function() {
        location.href = $(this).data('url');
    });
});
