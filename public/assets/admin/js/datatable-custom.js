$(document).ready(function () {
    var getUrl = window.location,
        baseUrl = getUrl.protocol + "//" + getUrl.host;// + "/";
    // baseUrl = baseUrl + "lppm_usu/public";

    var responsiveHelperAjax = undefined;
    var breakpointDefinition = {
        tablet: 1024,
        phone: 480
    };

    var tableAssignReviewerAjax = $('#table-assign-reviewer-ajax');
    tableAssignReviewerAjax.dataTable({
        autoWidth: true,
        ajax: baseUrl + '/ajax/proposes/getbyscheme?period_id=' + $('#scheme-assign-reviewer').val() +
        '&status_code[]=MR&status_code[]=PR&type=ASSIGN',
        preDrawCallback: function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelperAjax) {
                responsiveHelperAjax = new ResponsiveDatatablesHelper(tableAssignReviewerAjax, breakpointDefinition);
            }
        },
        rowCallback: function (nRow) {
            responsiveHelperAjax.createExpandIcon(nRow);
        },
        drawCallback: function (oSettings) {
            responsiveHelperAjax.respond();
        }
    });

    $("#scheme-assign-reviewer").change(function () {
        tableAssignReviewerAjax.dataTable().fnDestroy();
        tableAssignReviewerAjax.dataTable({
            autoWidth: true,
            ajax: baseUrl + '/ajax/proposes/getbyscheme?period_id=' + $('#scheme-assign-reviewer').val() +
            '&status_code[]=MR&status_code[]=PR&type=ASSIGN',
            preDrawCallback: function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelperAjax) {
                    responsiveHelperAjax = new ResponsiveDatatablesHelper(tableAssignReviewerAjax, breakpointDefinition);
                }
            },
            // rowCallback: function (nRow) {
            //     responsiveHelperAjax.createExpandIcon(nRow);
            // },
            drawCallback: function (oSettings) {
                responsiveHelperAjax.respond();
            }
        });
    });

    var tableApproveProposeAjax = $('#table-approve-propose-ajax');
    tableApproveProposeAjax.dataTable({
        autoWidth: true,
        ajax: baseUrl + '/ajax/proposes/getbyscheme?period_id=' + $('#scheme-approve-propose').val() +
        '&status_code[]=RS&type=APPROVE',
        preDrawCallback: function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelperAjax) {
                responsiveHelperAjax = new ResponsiveDatatablesHelper(tableApproveProposeAjax, breakpointDefinition);
            }
        },
        rowCallback: function (nRow) {
            responsiveHelperAjax.createExpandIcon(nRow);
        },
        drawCallback: function (oSettings) {
            responsiveHelperAjax.respond();
        }
    });

    $("#scheme-approve-propose").change(function () {
        tableApproveProposeAjax.dataTable().fnDestroy();
        tableApproveProposeAjax.dataTable({
            autoWidth: true,
            ajax: baseUrl + '/ajax/proposes/getbyscheme?period_id=' + $('#scheme-approve-propose').val() +
            '&status_code[]=RS&type=APPROVE',
            preDrawCallback: function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelperAjax) {
                    responsiveHelperAjax = new ResponsiveDatatablesHelper(tableApproveProposeAjax, breakpointDefinition);
                }
            },
            // rowCallback: function (nRow) {
            //     responsiveHelperAjax.createExpandIcon(nRow);
            // },
            drawCallback: function (oSettings) {
                responsiveHelperAjax.respond();
            }
        });
    });

    var tableApproveDedicationAjax = $('#table-approve-dedication-ajax');
    tableApproveDedicationAjax.dataTable({
        autoWidth: true,
        ajax: baseUrl + '/ajax/dedications/get?period_id=' + $('#scheme-approve-dedication').val(),
        preDrawCallback: function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelperAjax) {
                responsiveHelperAjax = new ResponsiveDatatablesHelper(tableApproveDedicationAjax, breakpointDefinition);
            }
        },
        rowCallback: function (nRow) {
            responsiveHelperAjax.createExpandIcon(nRow);
        },
        drawCallback: function (oSettings) {
            responsiveHelperAjax.respond();
        }
    });

    $("#scheme-approve-dedication").change(function () {
        tableApproveDedicationAjax.dataTable().fnDestroy();
        tableApproveDedicationAjax.dataTable({
            autoWidth: true,
            ajax: baseUrl + '/ajax/dedications/get?period_id=' + $('#scheme-approve-dedication').val(),
            preDrawCallback: function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelperAjax) {
                    responsiveHelperAjax = new ResponsiveDatatablesHelper(tableApproveDedicationAjax, breakpointDefinition);
                }
            },
            drawCallback: function (oSettings) {
                responsiveHelperAjax.respond();
            }
        });
    });

    var tableReviewDedicationAjax = $('#table-review-dedication-ajax');
    tableReviewDedicationAjax.dataTable({
        autoWidth: true,
        ajax: baseUrl + '/ajax/dedications/get?period_id=' + $('#scheme-review-dedication').val() +
        '&review_by=' + $("input[name='user_login']").val(),
        preDrawCallback: function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelperAjax) {
                responsiveHelperAjax = new ResponsiveDatatablesHelper(tableReviewDedicationAjax, breakpointDefinition);
            }
        },
        rowCallback: function (nRow) {
            responsiveHelperAjax.createExpandIcon(nRow);
        },
        drawCallback: function (oSettings) {
            responsiveHelperAjax.respond();
        }
    });

    $("#scheme-review-dedication").change(function () {
        tableReviewDedicationAjax.dataTable().fnDestroy();
        tableReviewDedicationAjax.dataTable({
            autoWidth: true,
            ajax: baseUrl + '/ajax/dedications/get?period_id=' + $('#scheme-review-dedication').val() +
            '&review_by=' + $("input[name='user_login']").val(),
            preDrawCallback: function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelperAjax) {
                    responsiveHelperAjax = new ResponsiveDatatablesHelper(tableReviewDedicationAjax, breakpointDefinition);
                }
            },
            drawCallback: function (oSettings) {
                responsiveHelperAjax.respond();
            }
        });
    });
});