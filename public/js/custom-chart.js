"use strict";

const groupedSparepartsData = (sparepartsData = []) => {
    return sparepartsData.reduce((acc, sparepart) => {
        const name = sparepart.sparepart_name;
        acc[name] = (acc[name] || 0) + 1;
        return acc;
    }, {});
};

const groupedItemsData = (itemsData = []) => {
    return itemsData.reduce((acc, item) => {
        const name = item.item_name;
        acc[name] = (acc[name] || 0) + 1;
        return acc;
    }, {});
};

function generateDynamicColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        // Generate a random color in hex format
        const color = `#${Math.floor(Math.random() * 16777215)
            .toString(16)
            .padStart(6, "0")}`;
        colors.push(color);
    }
    return colors;
}

let currentItemChartType = "line"; // Default chart type for items

function floatchart(sparepartsData = [], itemsData = [], data = "") {
    const groupedItems = groupedItemsData(itemsData);
    const chartType = currentItemChartType; // Determines the active chart type
    const dynamicColors = generateDynamicColors(
        Object.keys(groupedItems).length
    );

    // Chart configuration options
    const item_options_line = {
        chart: {
            type: "line",
            height: 500,
            toolbar: { show: false },
        },
        colors: ["#1DE9B6"],
        series: [
            {
                name: "Jumlah Item",
                data: Object.values(groupedItems),
            },
        ],
        xaxis: {
            categories: Object.keys(groupedItems),
        },
        dataLabels: { enabled: false },
        grid: { strokeDashArray: 4 },
        stroke: { width: 3, curve: "smooth" },
    };

    const item_options_pie = {
        chart: {
            type: "pie",
            height: 500,
            toolbar: { show: false },
        },
        colors: dynamicColors,
        series: Object.values(groupedItems),
        labels: Object.keys(groupedItems),
        legend: { position: "bottom" },
        dataLabels: { enabled: true },
        plotOptions: {
            pie: {
                donut: {
                    size: "70%",
                },
            },
        },
    };

    // Dynamically set options based on the chart type
    const selectedOptions =
        chartType === "pie" ? item_options_pie : item_options_line;

    if (window.item_chart) {
        window.item_chart
            .updateOptions(selectedOptions) // Update based on current type
            .catch((error) => console.error("Error updating chart:", error));
    } else {
        window.item_chart = new ApexCharts(
            document.querySelector("#itemsRepairmentGraph"),
            selectedOptions
        );
        window.item_chart
            .render()
            .catch((error) => console.error("Error rendering chart:", error));
    }

    // Spareparts chart logic remains as is
    const groupedSpareparts = groupedSparepartsData(sparepartsData);
    const sparepart_options = {
        chart: {
            type: "bar",
            height: 500,
        },
        series: [
            {
                name: "Jumlah Sparepart",
                data: Object.values(groupedSpareparts),
            },
        ],
        xaxis: {
            categories: Object.keys(groupedSpareparts),
        },
    };

    if (window.sparepart_chart) {
        window.sparepart_chart
            .updateOptions(sparepart_options)
            .catch((error) => console.error("Error updating chart:", error));
    } else {
        window.sparepart_chart = new ApexCharts(
            document.querySelector("#sparepartsRepairmentGraph"),
            sparepart_options
        );
        window.sparepart_chart
            .render()
            .catch((error) =>
                console.error("Error rendering spareparts chart:", error)
            );
    }
}

function updateItemChart(itemsData = []) {
    const groupedItems = groupedItemsData(itemsData);
    window.item_chart
        .updateOptions({
            series: [
                {
                    name: "Jumlah Item",
                    data: Object.values(groupedItems),
                },
            ],
            xaxis: {
                categories: Object.keys(groupedItems),
            },
        })
        .catch((error) => console.error("Error updating chart:", error));
}

// Add the correct event listeners for chart switching
document.querySelector("#chart-line").addEventListener("click", () => {
    currentItemChartType = "line";
    floatchart(window.sparepartsData, window.itemsData);
});

document.querySelector("#chart-pie").addEventListener("click", () => {
    currentItemChartType = "pie";
    floatchart(window.sparepartsData, window.itemsData);
});

function updateSparepartChart(sparepartsData = []) {
    const groupedSpareparts = groupedSparepartsData(sparepartsData);

    window.sparepart_chart
        .updateOptions({
            series: [
                {
                    name: "Jumlah Sparepart",
                    data: Object.values(groupedSpareparts),
                },
            ],
            xaxis: {
                categories: Object.keys(groupedSpareparts),
            },
        })
        .catch((error) => console.error("Error updating chart:", error));
}

function filterItemData() {
    const fromDate = $("#fromDateItem").val();
    const toDate = $("#toDateItem").val();

    let filteredDataItem = window.itemsData;

    filteredDataItem = filteredDataItem.filter((item) => {
        const itemDate = new Date(item.date);
        const itemDateStr = itemDate.toISOString().split("T")[0];

        const isAfterFromDate = fromDate ? itemDateStr >= fromDate : true;
        const isBeforeToDate = toDate ? itemDateStr <= toDate : true;

        return isAfterFromDate && isBeforeToDate;
    });

    floatchart(filteredDataItem);
}

function filterSparepartData() {
    const item_id = $("#selectItem").val();
    const fromDate = $("#fromDateSparepart").val();
    const toDate = $("#toDateSparepart").val();

    let filteredDataSparepart = window.sparepartsData;
    if (item_id !== "All") {
        filteredDataSparepart = filteredDataSparepart.filter(
            (item) => item.items_id == item_id
        );
    }

    filteredDataSparepart = filteredDataSparepart.filter((item) => {
        const itemDate = new Date(item.date);
        const itemDateStr = itemDate.toISOString().split("T")[0];

        const isAfterFromDate = fromDate ? itemDateStr >= fromDate : true;
        const isBeforeToDate = toDate ? itemDateStr <= toDate : true;

        return isAfterFromDate && isBeforeToDate;
    });

    floatchart(filteredDataSparepart);
}

document.addEventListener("DOMContentLoaded", () => {
    if (
        Array.isArray(window.sparepartsData) &&
        Array.isArray(window.itemsData)
    ) {
        floatchart(window.sparepartsData, window.itemsData);
    } else {
        console.error(
            "Ensure window.sparepartsData and window.itemsData are defined as arrays."
        );
    }

    $("#selectItem").on("change", filterSparepartData);
    $("#fromDateSparepart, #toDateSparepart").on("change", filterSparepartData);
    $("#fromDateItem, #toDateItem").on("change", filterItemData);
});
