<html lang="en">
<title>Home page</title>
	
<meta charset="utf-8">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
   
      <a class="navbar-brand" href="sharp.php">Cookzilla</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="new_wall.php">Home</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="user_profile.php">Profile</a></li>
        <li><a href="about.php">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<h2>Events & Info</h2>

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

if(!$_SESSION['username'])
{
header('Location: login.php');
}

$event_organizer = $_SESSION['username'];

/* Event Creator RSVP himself */
$result6 = $mysqli->query("SELECT event_id, event_organizer FROM events");

while($rows = $result6->fetch_assoc())
{ 
$name = $rows['event_organizer'];
$id = $rows['event_id'];

$sql2 = "INSERT INTO rsvp (username, event_id) VALUES ('$name', '$id')"; 

if(mysqli_query($mysqli, $sql2)){
    echo "<script>alert('Successful');</script>"; 
} 
}

/* not allowed to rsvp more than 10 events */

$result61 = $mysqli->query("SELECT count(event_id) as count_id FROM rsvp WHERE username='$event_organizer'");

while($rows = $result61->fetch_assoc())
{ 
$count_id = $rows['count_id'];
}

/* Delete Expire events */

$result6 = $mysqli->query("SELECT event_id FROM events WHERE Date<CURDATE()");

while($rows = $result6->fetch_assoc())
{ 
$print = $rows['event_id'];

$sql6 = "DELETE FROM events WHERE event_id=$print";

if(mysqli_query($mysqli, $sql6)) {
    //echo "Record deleted successfully";
} else {
    echo "Error deleting record";
}
echo '<script type="text/javascript">location.reload();</script>';
}

if(isset($_POST['submit']))
 {
 $event_name = $mysqli->real_escape_string($_POST['ename']);
 $event_location = $mysqli->real_escape_string($_POST['location']);
 $event_description = $mysqli->real_escape_string($_POST['description']);
 $your_date = $mysqli->real_escape_string($_POST['birthday']);
 $event_date = date("Y-m-d", strtotime($your_date));
 $event_time = $mysqli->real_escape_string($_POST['time']);
 
if($count_id<10)
{
 $sql = "INSERT INTO events VALUES ('$event_id','$event_name','$event_location','$event_description', '$event_organizer', '$event_date', '$event_time')";

	if(mysqli_query($mysqli, $sql)){
    echo "<script>alert('Successfull');</script>";
	} else
	{
   	echo "<script>alert('Unsuccessfull');</script>";
	}
	echo '<script type="text/javascript">location.reload();</script>';
}
/* Event Creator's auto RSVP */
}

$new_events = $mysqli->query("SELECT event_id, event_name, event_location, date, time FROM events;");
$your_events = $mysqli->query("SELECT event_name, event_id, date, time FROM events WHERE event_organizer='$event_organizer';");

if(isset($_POST['submit3']))
{

$sql8 = "DELETE FROM rsvp WHERE event_id={$_POST['submit3']}";

if(mysqli_query($mysqli, $sql8)) {
    echo "<script>alert('Successfull');</script>";
} else {
    echo "<script>alert('Unsuccessfull');</script>";
}
echo '<script type="text/javascript">location.reload();</script>';
}
/*your events*/

if(isset($_POST['submit1']))
{
if($count_id<5)
{
$eid = $_POST['submit1'];
$sql = "INSERT INTO rsvp (username, event_id) VALUES ('$event_organizer', '$eid')"; 

if(mysqli_query($mysqli, $sql)){
    echo "<script>alert('Successfull');</script>";
} else{
    echo "<script>alert('Unsuccessfull, you cannot exceed more then 4 events and you cannot RSVP the same event twice');</script>";
}
}
else
{
echo "Can RSVP for more events";
}
}
$enroll_events = $mysqli->query("SELECT event_organizer, event_name, event_location, rsvp.event_id, date, time FROM events, rsvp, registration WHERE events.event_id=rsvp.event_id AND registration.username=rsvp.username AND rsvp.username='$event_organizer';");
?>

<button class="accordion">Events enrolled</button>
<div id="foo" class="panel">
 <table>
  <tr>
    <th>Event Name</th>
    <th>Location</th>
    <th>Date</th>
    <th>Time</th>
    <th>Details & Updates</th>
    <th>Delete</th>
  </tr>
<?php
while($rows = $enroll_events ->fetch_assoc())
{
?> 
<tr>
    <td><?= $rows['event_name'] ?></td>
     <td><?= $rows['event_location'] ?></td>
     <td><?= $rows['date'] ?></td>
     <td><?= $rows['time'] ?></td>
     <form method="post" action="detail.php">
     <td><button type="group" name="group" class="button1" value="<?php echo $rows['event_id']; ?>">Click Here</button></td>
     </form>
     <form method="post">
     <?php if($rows['event_organizer']!==$event_organizer) { ?>
     <td><button type="submit3" name="submit3" value="<?php echo $rows['event_id'];?>" class="cancelbtn">Undo Enrollment</button>
     <?php } ?>
     </form>
    </td>
  </tr>
 
<?php
}
?>
</table>
</div>


<? 

/* Delete's if */ 

