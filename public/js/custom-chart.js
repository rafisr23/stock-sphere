'use strict';
const groupedSparepartsData = (sparepartsData) => {
    return sparepartsData.reduce((acc, sparepart) => {
        const name = sparepart.sparepart_name;
        acc[name] = (acc[name] || 0) + 1;
        return acc;
    }, {});
};

function floatchart(sparepartsData) {
    const groupedSpareparts = groupedSparepartsData(sparepartsData);
    var sparepart_options = {
        chart: {
            type: 'bar',
            height: 500,
            toolbar: {
                show: false
            }
        },
        colors: ['#1DE9B6'],
        stroke: {
            show: true,
            width: 1,
            colors: ['transparent']
        },
        fill: {
            type: 'gradient',
            gradient: {
                type: 'vertical',
                stops: [0, 100],
                shadeIntensity: 0.5,
                gradientToColors: ['#1DC4E9']
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 1
        },
        plotOptions: {
            bar: {
                columnWidth: '45%',
                borderRadius: 4
            }
        },
        grid: {
            strokeDashArray: 4
        },
        series: [
            {
                name: 'Jumlah Sparepart',
                data: Object.values(groupedSpareparts)
            }
        ],
        xaxis: {
            categories: Object.keys(groupedSpareparts),
            labels: {
                hideOverlappingLabels: true
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        }
    };
    if (window.sparepart_chart) {
        window.sparepart_chart.updateOptions({
            series: [
                {
                    name: 'Jumlah Sparepart',
                    data: Object.values(groupedSpareparts)
                }
            ],
            xaxis: {
                categories: Object.keys(groupedSpareparts)
            }
        }).catch(error => console.error("Error updating chart:", error));
    } else {
        window.sparepart_chart = new ApexCharts(document.querySelector('#sparepartsRepairmentGraph'), sparepart_options);
        window.sparepart_chart.render().catch(error => console.error("Error rendering chart:", error));
    }
}

function updateSparepartChart(sparepartsData) {
    const groupedSpareparts = groupedSparepartsData(sparepartsData);

    window.sparepart_chart.updateOptions({
        series: [
            {
                name: 'Jumlah Sparepart',
                data: Object.values(groupedSpareparts)
            }
        ],
        xaxis: {
            categories: Object.keys(groupedSpareparts)
        }
    }).catch(error => console.error("Error updating chart:", error));
}

function filterSparepartData() {
    const item_id = $("#selectItem").val();
    const fromDate = $("#fromDateSparepart").val();
    const toDate = $("#toDateSparepart").val();

    let filteredData = window.sparepartsData;
    if (item_id !== 'All') {
        filteredData = filteredData.filter(item => item.items_id == item_id);
    }

    filteredData = filteredData.filter(item => {
        const itemDate = new Date(item.date);
        const itemDateStr = itemDate.toISOString().split('T')[0];

        const isAfterFromDate = fromDate ? itemDateStr >= fromDate : true;
        const isBeforeToDate = toDate ? itemDateStr <= toDate : true;

        return isAfterFromDate && isBeforeToDate;
    });

    floatchart(filteredData);
}

document.addEventListener("DOMContentLoaded", () => {
    floatchart(window.sparepartsData);
    $("#selectItem").on('change', filterSparepartData);
    $("#fromDateSparepart, #toDateSparepart").on('change', filterSparepartData);
});
