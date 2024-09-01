function getChartColorsArray(e) {
    if (null !== document.getElementById(e)) {
        var o = document.getElementById(e).getAttribute("data-colors");
        if (o)
            return (o = JSON.parse(o)).map(function (e) {
                var o = e.replace(" ", "");
                return -1 === o.indexOf(",")
                    ? getComputedStyle(
                        document.documentElement
                    ).getPropertyValue(o) || o
                    : 2 == (e = e.split(",")).length
                        ? "rgba(" +
                        getComputedStyle(
                            document.documentElement
                        ).getPropertyValue(e[0]) +
                        "," +
                        e[1] +
                        ")"
                        : o;
            });
        console.warn("data-colors atributes not found on", e);
    }
}

// get laundry booking count value
var laundryCounter = document.querySelector(".laundry-counter-value");
var laundryTargetValue = laundryCounter.getAttribute("data-target");

// get maid and beautician booking count value
var mbCounter = document.querySelector(".mb-counter-value");
var mbTargetValue = mbCounter.getAttribute("data-target");

// get mep booking count value
var mepCounter = document.querySelector(".mep-counter-value");
var mepTargetValue = mepCounter.getAttribute("data-target");

// get pest control booking count value
var pcCounter = document.querySelector(".pc-counter-value");
var pcTargetValue = pcCounter.getAttribute("data-target");

var options,
    chart,
    worldemapmarkers,
    overlay,
    linechartcustomerColors = getChartColorsArray("customer_impression_charts"),
    chartDonutBasicColors =
        (linechartcustomerColors &&
            ((chart = new ApexCharts(
                document.querySelector("#customer_impression_charts"),
                options
            )).render()),
            getChartColorsArray("store-visits-source")),
    vectorMapWorldMarkersColors =
        (chartDonutBasicColors &&
            ((options = {
                series: [parseFloat(laundryTargetValue), parseFloat(mbTargetValue), parseFloat(mepTargetValue), parseFloat(pcTargetValue)],
                labels: ["Laundry", "Maid & Beautician", "Mep", "Pest Control"],
                chart: { height: 333, type: "donut" },
                legend: { position: "bottom" },
                stroke: { show: !1 },
                dataLabels: { dropShadow: { enabled: !1 } },
                colors: chartDonutBasicColors,
            }),
                (chart = new ApexCharts(
                    document.querySelector("#store-visits-source"),
                    options
                )).render()));
