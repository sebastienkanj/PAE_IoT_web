<?php
function getcoord(){
$con = mysqli_connect("147.83.175.32", "root", "", "dev");
 
if (mysqli_connect_errno($con)) {
    echo "Failed to connect to DataBase: " . mysqli_connect_error();
} else {
    $data_points = array();
    $result = mysqli_query($con, "SELECT ID, Longitude, Latitude FROM Device"); 
    $j=0;
    while ($row = mysqli_fetch_array($result)) {
        $point = array("ID"=>$row['ID'], "Longitude" => $row['Longitude'], "Latitude"=>$row['Latitude']);
        array_push($data_points, $point);
        $j=$j+1;
    }
}
mysqli_close($con);
return $data_points;
}
?>



