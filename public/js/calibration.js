const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
const getItemsTableUrl = `/calibrations`;
// const getItemsUrl = `/maintenances/getItems`;
const storeTemporaryFileUrl = `/maintenances/store/temporary-file`;

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
            " for maintenance of item " +
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
                url: `/maintenances/store`,
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

$("#assignTechnicianModal").on("show.bs.modal", function (e) {
    let button = $(e.relatedTarget);
    let itemId = button.data("id");
    let nameItem = button.data("name");

    $("#item_unit_id").val(itemId);
    $("#itemName").text(nameItem);
});

let maintenanceItemTable = $("#maintenanceItemTable").DataTable({
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
            d.type = "maintenance";
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
            data: "serial_number",
            name: "serial_number",
        },
        {
            data: "technician",
            name: "technician",
        },
        {
            data: "status",
            name: "status",
            className: "text-center",
            orderable: false,
            searchable: false,
        },
        {
            data: "action",
            name: "action",
            className: "text-center",
            orderable: false,
            searchable: false,
        },
    ],
});

let maintenanceProcessTable = $("#maintenanceProcessTable").DataTable({
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
            data: "description",
            name: "description",
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

$("#maintenanceItemTable").on("click", ".accept", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let url = "maintenances/acceptMaintenances/" + id;
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _method: "PUT",
            _token: CSRF_TOKEN,
            id: id,
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "The maintenance has been successfully accepted!",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text:
                        "An error occurred while accepting the maintenance: " +
                        response.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                });
            }
        },
    });
});

$("#maintenanceItemTable").on("click", ".cancel", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let url = "maintenances/cancelMaintenances/" + id;
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _method: "PUT",
            _token: CSRF_TOKEN,
            id: id,
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "The maintenance has been successfully cancelled!",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text:
                        "An error occurred while accepting the maintenance: " +
                        response.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                });
            }
        },
    });
});

$("#maintenanceItemTable").on("click", ".start", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let url = "maintenances/startMaintenances/" + id;
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _method: "PUT",
            _token: CSRF_TOKEN,
            id: id,
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "The maintenance is starting!",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text:
                        "An error occurred while starting the maintenance: " +
                        response.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                });
            }
        },
    });
});

$("#maintenanceItemTable").on("click", ".finish", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    console.log(id);
    let url = "maintenances/finishMaintenances/" + id;
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _method: "PUT",
            _token: CSRF_TOKEN,
            id: id,
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "The Maintenance is finished!",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text:
                        "An error occurred while finishing the maintenance: " +
                        response.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                });
            }
        },
    });
});
$("#maintenanceProcessTable").on("click", ".update", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    console.log(id);
    let url = "maintenances/update/" + id;
    let formUpdateMaintenance = new FormData();

    let status = $("#status").val();
    let description = $("#description").val();
    let remarks = $("#remarks").val();
    let evidence = sessionStorage.getItem("evidence_file");

    formUpdateMaintenance.append("status", status);
    formUpdateMaintenance.append("description", description);
    formUpdateMaintenance.append("remarks", remarks);
    formUpdateMaintenance.append("evidence", evidence);
    formUpdateMaintenance.append("_token", CSRF_TOKEN);
    formUpdateMaintenance.append("_method", "PUT");

    console.log(formUpdateMaintenance.get("description"));
    console.log(formUpdateMaintenance.get("remarks"));
    console.log(formUpdateMaintenance.get("evidence"));

    $.ajax({
        url: url,
        type: "POST",
        data: formUpdateMaintenance,
        processData: false,
        contentType: false,
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "The Maintenance is updated!",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location.reload();
                }
            });
        },
        error: function (err) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text:
                    "An error occurred while updating the maintenance: " +
                    response.message,
                showConfirmButton: true,
                allowOutsideClick: true,
            });
        },
    });
});
$("#maintenanceProcessTable").on("click", ".finish", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    console.log(id);
    let url = "maintenances/finishMaintenances/" + id;
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _method: "PUT",
            _token: CSRF_TOKEN,
            id: id,
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "The Maintenance is finished!",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text:
                        "An error occurred while finishing the maintenance: " +
                        response.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                });
            }
        },
    });
});

$(document).on("change", 'input[type="file"]', function () {
    let fileInput = $(this);
    let itemId = fileInput.attr("id");
    let file = fileInput[0].files[0];

    let formData = new FormData();
    formData.append("evidence", file);
    formData.append("item_id", itemId);
    formData.append("_token", CSRF_TOKEN);

    $.ajax({
        url: storeTemporaryFileUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success) {
                sessionStorage.setItem(itemId + "_file", response.fileName);
            }
        },
        error: function (err) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An error occurred while uploading the file!",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                allowOutsideClick: true,
            });
        },
    });
});

function loadUploadedFiles() {
    console.log("loadUploadedFiles");
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
    // countPage();
    // saveRepairDescription();
}

$('a[data-bs-toggle="tab"]').on("click", function (e) {
    // saveRepairDescription();
    maintenanceItemTable.ajax.reload();
    table.ajax.reload();
});

window.onbeforeunload = function () {
    sessionStorage.clear();
};

$("#nextButton").on("click", function () {
    navigatePage(1);
    maintenanceItemTable.ajax.reload();
    table.ajax.reload();
});

$("#previousButton").on("click", function () {
    navigatePage(-1);
    maintenanceItemTable.ajax.reload();
    table.ajax.reload();
});
