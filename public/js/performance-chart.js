// // console.log(performanceData);

// var options = {
//     series: [44, 55, 13, 43, 22],
//     chart: {
//         width: 380,
//         type: "pie",
//     },
//     labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
//     responsive: [
//         {
//             breakpoint: 480,
//             options: {
//                 chart: {
//                     width: 200,
//                 },
//                 legend: {
//                     position: "bottom",
//                 },
//             },
//         },
//     ],
// };

// var chart = new ApexCharts(
//     document.querySelector("#systemPerformanceGraph"),
//     options
// );
// chart.render();

// Data JSON

// Selektor container untuk chart
const container = document.getElementById("systemPerformanceGraph");

// Bersihkan isi container jika ada
container.innerHTML = "";

// Loop melalui data untuk membuat chart
performanceData.forEach((data, index) => {
    // Konversi data string ke angka
    const uptimeSeconds = parseInt(data.total_uptime_seconds, 10);
    const downtimeSeconds = parseInt(data.total_downtime_seconds, 10);

    // Buat elemen wrapper untuk setiap chart dengan class col-md-4
    const colWrapper = document.createElement("div");
    colWrapper.className = "col-md-4";

    // Buat elemen wrapper untuk label dan chart
    const chartWrapper = document.createElement("div");
    chartWrapper.style.display = "flex";
    chartWrapper.style.flexDirection = "column";
    chartWrapper.style.alignItems = "center";
    chartWrapper.style.marginBottom = "20px";

    // Tambahkan label untuk item_name
    const itemLabel = document.createElement("h5");
    itemLabel.textContent = data.item_name;
    itemLabel.style.marginBottom = "10px";

    // Konfigurasi chart untuk setiap item
    const options = {
        series: [uptimeSeconds, downtimeSeconds],
        chart: {
            width: 380,
            type: "pie",
        },
        labels: ["Uptime", "Downtime"],
        colors: ["#00E396", "#FF4560"], // Warna untuk Uptime (hijau) dan Downtime (merah)
        responsive: [
            {
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            },
        ],
    };

    // Buat elemen div baru untuk chart
    const chartDiv = document.createElement("div");
    chartDiv.id = `chart-${data.item_unit_id}`;

    // Tambahkan label dan chart ke wrapper
    chartWrapper.appendChild(itemLabel);
    chartWrapper.appendChild(chartDiv);

    // Tambahkan chartWrapper ke colWrapper
    colWrapper.appendChild(chartWrapper);

    // Tambahkan colWrapper ke container
    container.appendChild(colWrapper);

    // Render chart
    const chart = new ApexCharts(chartDiv, options);
    chart.render();
});
