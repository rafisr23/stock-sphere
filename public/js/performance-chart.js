const container = document.getElementById("systemPerformanceGraph");

// Bersihkan isi container jika ada
container.innerHTML = "";

function generatePerformanceGraph(data) {
    container.innerHTML = "";

    // check if data is empty
    if (data.length === 0) {
        const emptyData = document.createElement("h4");
        emptyData.textContent = "No data available";
        container.appendChild(emptyData);
        return;
    } else {
        data.forEach((data) => {
            const uptimeSeconds = parseInt(data.total_uptime_seconds, 10);
            const downtimeSeconds = parseInt(data.total_downtime_seconds, 10);

            const colWrapper = document.createElement("div");
            colWrapper.className = "col-md-4";

            const chartWrapper = document.createElement("div");
            chartWrapper.style.display = "flex";
            chartWrapper.style.flexDirection = "column";
            chartWrapper.style.alignItems = "center";
            chartWrapper.style.marginBottom = "20px";

            const itemLabel = document.createElement("h5");
            itemLabel.textContent = data.item_name;
            itemLabel.style.marginBottom = "10px";

            const options = {
                series: [uptimeSeconds, downtimeSeconds],
                chart: {
                    width: 380,
                    type: "pie",
                },
                labels: ["Uptime", "Downtime"],
                colors: ["#00E396", "#FF4560"],
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

            const chartDiv = document.createElement("div");
            chartDiv.id = `chart-${data.item_unit_id}`;

            chartWrapper.appendChild(itemLabel);
            chartWrapper.appendChild(chartDiv);

            colWrapper.appendChild(chartWrapper);

            container.appendChild(colWrapper);

            // Render chart
            const chart = new ApexCharts(chartDiv, options);
            chart.render();
        });
    }
}

function filterPerformanceData() {
    const fromDate = $("#fromDatePerformance").val();
    const toDate = $("#toDatePerformance").val();

    fetch(`/getPerformanceData/${fromDate}/${toDate}`).then((response) => {
        response.json().then((data) => {
            console.log(data);
            window.performanceData = data;
            generatePerformanceGraph(window.performanceData);
        });
    });
}

$("#fromDatePerformance, #toDatePerformance").on(
    "change",
    filterPerformanceData
);

generatePerformanceGraph(window.performanceData);
