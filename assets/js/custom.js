/* OSAEITS Simple - custom JS */
$(function() {
    // Confirm delete
    $('[data-confirm]').on('click', function(e) {
        if (!confirm($(this).data('confirm'))) e.preventDefault();
    });

    // Mobile cardview for all page tables: use table headers as field labels.
    $('.table-responsive table').each(function() {
        var $table = $(this);
        var headers = [];

        $table.find('thead th').each(function() {
            headers.push($.trim($(this).text()));
        });

        if (!headers.length) return;

        $table.find('tbody tr').each(function() {
            $(this).find('td').each(function(index) {
                var label = headers[index] || ('Field ' + (index + 1));
                $(this).attr('data-label', label);
            });
        });
    });
});
