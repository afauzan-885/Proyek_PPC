// Grafik Untuk Jumlah PO
var options = {
    chart: {
        height: 350,
        type: "line",
        toolbar: {
            show: false,
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "smooth",
        width: 6,
    },
    series: [
        {
            name: "PO (Pesanan)",
            data: [10, 32, 36, 41, 22, 15, 21, 3, 10, 12, 5, 29],
        },
    ],
    grid: {
        borderColor: "#dfd6ff",
        strokeDashArray: 5,
        xaxis: {
            lines: {
                show: true,
            },
        },
        yaxis: {
            lines: {
                show: false,
            },
        },
    },
    xaxis: {
        categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ],
    },
    yaxis: {
        labels: {
            show: true,
        },
    },
    fill: {
        type: "gradient",
        gradient: {
            shade: "dark",
            gradientToColors: ["#e65729"],
            shadeIntensity: 1,
            type: "horizontal",
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100],
        },
    },
};

var chart = new ApexCharts(document.querySelector("#jumlah_po"), options);
chart.render();

// Grafik Untuk Jumlah Barang
var options = {
    chart: {
        height: 350,
        type: "line",
        toolbar: {
            show: false,
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "smooth",
        width: 6,
    },
    series: [
        {
            name: "Barang (Kg)",
            data: [
                200, 500, 3000, 4000, 228, 351, 212, 323, 123, 121, 521, 219,
            ],
        },
    ],
    grid: {
        borderColor: "#dfd6ff",
        strokeDashArray: 5,
        xaxis: {
            lines: {
                show: true,
            },
        },
        yaxis: {
            lines: {
                show: false,
            },
        },
    },
    xaxis: {
        categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ],
    },
    yaxis: {
        labels: {
            show: true,
        },
    },
    fill: {
        type: "gradient",
        gradient: {
            shade: "dark",
            gradientToColors: ["#e65729"],
            shadeIntensity: 1,
            type: "horizontal",
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100],
        },
    },
};

var chart = new ApexCharts(document.querySelector("#jumlah_barang"), options);

chart.render();

// Grafik Untuk Jumlah Kenaikan Costumer
var options = {
    chart: {
        height: 350,
        type: "line",
        toolbar: {
            show: false,
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "smooth",
        width: 6,
    },
    series: [
        {
            name: "Costumer",
            data: [1, 0, 1, 2, 4, 2, 1, 0, 1, 1, 2, 6],
        },
    ],
    grid: {
        borderColor: "#dfd6ff",
        strokeDashArray: 5,
        xaxis: {
            lines: {
                show: true,
            },
        },
        yaxis: {
            lines: {
                show: false,
            },
        },
    },
    xaxis: {
        categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ],
    },
    yaxis: {
        labels: {
            show: true,
        },
    },
    fill: {
        type: "gradient",
        gradient: {
            shade: "dark",
            gradientToColors: ["#e65729"],
            shadeIntensity: 1,
            type: "horizontal",
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100],
        },
    },
};

var chart = new ApexCharts(document.querySelector("#jumlah_costumer"), options);

chart.render();
