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

if(isset($_POST['group']))
{
  $_SESSION['rid'] = $_POST['group'];
}
$group = $_SESSION['rid'];

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

$resultSet1 = $mysqli->query("SELECT event_id, event_name, event_location, event_description, event_organizer, EXTRACT(year FROM Date) as year, EXTRACT(month FROM Date) as month, EXTRACT(day FROM Date) as day, Time FROM events WHERE event_id='$group'");

		while($rows = $resultSet1->fetch_assoc())
		{
		$event_name = $rows['event_name'];
		$event_location = $rows['event_location'];
		$event_description = $rows['event_description'];
		$event_organizer = $rows['event_organizer'];
		$day = $rows['day'];
		$month = $rows['month'];
		$monthName = date('F', mktime(0, 0, 0, $month, 10));
		$year = $rows['year'];
		$time1 = $rows['Time'];
		$Time  = date("g:i a", strtotime("$time1"));
		$resultSet2 = $mysqli->query("SELECT COUNT(event_id) as count FROM rsvp WHERE event_id=$group");

		while($rows = $resultSet2->fetch_assoc())
		{
		$enroll = $rows['count'];
?>

<html>

<head>
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
.button2 {background-color: #008CBA; width: 10%;}
</style>
<body>
<p><form action="events.php"><button style="float: left;" class="button button2">Go Back</button></form></p>
<div class="container" align="center">
<form method='post'>

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
    <td>Time:</td>
    <td><?php echo "$time1"; ?></td>
</tr>
<tr>
    <td>Event Description:</td>
    <td><?php echo "$event_description"; ?></td>
</tr>
<tr>
    <td>Total people enrolled:</td>
    <td><?php echo "$enroll"; ?></td>
</tr>
</table>
<br>
<button type="submit" name="submit" value="<?php echo $group; ?>" style="float: right;">RSVP</button>
  </form>
  </div>
</body>
</html>
<?php } } ?>