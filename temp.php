<?php
function gettemp(){
$con = mysqli_connect("147.83.175.32", "root", "", "dev");
 
if (mysqli_connect_errno($con)) {
    echo "Failed to connect to DataBase: " . mysqli_connect_error();
} else {
    $data_points = array();
    $result = mysqli_query($con, "SELECT Calendar, Temperature, Device_ID FROM Sensor_Data"); 
    $j=0;
    while ($row = mysqli_fetch_array($result)) {
        $point = array("Time"=>$row['Calendar'], "Temperature" => $row['Temperature'], "Device_ID"=>$row['Device_ID']);
        array_push($data_points, $point);
        $j=$j+1;
    }
    //$rawdata=json_encode($data_points);
}
mysqli_close($con);
//echo sizeof($data_points);
return $data_points;
}
?>




