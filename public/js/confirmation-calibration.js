const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
const getItemsTableUrl = `/calibrations/confirmation`;

var table = $("#confirmationCalibrations_table").DataTable({
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
            data: "calibration_date",
            name: "calibration_date",
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

table.on("click", ".accCalibration", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    var name = $(this).data("name");
    var url = `/calibrations/${id}`;
    Swal.fire({
        title: "Are you sure?",
        text: "You want to accept this calibration of " + name + "?",
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

table.on("click", ".rescheduleCalibration", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    var name = $(this).data("name");
    var url = `/calibrations/${id}`;

    $("#rescheduleCalibrationModalLabel").text(
        "Reschedule Calibration of " + name
    );
    $("#rescheduleCalibrationForm").attr("action", url);
    $("#rescheduleCalibrationModal").modal("show");
});

const calibration_date = new Datepicker(
    document.querySelector("#newCalibration_date"),
    {
        autohide: true,
        buttonClass: "btn",
        format: "yyyy-mm-dd",
        minDate: new Date(),
        maxDate: new Date(new Date().setDate(new Date().getDate() + 7)),
    }
);

$("#rescheduleCalibrationForm").on("keypress", function (e) {
    return e.which !== 13;
});