if(isset($_POST['submit2']))
{
$sql4 = "DELETE FROM events WHERE event_id={$_POST['submit2']}";

if(mysqli_query($mysqli, $sql4)) {
    echo "<script>alert('successfull');</script>";
} else {
    echo "<script>alert('Unsuccessfull');</script>";
}
echo '<script type="text/javascript">location.reload();</script>';
}

?>
<button class="accordion">Check out new events</button>
<div id="foo" class="panel" class="scrollit">
<form action="new.php">
    <button class="w3-btn w3-white w3-border w3-border-blue w3-round-xlarge" >Filter</button>
</form>
<div class="scrollit">
 <table>
  <tr>
    <th>Event Name</th>
    <th>Location</th>
    <th>Date</th>
    <th>Time</th>
    <th>Details</th>
    <th>Enroll</th>
  </tr>
<?php
while($rows = $new_events->fetch_assoc())
{
?> 
<tr>
    <td><?= $rows['event_name'] ?></td>
     <td><?= $rows['event_location'] ?></td>
     <td><?= $rows['date'] ?></td>
     <td><?= $rows['time'] ?></td>
     <td><form action='group.php' method='post'><button type="group" name="group" class="button1" value="<?php echo $rows['event_id']; ?>">More details</button></form></td>
    <td>
    <form method="post">
    <button type="submit1" name="submit1" value="<?php echo $rows['event_id']; ?>" >RSVP</button></form></td>  
</tr>
<?php
} 
?>
</table>

</div>
</div>
<button class="accordion">Your events</button>
<div id="foo" class="panel">
 <table>
  <tr>
    <th>Event Name</th>
    <th>Date</th>
    <th>Time</th>
    <th>Edit info</th>
    <th>Delete</th>
  </tr>
<?php
while($rows = $your_events->fetch_assoc())
{
?> 
<tr>
    <td><?= $rows['event_name'] ?></td>
    <td><?= $rows['date'] ?></td>
    <td><?= $rows['time'] ?></td>
    <td><form action="edit_info.php" method="post"><button type="info" name="info" class="button1" value="<?php echo $rows['event_id']; ?>">Click Here</button></form></td>
    <td> 
    <form method="post">
    <button type="submit2" name="submit2" value="<?php echo $rows['event_id']; ?>" class="cancelbtn">Delete Event</button>
    </form>
    </td>
  </tr>
 
<?php
}
?>
 </table>
</div>

<style>
/* Full-width input fields */
input[type=text], input[type=password], input[type=date] {
    width: 82%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 82%;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}

/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)}
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)}
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}


/* MAPS */

      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
      
        height: 50%;
        width: 50%
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height:100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
      
/* TO EXPAND */

button.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

button.accordion.active, button.accordion:hover {
    background-color: #ddd;
}

button.accordion:after {
    content: '\02795';
    font-size: 13px;
    color: #777;
    float: right;
    margin-left: 5px;
}

button.accordion.active:after {
    content: "\2796";
}

div.panel {
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: 0.6s ease-in-out;
    opacity: 0;
}

div.panel.show {
    opacity: 1;
    max-height: 500px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

/* For tables */

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}

/* menu */

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111;
}

/* bootstap */
footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }

.scrollit {
    overflow:scroll;
    height:500px;
}

.w3-btn {
	margin-bottom:10px;
	width:10%;
	}

.button1 {padding: 4px 24px; background-color: #008CBA;}

</style>
<body>

<!--<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Create Event</button>-->

<div id="id01" class="modal">

  
    
  <form method="post" class="modal-content animate">

      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>

    <div class="container">
      <label><b>Event Name</b></label><br>
      <input type="text" placeholder="Enter Name" name="ename" required>
	</br>
      <label><b>Event Location</b></label><br>
        
    <input id="pac-input" class="controls" type="text" name="location" placeholder="Search Box" required>
    <div id="map"></div>
    </br>
    
    <label><b>Date</b></label><br>
  	  <input type="date" id="birthday" name="birthday" size="20" required>
      <!--<input type="text" placeholder="YYYY-MM-DD" name="date" required>-->
	</br>
	
	<label><b>Time</b></label><br>
  
      <input type="text" placeholder="Please specify the date range (for e.g. 11 am to 1 pm)" name="time" required><br>
	
      <label><b>Event Description</b></label><br>
      <input type="text" placeholder="Enter Description" name="description" required>
      
      <button type="submit" name="submit">Create Event</button>
    </div>
  </form>
</div>

<button class="accordion">Create Events</button>
<div class="panel">
<p>
<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Create Event</button>
</p>
</div>


<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


<!--MAPS-->

<script>
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyjtLCEMqXuGvCN628GzATPejCDGGRUhQ&libraries=places&callback=initAutocomplete"
         async defer></script>
         <script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function(){
        this.classList.toggle("active");
        this.nextElementSibling.classList.toggle("show");
  }
}
</script>

<script>
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>

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

<script type="text/javascript">
$(document).ready(function() {
    $('#upload').bind("click",function() 
    { 
        var imgVal = $('#uploadfile').val(); 
        if(imgVal=='') 
        { 
            alert("empty input file"); 
            return false; 
        } 


    }); 
});
</script> 
<script type="text/javascript">
  $(function() {
    $('#datetimepicker3').datetimepicker({
      pickDate: false
    });
  });
</script>


</body>
</html>