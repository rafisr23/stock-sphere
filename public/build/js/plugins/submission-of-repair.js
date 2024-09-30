const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
const getItemsTableUrl = `/submission-of-repair`;
const getItemsUrl = `/submission-of-repair/getItems`;
const storeTemporaryFileUrl = `/submission-of-repair/store/temporary-file`;

let selectedItems = [];
let checkAllStatus = false;
let currentPage = 0;

let table = $("#items_table").DataTable({
    fixedHeader: true,
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: getItemsTableUrl,
    order: [[1, "asc"]],
    columns: [
        {
            data: "checkbox",
            name: "checkbox",
            orderable: false,
            searchable: false,
            className: "text-center",
        },
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
            data: "units_name",
            name: "units_name",
        },
        {
            data: "serial_number",
            name: "serial_number",
        },
        {
            data: "last_checked_date",
            name: "last_checked_date",
        },
        {
            data: "last_serviced_date",
            name: "last_serviced_date",
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

let repairItemTable = $("#repairItemTable").DataTable({
    fixedHeader: true,
    pageLength: 25,
    lengthChange: true,
    autoWidth: false,
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
        url: getItemsUrl,
        data: function (data) {
            data.id = selectedItems;
        },
    },
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
            data: "description",
            name: "description",
        },
        {
            data: "evidance",
            name: "evidance",
        },
    ],
    drawCallback: function () {
        loadRepairDescription();
        loadUploadedFiles();
    },
});

$("#items_table").on("change", "input.select-row", function () {
    let id = $(this).val();

    if ($(this).is(":checked")) {
        if (!selectedItems.includes(id)) {
            selectedItems.push(id);
        }
        if (
            $("input.select-row").length ===
            $("input.select-row:checked").length
        ) {
            checkAllStatus = true;
            $("#toggle-check")
                .text("Uncheck All")
                .removeClass("btn-secondary")
                .addClass("btn-warning");
        }
    } else {
        let index = selectedItems.indexOf(id);
        if (index !== -1) {
            selectedItems.splice(index, 1);
        }
        if (selectedItems.length === 0) {
            checkAllStatus = false;
            $("#toggle-check")
                .text("Check All")
                .removeClass("btn-warning")
                .addClass("btn-secondary");
        }
    }
});

$("#toggle-check").on("click", function (event) {
    event.preventDefault();
    checkAllStatus = !checkAllStatus;

    $("input.select-row").each(function () {
        $(this).prop("checked", checkAllStatus).trigger("change");
    });

    $(this)
        .text(checkAllStatus ? "Uncheck All" : "Check All")
        .toggleClass("btn-warning", checkAllStatus)
        .toggleClass("btn-secondary", !checkAllStatus);
});

function getItems() {
    $("#repairItemDescription").empty();
    $("#repairItemDetailWrapper").empty();

    if (selectedItems.length > 0) {
        repairItemTable.draw();
        loadRepairDescription();
    }
}

function saveRepairDescription() {
    $('textarea[id^="description"]').each(function () {
        let itemId = $(this).attr("id");
        let description = $(this).val();
        sessionStorage.setItem(itemId, description);
    });
}

function loadRepairDescription() {
    $('textarea[id^="description"]').each(function () {
        let itemId = $(this).attr("id");
        let savedDescription = sessionStorage.getItem(itemId);
        if (savedDescription !== null) {
            $(this).val(savedDescription);
        }
    });
}

function loadUploadedFiles() {
    $('input[type="file"][id^="evidance"]').each(function () {
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
    saveRepairDescription();
}

$('a[data-bs-toggle="tab"]').on("click", function (e) {
    saveRepairDescription();
});

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
        $('input[type="file"][id^="evidance"]').each(function () {
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
                        allowOutsideClick: true,
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = "/submission-of-repair";
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "An error occurred while submitting the repair!",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
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
    formData.append("evidance", file);
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
