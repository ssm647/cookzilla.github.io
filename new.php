<html lang="en">
<title>Home page</title>

<button onclick="goBack()">Go Back</button>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

<h2>Events & Info</h2>

<?php

session_start();
$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

session_start();  

$event_organizer = $_SESSION['username'];

if(isset($_POST['submit1']))
{
$eid = $_POST['submit1'];
$sql1 = "INSERT INTO rsvp (username, event_id) VALUES ('$event_organizer', $eid)"; 

if(mysqli_query($mysqli, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute";
}
}

?>

<div id="foo" class="panel" class="scrollit">
<div class="scrollit">
<div data-role="main" class="ui-content">
    <form>
      <input id="filterTable-input" data-type="search" placeholder="Search For Customers...">
    </form>
 <table data-role="table" data-mode="columntoggle" class="ui-responsive ui-shadow" id="myTable" data-filter="true" data-input="#filterTable-input">
  <thread>
  <tr>
    <th data-priority="1">Event Name</th>
    <th data-priority="2">Location</th>
    <th data-priority="3">Date</th>
    <th data-priority="4">Time</th>
    <th data-priority="5">Details</th>
    <th>Enroll</th>
  </tr>
  </thread>
<?php
$new_events = $mysqli->query("SELECT event_id, event_name, event_location, date, time FROM events;");

while($rows = $new_events->fetch_assoc())
{
?> 
<tr>
    <td><?= $rows['event_name'] ?></td>
     <td><?= $rows['event_location'] ?></td>
     <td><?= $rows['date'] ?></td>
     <td><?= $rows['time'] ?></td>
     <td>Click here for more details</td>
    <td>
    <form method="post" action="about">
    <button type="submit1" name="submit1" value="<?php echo $rows['event_id']; ?>" >RSVP</button></form></td>  
</tr>
 
<?php
} 
?>
</table>
</div>
</div>
</div>

<style>

input[type=text], input[type=password], input[type=date] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}

</style>
<body>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

<script>
function goBack() {
    window.history.back();
}
</script>

</body>
</html>