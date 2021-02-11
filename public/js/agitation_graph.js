$(document).ready(function () {
    'use strict';
    var  connection   = $('#application');
    var connection_chart = new Chart(connection, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [
                {
                    label: "Кол-во по фильтру",
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
                    data: datas,
                    spanGaps: false
                },
            ]
        }
    });
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

    $("#print_application").on('click', function () {
        var  newCanvas = document.querySelector('#application');
        var  newCanvasImg = newCanvas.toDataURL("image/jpeg", 1.0);
        var  doc = new jsPDF('landscape');
        doc.setFontSize(20);
        doc.text(15, 15, "Super Cool Chart");
        doc.addImage(newCanvasImg, 'JPEG', 10, 10, 280, 180 );
        doc.save('Выгрузка статистики заявок.pdf');
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


