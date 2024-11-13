'use strict';
// const spareparts_name = window.sparepartsData.map((sparepart) => sparepart.sparepart_name);
// const items_id = window.sparepartsData.map((sparepart) => sparepart.items_id);
// const date = window.sparepartsData.map((sparepart) => sparepart.date);
const groupedSpareparts = window.sparepartsData.reduce((acc, sparepart) => {
    const name = sparepart.sparepart_name;

    // Jika nama sparepart sudah ada di accumulator, tambahkan count-nya
    if (acc[name]) {
        acc[name] += 1;
    } else {
        // Jika nama sparepart belum ada, inisialisasi dengan count pertama
        acc[name] = 1;
    }

    return acc;
}, {});

console.log(groupedSpareparts);


function floatchart() {
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
                data: Object.values(groupedSpareparts) // Jumlah sparepart pada sumbu y
            }
        ],
        xaxis: {
            categories: Object.keys(groupedSpareparts), // Nama sparepart pada sumbu x
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
    var sparepart_chart = new ApexCharts(document.querySelector('#sparepartsRepairmentGraph'), sparepart_options);
    sparepart_chart.render().catch(error => console.error("Error rendering chart:", error));
}

document.addEventListener("DOMContentLoaded", floatchart);
