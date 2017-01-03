<?php 

$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

session_start(); 

if(!$_SESSION['username'])
{
header('Location: login.php');
}

$username = $_SESSION['username'];

if(isset($_POST['info']))
{
  $_SESSION['rid'] = $_POST['info'];
}
$info = $_SESSION['rid'];

if(isset($_POST['submit']))
 {
 $event_name = $mysqli->real_escape_string($_POST['ename']);
 $event_location = $mysqli->real_escape_string($_POST['location']);
 $event_description = $mysqli->real_escape_string($_POST['description']);
 $your_date = $mysqli->real_escape_string($_POST['birthday']);
 $event_date = date("Y-m-d", strtotime($your_date));
 $event_time = $mysqli->real_escape_string($_POST['time']);
 
$sql = "UPDATE events SET event_name='$event_name', event_location='$event_location', event_description='$event_description', Date='$event_date', Time='$event_time' WHERE event_id='$info'";

if(mysqli_query($mysqli, $sql)){
    echo "<script>alert('Successfully edited');</script>";
} else{
    echo "ERROR: Could not able to execute";
}
}
$resultSet1 = $mysqli->query("SELECT event_id, event_name, event_location, event_description, event_organizer, Date, EXTRACT(year FROM Date) as year, EXTRACT(month FROM Date) as month, EXTRACT(day FROM Date) as day, Time FROM events WHERE event_id='$info'");

		while($rows = $resultSet1->fetch_assoc())
		{
		$event_name = $rows['event_name'];
		$event_location = $rows['event_location'];
		$event_description = $rows['event_description'];
		$event_organizer = $rows['event_organizer'];
		$Date = $rows['Date'];
		$day = $rows['day'];
		$month = $rows['month'];
		$monthName = date('F', mktime(0, 0, 0, $month, 10));
		$year = $rows['year'];
		$time1 = $rows['Time'];
		$Time  = date("g:i a", strtotime("$time1"));
		
?>

<html>

<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="/maps/documentation/javascript/demos/demos.css">
 <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>  

 <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<style>
input[type=text], input[type=date] {
    width: 100%;
    padding: 8px 15px;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
.container {
	width: 60%;
    padding: 16px;
    min-height: 50px;
    box-shadow: 10px 10px 5px black;
     -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}
table, td, th {    
    border: 1px solid #ddd;
    text-align: left;
}
th, td {
    padding: 15px;
}
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 20%;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}
.button2 {background-color: #008CBA; width: 10%;}

#locationField, #controls {
        position: relative;
        width: 480px;
      }
      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 99%;
      }
      .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
        color: #303030;
      }
      #address {
        border: 1px solid #000090;
        background-color: #f0f0ff;
        width: 480px;
        padding-right: 2px;
      }
      #address td {
        font-size: 10pt;
      }
      .field {
        width: 99%;
      }
      .slimField {
        width: 80px;
      }
      .wideField {
        width: 200px;
      }
      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
      
      
</style>
<body>
<p><form action="edit_info.php"><button style="float: left;" class="button button2">Go Back</button></form></p>
<div class="container" align="center">
<form method='post'>

<table>
  <tr>
    <th width="10%">Details</th><br>
    <th width="30%"></th>
  </tr>
  <tr>
    <td>Event Name:</td>
    <td><input name="ename" type="text" value="<?php echo $event_name;?>"></td>
  </tr>
  <tr>
    <td>Event Location:</td>
    <td><div id="locationField">
      <input name="location" id="autocomplete" value="<?php echo $event_location;?>" placeholder="Enter your address"
             onFocus="geolocate()" type="text"></input>
    </div>
    </td>
  </tr> 
<tr>
    <td>Event Organizer:</td>
    <td><?php echo $event_organizer;?></td>
</tr>
<tr>
    <td>Date:</td>
    <td><input type="date" id="birthday" name="birthday" size="20" value="<?php echo $Date;?>"></td>
</tr>
<tr>
    <td>Time:</td>
    <td><input type="time" name="time" size="20" value="<?php echo $time1;?>"></td>
</tr>
<tr>
    <td>Event Description:</td>
    <td><?php echo "<textarea type='text' name='description' class='form-control' style='height:100px;font-size:14pt;'>$event_description</textarea>"; ?></td>
</tr>
</table>
    
<br>
<button type="submit" name="submit" value="<?php echo $group; ?>" style="float: right;">Save Changes</button>
  </form>
  </div>
  
<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyjtLCEMqXuGvCN628GzATPejCDGGRUhQ&libraries=places&callback=initAutocomplete"
        async defer></script> 
        
        <script type="text/javascript">
    var datefield=document.createElement("input")
    datefield.setAttribute("type", "date")
    if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n') 
    }
</script>

        <script>
if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
    jQuery(function($){ //on document.ready
        $('#birthday').datepicker();
    })
}
</script>

</body>
</html>
<?php } ?>