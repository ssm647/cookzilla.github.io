<html>

<head>
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
.button4 {
	border-radius: 12px;
	background-color: #2d5399;
    border: none;
    color: white;
    width: 70%;
    
    display: inline-block;
	}
.button2 {background-color: #008CBA; width: 10%;}

</style>
<body>
<form action="events.php"><button style="float: left;" class="button button2">Go Back</button></form>
<form action="edit_info1.php"><button style="float: right;" class="button button2">Edit Info</button></form>
<div class="container" align="center">


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
$eid = $_POST['submit'];
$sql = "INSERT INTO rsvp (username, event_id) VALUES ('$username', '$eid')"; 

if(mysqli_query($mysqli, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute";
}
}

$resultSet1 = $mysqli->query("SELECT event_id, event_name, event_location, event_description, event_organizer, Date, EXTRACT(year FROM Date) as year, EXTRACT(month FROM Date) as month, EXTRACT(day FROM Date) as day, Time FROM events WHERE event_id='$info'");

		while($rows = $resultSet1->fetch_assoc())
		{
		$eventid = $rows['event_id'];
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
		$resultSet2 = $mysqli->query("SELECT COUNT(event_id) as count FROM rsvp WHERE event_id=$info");

		while($rows = $resultSet2->fetch_assoc())
		{
		$enroll = $rows['count'];
		
?>



<table>
  <tr>
    <th width="30%">Details</th><br>
    <th width="30%"></th>
  </tr>
  <tr>
    <td>Event Name:</td>
    <td><?php echo "$event_name"; ?></td>
  </tr>
  <tr>
    <td>Event Location:</td>
    <td><?php echo "$event_location"; ?></td>
  </tr> 
<tr>
    <td>Event Organizer:</td>
    <td><?php echo "$event_organizer"; ?></td>
</tr>
<tr>
    <td>Date:</td>
    <td><?php echo "$day".", "."$monthName"." "."$year"; ?></td>
</tr>
<tr>
    <td>time:</td>
    <td><?php echo "$time1"; ?></td>
</tr>
<tr>
    <td>Event Description:</td>
    <td><?php echo "$event_description"; ?></td>
</tr>
<tr>
    <td>Total People Enrolled:</td>
    <td><?php echo "$enroll"; ?></td>
</tr>
<tr>
<td>List of people enrolled:</td>
<td><form action='user_part.php' method='post'><button type="part" name="part" value="<?php echo $eventid;?>" class="button4">View Group Members</button></form></td>
</tr>
</table>
<br>

  </div>

</body>
</html>
<?php } }?>