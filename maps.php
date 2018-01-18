<?php
include 'coord.php';
$rawdata_coord= getcoord();
?>

<html>
<head>
  <title>My Devices Map</title>
  <style>
    #map{
      height:1000px;
      width:100%;
    }
  </style>
</head>
<body>
  <h1>My Google Map</h1>
  <div id="map"></div>
  <script>
    function initMap(){
      var options = {
        zoom:4,
        center:{lat:41.385064,lng:2.173403}
      }

      var map = new google.maps.Map(document.getElementById('map'), options);
      
      // Array of markers
      var markers = [
            <?php 
            for($i=0; $i<count($rawdata_coord); $i++){
            ?>
        {
            coords:{lat: <?php echo $rawdata_coord[$i]["Latitude"]?>, lng:<?php echo $rawdata_coord[$i]["Longitude"]?>},
          content:'<h1>Device ' + '<?php echo $i+1?>' + '</h1>'
        <?php if($i != (count($rawdata_coord)-1)){ ?>
        },
            <?php } else{ ?>
            }]; 
        <?php }?> 
            <?php } ?>

      // Loop through markers
      for(var i = 0;i < markers.length;i++){
        // Add marker
        addMarker(markers[i]);
      }

      // Add Marker Function
      function addMarker(props){
        var marker = new google.maps.Marker({
          position:props.coords,
          map:map,
        });

        // Check content
        if(props.content){
          var infoWindow = new google.maps.InfoWindow({
            content:props.content
          });
          marker.addListener('click', function(){
            infoWindow.open(map, marker);
          });
        }
      }
    }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2zmhCncVbCcgXrHjx9xQQF67033YfcHQ&callback=initMap"
                async defer>
        </script>
        <h2><a href="/web/index.html">Go Back</a></h2>
    </body>
</html>