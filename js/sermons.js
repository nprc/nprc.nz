$(document).ready(function() {
    $('#content > div.table-wrapper > table > tbody  > tr').each(function(index, tr) {
        var href = $(tr).find('td:last > a:last').attr('href');
        if (href !== undefined) {
            $(tr).find('td:nth-child(3)').wrapInner(function() {
                return '<a href="' + href + '" target="_blank"></a>';
            });
        }
    });
});