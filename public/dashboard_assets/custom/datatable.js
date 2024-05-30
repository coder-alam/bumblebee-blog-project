$(document).ready(function () {
    $("#example2").DataTable({
        paging: true,
        searching: true,
        lengthChange: true,
        info: true,
        autoWidth: false,
        responsive: true,
        order: true,
        lengthMenu: [5, 10, 20, 50],
        destroy: true,
        // ordering: true,
        retrieve: true,
    });
    $(".dataTables_length").addClass("bs-select");
});
