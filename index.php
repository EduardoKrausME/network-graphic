<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title></title>

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:300">
    <link rel="stylesheet" href="assets/style.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="assets/themeDark.min.js"></script>
</head>
<body>


<?php
/**
 * User: Eduardo Kraus
 * Date: 09/11/16
 * Time: 05:23
 */

date_default_timezone_set ( 'America/Sao_Paulo' );

require 'Banda.php';
$banda = new Banda();


?>

<h1>Grafico de banda do servidor</h1>
<div id="grafico_banda"></div>
<script type="text/javascript">

    data = [
        <?php echo implode ( ",\n", $banda->getGraficoData () ) ?>
    ];

    $(function () {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'grafico_banda'
            },
            title: {
                enable: false,
                text: ''
            },
            subtitle: {
                text: ''
            },
            legend: {
                enabled: false
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Banda'
                },
                labels: {
                    formatter: function () {
                        bytes = this.value;
                        sufixo = 'bp/s';
                        if (bytes > 1024) {
                            bytes = bytes / 1024;
                            sufixo = 'Kbp/s';
                        }
                        if (bytes > 1024) {
                            bytes = bytes / 1024;
                            sufixo = 'Mbp/s';
                        }
                        return Highcharts.numberFormat(bytes, 1) + " " + sufixo;
                    }
                },
                min: 0
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Bytes consumidos',
                data: data,
                tooltip: {
                    enabled: false,
                    pointFormatter: function () {
                        bytes = this.y;
                        sufixo = 'bp/s';
                        if (bytes > 1024) {
                            bytes = bytes / 1024;
                            sufixo = 'Kbp/s';
                        }
                        if (bytes > 1024) {
                            bytes = bytes / 1024;
                            sufixo = 'Mbp/s';
                        }
                        return '<span style="font-size: 10px">' + Highcharts.numberFormat(bytes, 2) + ' ' + sufixo + '</span><br/>';
                    }
                }
            }]
        });
    });

</script>


</body>
</html>
