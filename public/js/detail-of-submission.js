const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
const getRepairmentsTableUrl = `/repairments`;
const addSparePartUrl = `/repairment/add-spare-part`;

let selectedItems = [];
let currentPage = 0;

let table = $("#details_of_repair_submissions_table").DataTable({
    fixedHeader: true,
    processing: true,
    serverSide: true,
    responsive: true,
    deferLoading: 0,
    ajax: {
        url: getRepairmentsTableUrl,
        type: "GET",
        data: function (d) {
            d.table = "repairments";
        },
    },
    order: [[1, "asc"]],
    columns: [
        {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            className: "text-center",
        },
        {
            data: "items_name",
            name: "items_name",
        },
        {
            data: "serial_number",
            name: "serial_number",
        },
        {
            data: "created_at",
            name: "created_at",
        },
        {
            data: "accepted",
            name: "accepted",
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false,
            className: "text-center",
        }
    ],
    drawCallback: function () {
        $("input.select-row").each(function () {
            if (selectedItems.includes($(this).val())) {
                $(this).prop("checked", true);
            }
        });
    },
});


let workOnRepairmentTable = $("#work_on_repairment_table").DataTable({
    fixedHeader: true,
    processing: true,
    serverSide: true,
    responsive: true,
    deferLoading: 0,
    ajax: {
        url: getRepairmentsTableUrl,
        type: "GET",
        data: function (d) {
            d.table = "work-on";
        },
    },
    order: [[1, "asc"]],
    columns: [
        {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            className: "text-center",
        },
        {
            data: "items_name",
            name: "items_name",
        },
        {
            data: "serial_number",
            name: "serial_number",
        },
        {
            data: "status",
            name: "status",
        },
        {
            data: "remark",
            name: "remark",
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false,
            className: "text-center",
        }
    ],
    drawCallback: function () {
        $("input.select-row").each(function () {
            if (selectedItems.includes($(this).val())) {
                $(this).prop("checked", true);
            }
        }
        );
    },
});

$("#details_of_repair_submissions_table").on("click", '.accept', function (e) {
    e.preventDefault();
    let id = $(this).data('id');
    let url = "repairments/acceptRepairments/" + id;
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
                    text: "The repairment has been successfully accepted!",
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
                    text: "An error occurred while accepting the repairment: " + response.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                });
            }
        },
    })
});

$("#details_of_repair_submissions_table").on("click", '.cancel', function (e) {
    e.preventDefault();
    let id = $(this).data('id');
    let url = "repairments/cancelRepairments/" + id;
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
                    text: "The repairment has been successfully cancelled!",
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
                    text: "An error occurred while accepting the repairment: " + response.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                });
            }
        },
    })
});

$("#details_of_repair_submissions_table").on("click", '.start', function (e) {
    e.preventDefault();
    let id = $(this).data('id');
    let url = "repairments/startRepairments/" + id;
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
                    text: "The repairment is starting!",
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
                    text: "An error occurred while starting the repairment: " + response.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                });
            }
        },
    })
});

$("work_on_repairment_table").on("click", '.update', function (e) {
    e.preventDefault();
    let id = $(this).data('id');
    let url = "repairments/update/" + id;
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
                    text: "The repairment is updated!",
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
                    text: "An error occurred while updating the repairment: " + response.message,
                    showConfirmButton: true,
                    allowOutsideClick: true,
                });
            }
        },
    })
});

function countPage() {
    switch (currentPage) {
        case 1:
            getItems();
            loadRepairDescription();
            break;
        default:
            break;
    }
}

function navigatePage(step) {
    currentPage += step;
    countPage();
}


window.onbeforeunload = function () {
    sessionStorage.clear();
};

$("#nextButton").on("click", function () {
    navigatePage(1);
});

$("#previousButton").on("click", function () {
    navigatePage(-1);
});



$("#submitButton").on("click", function () {
    if (selectedItems.length > 0) {
        let formRepairItem = new FormData();

        formRepairItem.append("items", selectedItems);
        $('textarea[id^="description"]').each(function () {
            let itemId = $(this).attr("id");
            let description = $(this).val();
            formRepairItem.append(itemId, description);
        });
        $('input[type="file"][id^="evidence"]').each(function () {
            let itemId = $(this).attr("id");
            let fileName = sessionStorage.getItem(itemId + "_file");
            if (fileName) {
                formRepairItem.append(itemId, fileName);
            }
        });
        formRepairItem.append("_token", CSRF_TOKEN);

        $.ajax({
            url: "/submission-of-repair/store",
            type: "POST",
            data: formRepairItem,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "The repair submission has been successfully submitted!",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = "/submission-of-repair";
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text:
                            "An error occurred while submitting the repair: " +
                            response.message,
                        showConfirmButton: true,
                        allowOutsideClick: true,
                    });
                }
            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred while submitting the repair!",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: true,
                });
            },
        });
        // $("#repairSubmissionForm").submit();
    } else {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Please select at least one item!",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: true,
        });
    }
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