const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
const getItemsTableUrl = `/maintenances`;
// const getItemsUrl = `/maintenances/getItems`;
const storeTemporaryFileUrl = `/submission-of-repair/store/temporary-file`;

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
    order: [[4, "desc"]],
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
    // drawCallback: function () {
    //     loadMaintenanceDescription();
    //     loadUploadedFiles();
    // },
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

// $('a[data-bs-toggle="tab"]').on("shown.bs.tab", function (e) {
//     let tabId = $(e.target).data("id");
//     let isMaintenanceTab = tabId == "maintenances-tab";
//     $("#submitButton")
//         .prop("disabled", isMaintenanceTab)
//         .prop("hidden", isMaintenanceTab);
// });

// $("#submitButton").on("click", function () {
//     if (selectedItems.length > 0) {
//         let formRepairItem = new FormData();

//         formRepairItem.append("items", selectedItems);
//         // $('textarea[id^="description"]').each(function () {
//         //     let itemId = $(this).attr("id");
//         //     let description = $(this).val();
//         //     formRepairItem.append(itemId, description);
//         // });
//         // $('input[type="file"][id^="evidence"]').each(function () {
//         //     let itemId = $(this).attr("id");
//         //     let fileName = sessionStorage.getItem(itemId + "_file");
//         //     if (fileName) {
//         //         formRepairItem.append(itemId, fileName);
//         //     }
//         // });
//         formRepairItem.append("_token", CSRF_TOKEN);

//         $.ajax({
//             url: "/maintenances/store",
//             type: "POST",
//             data: formRepairItem,
//             processData: false,
//             contentType: false,
//             success: function (response) {
//                 if (response.success) {
//                     Swal.fire({
//                         icon: "success",
//                         title: "Success",
//                         text: "The repair submission has been successfully submitted!",
//                         showConfirmButton: false,
//                         timer: 3000,
//                         timerProgressBar: true,
//                         allowOutsideClick: false,
//                     }).then((result) => {
//                         if (result.dismiss === Swal.DismissReason.timer) {
//                             window.location.href = "/submission-of-repair";
//                         }
//                     });
//                 } else {
//                     Swal.fire({
//                         icon: "error",
//                         title: "Error",
//                         text:
//                             "An error occurred while submitting the maintenance: " +
//                             response.message,
//                         showConfirmButton: true,
//                         allowOutsideClick: true,
//                     });
//                 }
//             },
//             error: function (err) {
//                 Swal.fire({
//                     icon: "error",
//                     title: "Error",
//                     text: "An error occurred while submitting the maintenance!",
//                     showConfirmButton: false,
//                     timer: 3000,
//                     timerProgressBar: true,
//                     allowOutsideClick: true,
//                 });
//             },
//         });
//     } else {
//         Swal.fire({
//             icon: "error",
//             title: "Error",
//             text: "Please select at least one item!",
//             showConfirmButton: false,
//             timer: 3000,
//             timerProgressBar: true,
//             allowOutsideClick: true,
//         });
//     }
// });

// $("#items_table").on("change", "input.select-row", function () {
//     let id = $(this).val();

//     if ($(this).is(":checked")) {
//         if (!selectedItems.includes(id)) {
//             selectedItems.push(id);
//         }
//         if (
//             $("input.select-row").length ===
//             $("input.select-row:checked").length
//         ) {
//             checkAllStatus = true;
//             $("#toggle-check")
//                 .text("Uncheck All")
//                 .removeClass("btn-secondary")
//                 .addClass("btn-warning");
//         }
//     } else {
//         let index = selectedItems.indexOf(id);
//         if (index !== -1) {
//             selectedItems.splice(index, 1);
//         }
//         if (selectedItems.length === 0) {
//             checkAllStatus = false;
//             $("#toggle-check")
//                 .text("Check All")
//                 .removeClass("btn-warning")
//                 .addClass("btn-secondary");
//         }
//     }
// });

// $("#toggle-check").on("click", function (event) {
//     event.preventDefault();
//     checkAllStatus = !checkAllStatus;

//     $("input.select-row").each(function () {
//         $(this).prop("checked", checkAllStatus).trigger("change");
//     });

//     $(this)
//         .text(checkAllStatus ? "Uncheck All" : "Check All")
//         .toggleClass("btn-warning", checkAllStatus)
//         .toggleClass("btn-secondary", !checkAllStatus);
// });

// function getItems() {
//     $("#maintenanceItemDescription").empty();
//     $("#maintenanceItemDetailWrapper").empty();

//     if (selectedItems.length > 0) {
//         maintenanceItemTable.draw();
//         loadMaintenanceDescription();
//     }
// }

// function saveRepairDescription() {
//     $('textarea[id^="description"]').each(function () {
//         let itemId = $(this).attr("id");
//         let description = $(this).val();
//         sessionStorage.setItem(itemId, description);
//     });
// }

// function loadMaintenanceDescription() {
//     $('textarea[id^="description"]').each(function () {
//         let itemId = $(this).attr("id");
//         let savedDescription = sessionStorage.getItem(itemId);
//         if (savedDescription !== null) {
//             $(this).val(savedDescription);
//         }
//     });
// }

// function loadUploadedFiles() {
//     $('input[type="file"][id^="evidence"]').each(function () {
//         let itemId = $(this).attr("id");
//         let fileName = sessionStorage.getItem(itemId + "_file");

//         if (fileName) {
//             $(this).after(
//                 '<p>File uploaded: <a href="/temp/' +
//                     fileName +
//                     '" target="_blank">View file</a></p>'
//             );
//         }
//     });
// }

// function countPage() {
//     switch (currentPage) {
//         case 1:
//             getItems();
//             loadMaintenanceDescription();
//             break;
//         default:
//             break;
//     }
// }

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

// $(document).on("change", 'input[type="file"]', function () {
//     let fileInput = $(this);
//     let itemId = fileInput.attr("id");
//     let file = fileInput[0].files[0];

//     let formData = new FormData();
//     formData.append("evidence", file);
//     formData.append("item_id", itemId);
//     formData.append("_token", CSRF_TOKEN);

//     $.ajax({
//         url: storeTemporaryFileUrl,
//         type: "POST",
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function (response) {
//             if (response.success) {
//                 sessionStorage.setItem(itemId + "_file", response.fileName);
//             }
//         },
//         error: function (err) {
//             Swal.fire({
//                 icon: "error",
//                 title: "Error",
//                 text: "An error occurred while uploading the file!",
//                 showConfirmButton: false,
//                 timer: 3000,
//                 timerProgressBar: true,
//                 allowOutsideClick: true,
//             });
//         },
//     });
// });
