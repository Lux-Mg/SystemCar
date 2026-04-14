$(document).ready(function () {

    const DATATABLE_EN = {
        "sEmptyTable": "No records found",
        "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
        "sInfoEmpty": "Showing 0 to 0 of 0 entries",
        "sInfoFiltered": "(filtered from _MAX_ total entries)",
        "sInfoPostFix": "",
        "sInfoThousands": ",",
        "sLengthMenu": "_MENU_ results per page",
        "sLoadingRecords": "Loading...",
        "sProcessing": "Processing...",
        "sZeroRecords": "No records found",
        "sSearch": "Search",
        "oPaginate": {
            "sNext": "Next",
            "sPrevious": "Previous",
            "sFirst": "First",
            "sLast": "Last"
        },
        "oAria": {
            "sSortAscending": ": activate to sort column ascending",
            "sSortDescending": ": activate to sort column descending"
        },
        "select": {
            "rows": {
                "_": "%d rows selected",
                "0": "No rows selected",
                "1": "1 row selected"
            }
        },
        "buttons": {
            "copy": "Copy to clipboard",
            "copyTitle": "Copy successful",
            "copySuccess": {
                "1": "1 row copied successfully",
                "_": "%d rows copied successfully"
            }
        }
    };

    var table = $('.data-table').DataTable({
        'oLanguage': DATATABLE_EN,
        responsive: true,
        select: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': ['nosort']
        }],
        "lengthMenu": [3, 10, 25, 50, 75, 100, 200]
    });

});