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

    dataIn = [
        <?php echo implode ( ",\n", $banda->getGraficoDataIn() ) ?>
    ];
    dataOut = [
        <?php echo implode ( ",\n", $banda->getGraficoDataOut() ) ?>
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
                enabled: true
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
                    marker: [{
                                radius: 2
                            },{
                                radius: 2
                            }],
                    lineWidth: [1,1],
                    states: [
                        {
                            hover: {
                                lineWidth: 1
                            }
                        },{
                            hover: {
                                lineWidth: 1
                            }
                        }
                    ],
                    threshold: null
                }
            },
            series: [
                {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(.3).get('rgba')]
                        ]
                    },
                    type: 'area',
                    name: 'Upload ao servidor',
                    data: dataIn,
                    tooltip: {
                        enabled: false,
                        pointFormatter: pointFormatter_funcion
                    }
                },{
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[1]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[1]).setOpacity(.3).get('rgba')]
                        ]
                    },
                    type: 'area',
                    name: 'Download do servidor',
                    data: dataOut,
                    tooltip: {
                        enabled: false,
                        pointFormatter: pointFormatter_funcion
                    }
                }
            ]
        });
    });

</script>


</body>
</html>
