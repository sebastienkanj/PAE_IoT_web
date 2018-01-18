<?php
function getid(){
$con = mysqli_connect("147.83.175.32", "root", "", "dev");
 
if (mysqli_connect_errno($con)) {
    echo "Failed to connect to DataBase: " . mysqli_connect_error();
} else {
    $data_points = array();
    $result = mysqli_query($con, "SELECT * FROM Device"); 
    while ($row = mysqli_fetch_array($result)) {
        $point = array("ID" => $row['ID']);
        array_push($data_points, $point);
    }
    //echo json_encode($data_points);
}
mysqli_close($con);
return $data_points;
}
?>