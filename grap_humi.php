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
        <meta charset="utf-8"> 

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
                type: 'spline',
                        animation: Highcharts.svg, // don't animate in old IE
                        marginRight: 10,
                        events: {
                        load: function () {

                        }
                        }
                },
                        title: {
                        text: 'Devices Humidity Data'
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
                        series: [

                        <?php
                            for ($i = 0; $i < count($rawdata_id); $i++) {
                        ?>
                            {
                            name: 'Humidity of Device with ' + '<?php echo json_encode($rawdata_id[$i]) ?>',
                                    type: 'spline',
                                    data: (function () {
                                    var data = [];
                        <?php
    for ($j = 0; $j < count($rawdata_humi); $j++) {
        if ($rawdata_humi[$j]["Device_ID"] == $rawdata_id[$i]["ID"]) {
                        ?>
                                            data.push([<?php echo $rawdata_humi[$j]["Time"]; ?>,<?php echo $rawdata_humi[$j]["Humidity"]; ?>]);
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

    <h2><a href="/web/index.html">Go Back</a></h2>
    </body>
</html>