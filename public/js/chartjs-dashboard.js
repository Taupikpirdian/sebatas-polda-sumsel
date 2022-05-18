! function(n) {
    "use strict";
    n(function() {
        var e = n("#lineChart").get(0).getContext("2d");
        new Chart(e, {
            type: "line",
            data: {
                labels: [
                    "2014", 
                    "2014", 
                    "2015", 
                    "2016", 
                    "2017", 
                    "2018",
                    "2013",  
                    "2019"
                ],
                datasets: [{
                    label: "Progress",
                    data: [
                        120, 
                        180, 
                        140, 
                        210, 
                        160, 
                        240, 
                        180, 
                        210
                    ],
                    borderColor: ["#f96565"],
                    borderWidth: 3,
                    fill: !1,
                    pointBackgroundColor: "#ffffff",
                    pointBorderColor: "#f96565"
                }, {
                    label: "Selesai",
                    data: [
                        80, 
                        140, 
                        100, 
                        170, 
                        120, 
                        200, 
                        140, 
                        170
                    ],
                    borderColor: ["#769530"],
                    borderWidth: 3,
                    fill: !1,
                    pointBackgroundColor: "#ffffff",
                    pointBorderColor: "#769530"
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: !1,
                            borderDash: [3, 3],
                            zeroLineColor: "#7b919e"
                        },
                        ticks: {
                            min: 0,
                            color: "#7b919e"
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: !1,
                            drawBorder: !1,
                            color: "#ffffff"
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: .2
                    },
                    point: {
                        radius: 4
                    }
                },
                stepsize: 1
            }
        })
    })
}(jQuery);