const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
const getItemsTableUrl = `/maintenances/confirmation`;

var table = $("#confirmationMaintenances_table").DataTable({
    fixedHeader: true,
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: getItemsTableUrl,
    columns: [
        {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            searchable: false,
            className: "text-center",
        },
        {
            data: "item",
            name: "item",
        },
        {
            data: "serial_number",
            name: "serial_number",
        },
        {
            data: "maintenance_date",
            name: "maintenance_date",
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false,
            className: "text-center",
        },
    ],
});

table.on("click", ".accMaintenance", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    var name = $(this).data("name");
    var url = `/maintenances/update/${id}`;
    Swal.fire({
        title: "Are you sure?",
        text: "You want to accept this maintenance of " + name + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, accept it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "PUT",
                data: {
                    _token: CSRF_TOKEN,
                    type: "acceptRoom",
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.success,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                table.ajax.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.error,
                            showConfirmButton: true,
                            allowOutsideClick: true,
                        });
                    }
                },
            });
        }
    });
});

table.on("click", ".rescheduleMaintenance", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    var name = $(this).data("name");
    var url = `/maintenances/update/${id}`;

    //show modal
    $("#rescheduleMaintenanceModalLabel").text(
        "Reschedule Maintenance of " + name
    );
    $("#rescheduleMaintenanceForm").attr("action", url);
    $("#rescheduleMaintenanceModal").modal("show");
});

const maintenance_date = new Datepicker(
    document.querySelector("#newMaintenance_date"),
    {
        autohide: true,
        buttonClass: "btn",
        format: "yyyy-mm-dd",
        minDate: new Date(),
        maxDate: new Date(new Date().setDate(new Date().getDate() + 7)),
    }
);

$("#rescheduleMaintenanceForm").on("keypress", function (e) {
    return e.which !== 13;
});
