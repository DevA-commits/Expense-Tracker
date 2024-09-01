function getChartColorsArray(e) {
    if (null !== document.getElementById(e)) {
        var t = document.getElementById(e).getAttribute("data-colors");
        if (t) return (t = JSON.parse(t)).map(function (e) {
            var t = e.replace(" ", "");
            return -1 === t.indexOf(",") ? getComputedStyle(document.documentElement).getPropertyValue(t) || t : 2 == (e = e.split(",")).length ? "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")" : t
        });
        console.warn("data-colors Attribute not found on:", e)
    }
}
var options, chart, linechartcustomerColors = getChartColorsArray("projects-overview-chart"),
    isApexSeriesData = (linechartcustomerColors && (options = {
        series: [{
            name: "Number of Projects",
            type: "bar",
            data: [34, 65, 46, 68, 49, 61, 42, 44, 78, 52, 63, 67]
        }, {
            name: "Revenue",
            type: "bar",
            data: [89.25, 98.58, 68.74, 108.87, 77.54, 84.03, 51.24, 28.57, 92.57, 42.36, 88.51, 36.57]
        }, {
            name: "Active Projects",
            type: "bar",
            data: [8, 12, 7, 17, 21, 11, 5, 9, 7, 29, 12, 35]
        }],
        chart: {
            height: 374,
            type: "line",
            toolbar: {
                show: !1
            }
        },
        stroke: {
            curve: "smooth",
            dashArray: [0, 3, 0],
            width: [0, 1, 0]
        },
        fill: {
            opacity: [1, .1, 1]
        },
        markers: {
            size: [0, 4, 0],
            strokeWidth: 2,
            hover: {
                size: 4
            }
        },
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            axisTicks: {
                show: !1
            },
            axisBorder: {
                show: !1
            }
        },
        grid: {
            show: !0,
            xaxis: {
                lines: {
                    show: !0
                }
            },
            yaxis: {
                lines: {
                    show: !1
                }
            },
            padding: {
                top: 0,
                right: -2,
                bottom: 15,
                left: 10
            }
        },
        legend: {
            show: !0,
            horizontalAlign: "center",
            offsetX: 0,
            offsetY: -5,
            markers: {
                width: 9,
                height: 9,
                radius: 6
            },
            itemMargin: {
                horizontal: 10,
                vertical: 0
            }
        },
        plotOptions: {
            bar: {
                columnWidth: "30%",
                barHeight: "70%"
            }
        },
        colors: ['#3579A3', '#F7B84B', '#0AB39C'],
        tooltip: {
            shared: !0,
            y: [{
                formatter: function (e) {
                    return void 0 !== e ? e.toFixed(0) : e
                }
            }, {
                formatter: function (e) {
                    return void 0 !== e ? "$" + e.toFixed(2) + "k" : e
                }
            }, {
                formatter: function (e) {
                    return void 0 !== e ? e.toFixed(0) : e
                }
            }]
        }
    }, (chart = new ApexCharts(document.querySelector("#projects-overview-chart"), options)).render()), {});


function scrollToBottom(r) {
    setTimeout(function () {
        var e = document.getElementById(r).querySelector("#chat-conversation .simplebar-content-wrapper") ? document.getElementById(r).querySelector("#chat-conversation .simplebar-content-wrapper") : "",
            t = document.getElementsByClassName("chat-conversation-list")[0] ? document.getElementById(r).getElementsByClassName("chat-conversation-list")[0].scrollHeight - window.innerHeight + 600 : 0;
        t && e.scrollTo({
            top: t,
            behavior: "smooth"
        })
    }, 100)
}
scrollToBottom(currentChatId);