$(document).ready(function () {
    'use strict';
    if (dataset1 && dataset2 && dataset3){
        var  connection   = $('#connection');
        var connection_chart = new Chart(connection, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: "Подключения интернет",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: "rgba(51, 179, 90, 0.38)",
                    borderColor: "#33B35A",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: "#33B35A",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#33B35A",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataset1,
                    spanGaps: false
                },
                {
                    label: "Отключения интернет",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataset2,
                    spanGaps: false
                },
                {
                    label: "Подключение кабельное тв",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: "rgba(192,174,41,0.4)",
                    borderColor: "rgb(192,183,15)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: "rgba(192,174,41,0.4)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(192,174,41,0.4)",
                    pointHoverBorderColor: "#fff",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataset3,
                    spanGaps: false
                },
                {
                    label: "Отключение кабельное тв",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: "rgba(94,192,25,0.4)",
                    borderColor: "rgb(111,192,66)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: "rgba(94,192,25,0.4)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(94,192,25,0.4)",
                    pointHoverBorderColor: "#fff",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataset4,
                    spanGaps: false
                },
                {
                    label: "Подключение Цифровое тв",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: "rgba(192,25,0,0.4)",
                    borderColor: "rgb(192,120,89)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: "rgba(192,25,0,0.4)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(192,25,0,0.4)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataset5,
                    spanGaps: false
                },
                {
                    label: "Отключения Цифровое тв",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: "rgba(3,21,192,0.4)",
                    borderColor: "rgb(16,62,192)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: "rgba(3,21,192,0.4)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(3,21,192,0.4)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: dataset6,
                    spanGaps: false
                }
            ]
        }
    });
    }
    if (dataset1 && !dataset2){
        var  connection_itv   = $('#connection_itv');
        var  connection_chart_itv = new Chart(connection_itv, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: "Подключения",
                        fill: true,
                        lineTension: 0.3,
                        backgroundColor: "rgba(51, 179, 90, 0.38)",
                        borderColor: "#33B35A",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        borderWidth: 1,
                        pointBorderColor: "#33B35A",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#33B35A",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: dataset1,
                        spanGaps: false
                    },
                ]
            }
        });
    }
    $("#print_connection").on('click', function () {
        var  newCanvas = document.querySelector('#connection');
        var  newCanvasImg = newCanvas.toDataURL("image/jpeg", 1.0);
        var  doc = new jsPDF('landscape');
        doc.setFontSize(20);
        doc.text(15, 15, "Super Cool Chart");
        doc.addImage(newCanvasImg, 'JPEG', 10, 10, 280, 150 );
        doc.save('Выгрузка статистики подключений.pdf');
    });
    $("#print_connection_itv").on('click', function () {
        var  newCanvas = document.querySelector('#connection_itv');
        var  newCanvasImg = newCanvas.toDataURL("image/jpeg", 1.0);
        var  doc = new jsPDF('landscape');
        doc.setFontSize(20);
        doc.text(15, 15, "Super Cool Chart");
        doc.addImage(newCanvasImg, 'JPEG', 10, 10, 280, 150 );
        doc.save('Выгрузка статистики подключений.pdf');
    });



    $("#print_agitation").on('click', function () {
        var  newCanvas = document.querySelector('#agitation');
        var  newCanvasImg = newCanvas.toDataURL("image/jpeg", 1.0);
        var  doc = new jsPDF('landscape');
        doc.setFontSize(20);
        doc.text(15, 15, "Super Cool Chart");
        doc.addImage(newCanvasImg, 'JPEG', 10, 10, 280, 180 );
        doc.save('Выгрузка статистики агитации.pdf');
    });
});


