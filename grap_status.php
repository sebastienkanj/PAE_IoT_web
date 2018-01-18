<?php
include 'temp.php';
include 'humi.php';
include 'status.php';
include 'id.php';



$rawdata_humi = gethumi();
$rawdata_temp = gettemp();
$rawdata_status = getstatus();
$rawdata_id = getid();

//Adaptar el tiempo
for ($i = 0; $i < count($rawdata_humi); $i++) {
    $time = $rawdata_humi[$i]["Time"];
    $date = new DateTime($time);
    $rawdata_humi[$i]["Time"] = $date->getTimestamp() * 1000;
}

for ($i = 0; $i < count($rawdata_temp); $i++) {
    $t = $rawdata_temp[$i]["Time"];
    $date = new DateTime($t);
    $rawdata_temp[$i]["Time"] = $date->getTimestamp() * 1000;
}

for ($i = 0; $i < count($rawdata_status); $i++) {
    $time = $rawdata_status[$i]["Time"];
    $date = new DateTime($time);
    $rawdata_status[$i]["Time"] = $date->getTimestamp() * 1000;
}
?>
<html>
    <body>
        //<meta charset="utf-8"> 

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <!-- Importo el archivo Javascript de Highcharts directamente desde su servidor -->
        <script src="http://code.highcharts.com/stock/highstock.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>

        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <script type='text/javascript'>
            $(function () {
                $(document).ready(function () {
                Highcharts.setOptions({
                global: {
                useUTC: false
                }
                });
                        //var chart;
                        $('#container').highcharts({
                chart: {
                type: 'column',
                        animation: Highcharts.svg, // don't animate in old IE
                        marginRight: 10,
                        events: {
                        load: function () {

                        }
                        }
                },
                        title: {
                        text: 'Devices Status Data'
                        },
                        xAxis: {
                        type: 'datetime',
                                interval: 1,
                                rotation: 45,
                                tickPixelInterval: 150
                        },
                        yAxis: {
                        title: {
                        text: 'Value'
                        },
                                plotLines: [{
                                value: 0,
                                        width: 1,
                                        color: '#808080'
                                }]
                        },
                        tooltip: {
                        formatter: function () {
                        return '<b>' + this.series.name + '</b><br/>' +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                                Highcharts.numberFormat(this.y, 2);
                        }
                        },
                        legend: {
                        enabled: true
                        },
                        exporting: {
                        enabled: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.05,
                                borderWidth: 0
                            }
                        },
                        series: [

                        <?php
                            for ($i = 0; $i < count($rawdata_id); $i++) {
                        ?>
                            {
                            name: 'Status of Device with ' + '<?php echo json_encode($rawdata_id[$i]) ?>',
                                    type: 'column',
                                    data: (function () {
                                    var data = [];
                        <?php
    for ($j = 0; $j < count($rawdata_status); $j++) {
        if ($rawdata_status[$j]["Device_ID"] == $rawdata_id[$i]["ID"]) {
                        ?>
                                            data.push([<?php echo $rawdata_status[$j]["Time"]; ?>,<?php echo $rawdata_status[$j]["Status"]; ?>]);
    <?php
        }
    }
    ?>
                                    return data;
                                    })()
                                    
       <?php if ($i < (count($rawdata_id)-1)) {?>
    },
<?php } else{ ?>
    }]
<?php }?>                     
<?php } ?>

                        

                });
                }
                );

            });


        </script>
    </body>
</html>