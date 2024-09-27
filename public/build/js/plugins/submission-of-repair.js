let CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
let selectedItems = [];
let checkAllStatus = false;
let currentPage = 0;
let getItemsTableUrl = `/submission-of-repair`;
let getItemsUrl = `/submission-of-repair/getItems`;
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
    let selectedIds = [];
    $("input.select-row:checked").each(function () {
        selectedIds.push($(this).val());
    });
    $("#repairItemDescription").empty(); // Hapus konten sebelumnya

    if (selectedIds.length > 0) {
        $.ajax({
            url: getItemsUrl,
            type: "POST",
            data: {
                _token: CSRF_TOKEN,
                unit_id: selectedIds,
            },
            success: (response) => {
                response.forEach((item, index) => {
                    let newField = `
                            <div class="mb-3">
                                <label class="form-label">Repair Description for <b>${item.items.item_name}</b></label>
                                <textarea type="text" name="description[${item.id}]" class="form-control" placeholder="Enter repair description for ${item.items.item_name}"></textarea>
                            </div>`;
                    $("#repairItemDescription").append(newField);
                });

                // Setelah form di-generate, load data dari sessionStorage jika ada
                loadRepairDescription();
            },
            error: function (error) {
                console.log(error);
            },
        });
    } else {
        let alert = `
                <div class="row justify-content-center">
                    <div class="alert alert-warning d-flex align-items-center justify-content-center col-md-4 text-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                        </svg>
                        <div class="ms-1">Please select at least one item! </div>
                    </div>
                </div>`;
        $("#repairItemDescription").append(alert);
    }
}

function getSummary() {
    $("#summarySubmissionForm").empty();

    let table = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Serial Number</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
            `;

    $('textarea[name^="description"]').each(function () {
        let itemId = $(this).attr("name").match(/\d+/)[0];
        let description = $(this).val();
        let itemName = $(this)
            .closest(".mb-3")
            .find("label")
            .text()
            .replace("Repair Description for ", "");
        let serialNumber = `${itemId}`;

        table += `
                <tr>
                    <td>${itemName}</td>
                    <td>${serialNumber}</td>
                    <td>${description}</td>
                </tr>
                `;
    });

    table += `
                </tbody>
            </table>
            `;

    $("#summarySubmissionForm").append(table);
}

function saveRepairDescription() {
    $('textarea[name^="description"]').each(function () {
        let itemId = $(this).attr("name");
        let description = $(this).val();
        sessionStorage.setItem(itemId, description);
    });
}

function loadRepairDescription() {
    $('textarea[name^="description"]').each(function () {
        let itemId = $(this).attr("name");
        let savedDescription = sessionStorage.getItem(itemId);
        if (savedDescription !== null) {
            $(this).val(savedDescription);
        }
    });
}

$('a[data-bs-toggle="tab"]').on("click", function (e) {
    saveRepairDescription();
});

window.onbeforeunload = function () {
    sessionStorage.clear();
};

function countPage() {
    switch (currentPage) {
        case 1:
            getItems();
            loadRepairDescription();
            break;
        case 2:
            getSummary();
            break;
        default:
            console.log("No action for this page");
            break;
    }
}

function navigatePage(step) {
    currentPage += step;
    countPage();
    saveRepairDescription();
}

$("#nextButton").on("click", function () {
    navigatePage(1);
});

$("#previousButton").on("click", function () {
    navigatePage(-1);
});
