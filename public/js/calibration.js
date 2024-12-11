const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
const getItemsTableUrl = `/calibrations`;
const storeTemporaryFileUrl = `/calibrations/store/temporary-file`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

let selectedItems = [];
let checkAllStatus = false;
let currentPage = 0;

let table = $("#items_table").DataTable({
    fixedHeader: true,
    processing: true,
    serverSide: true,
    responsive: true,
    deferLoading: 0,
    ajax: {
        url: getItemsTableUrl,
        data: function (d) {
            d._token = CSRF_TOKEN;
            d.type = "list";
            d.filter = $("#filterMonth").val();
        },
    },
    columns: [
        {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            orderable: false,
            searchable: false,
            className: "text-center",
        },
        {
            data: "item",
            name: "item",
            orderable: false,
        },
        {
            data: "room",
            name: "room",
            orderable: false,
        },
        {
            data: "serial_number",
            name: "serial_number",
            orderable: false,
        },
        {
            data: "calibration_date",
            name: "calibration_date",
        },
        {
            data: "reschedule_date",
            name: "reschedule_date",
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false,
            className: "text-center",
        },
    ],
    drawCallback: function () {
        $("input.select-row").each(function () {
            if (selectedItems.includes($(this).val())) {
                $(this).prop("checked", true);
            }
        });
    },
});

$("#filterMonth").on("change", function () {
    table.ajax.reload();
});

$(document).on("click", ".alertRoom", function () {
    const id = $(this).data("id");
    const room = $(this).data("room");
    const name = $(this).data("name");
    Swal.fire({
        title: "Alert Room",
        text:
            "Are you sure you want to notify " +
            room +
            " for calibration of item " +
            name +
            "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, alert it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/calibrations`,
                type: "POST",
                data: {
                    _token: CSRF_TOKEN,
                    type: "alert",
                    item_unit_id: id,
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

$(document).on("click", ".callVendor", function () {
    const id = $(this).data("id");
    const name = $(this).data("name");
    Swal.fire({
        title: "Call Vendor",
        text:
            "Are you sure you want to notify the vendor for calibration of item " +
            name +
            "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, call it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/calibrations/` + id,
                type: "PUT",
                data: {
                    _token: CSRF_TOKEN,
                    type: "callVendor",
                    item_unit_id: id,
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

let calibrationProcessTable = $("#calibrationProcessTable").DataTable({
    fixedHeader: true,
    pageLength: 25,
    lengthChange: true,
    autoWidth: false,
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
        url: getItemsTableUrl,
        data: function (d) {
            d._token = CSRF_TOKEN;
            d.type = "process";
        },
    },
    columns: [
        {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            className: "text-center",
            orderable: false,
            searchable: false,
        },
        {
            data: "item",
            name: "item",
        },
        {
            data: "status",
            name: "status",
            className: "text-center",
            orderable: false,
            searchable: false,
        },
        {
            data: "remarks",
            name: "remarks",
        },
        {
            data: "evidence",
            name: "evidence",
        },
        {
            data: "action",
            name: "action",
            className: "text-center",
            orderable: false,
            searchable: false,
        },
    ],
    drawCallback: function () {
        loadUploadedFiles();
    },
});

$("#calibrationProcessTable").on("click", ".update", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let url = "calibrations/" + id;
    let formUpdateCalibration = new FormData();

    let status = $(this).closest("tr").find(".status").val();
    let remarks = $(this).closest("tr").find(".remarks").val();
    let evidence = sessionStorage.getItem("evidence_file");

    formUpdateCalibration.append("status", status);
    formUpdateCalibration.append("remarks", remarks);
    formUpdateCalibration.append("evidence", evidence);
    formUpdateCalibration.append("type", "updateCalibration");
    formUpdateCalibration.append("_token", CSRF_TOKEN);
    formUpdateCalibration.append("_method", "PUT");

    $.ajax({
        url: url,
        type: "POST",
        data: formUpdateCalibration,
        processData: false,
        contentType: false,
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
                        calibrationProcessTable.ajax.reload();
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
        error: function (response) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: response.responseJSON.message,
                showConfirmButton: true,
                allowOutsideClick: true,
            });
        },
    });
});

$("#calibrationProcessTable").on("click", ".finish", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let url = "calibrations/" + id;
    let status = $(this).closest("tr").find(".status").val();
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _method: "PUT",
            _token: CSRF_TOKEN,
            id: id,
            status: status,
            type: "finishCalibration",
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.success,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        calibrationProcessTable.ajax.reload();
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
        error: function (response) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: response.responseJSON.message,
                showConfirmButton: true,
                allowOutsideClick: true,
            });
        },
    });
});

$(document).on("change", "#evidence", function () {
    let fileInput = $(this);
    let itemId = fileInput.attr("id");
    let file = fileInput[0].files[0];

    let formData = new FormData();
    formData.append("_token", CSRF_TOKEN);
    formData.append("evidence", file);
    formData.append("item_id", itemId);

    $.ajax({
        url: storeTemporaryFileUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "File uploaded successfully!",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                });
                sessionStorage.setItem(itemId + "_file", response.fileName);
            }
        },
        error: function (response) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: response.responseJSON.message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                allowOutsideClick: true,
            });
            formData.delete("evidence");
        },
    });
});

function loadUploadedFiles() {
    $('input[type="file"][id^="evidence"]').each(function () {
        let itemId = $(this).attr("id");
        let fileName = sessionStorage.getItem(itemId + "_file");

        if (fileName) {
            $(this).after(
                '<p>File uploaded: <a href="/temp/' +
                    fileName +
                    '" target="_blank">View file</a></p>'
            );
        }
    });
}

function navigatePage(step) {
    currentPage += step;
}

$('a[data-bs-toggle="tab"]').on("click", function (e) {
    calibrationProcessTable.ajax.reload();
    table.ajax.reload();
});

window.onbeforeunload = function () {
    sessionStorage.clear();
};

$("#nextButton").on("click", function () {
    calibrationProcessTable.ajax.reload();
    table.ajax.reload();
});

$("#previousButton").on("click", function () {
    table.ajax.reload();
});
