<?php 

$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

session_start();  

$username = $_SESSION['username'];

if(isset($_POST['part']))
{
$_SESSION['pro'] = $_POST['part'];
}
$part = $_SESSION['pro'];

?>

<!DOCTYPE html>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


<head>
<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
img {
    border-radius: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    box-shadow:0px 0px 5px 2px rgba(0,0,0,0.5);
}
</style>
</head>
<body>

<h3>Cookzilla users participating in this event:</h3>

<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">

<table id="myTable">
  <tr class="header">
  </tr>

<?php 
$resultSet1 = $mysqli->query("SELECT rsvp.username, first_name, last_name, path FROM registration, rsvp WHERE rsvp.username=registration.username AND event_id='$part'");

		while($rows = $resultSet1->fetch_assoc())
		{
		$fname = $rows['username']; 
		$pname = $rows['first_name'];
		$lname = $rows['last_name'];
		$image = $rows['path'];
		$pic = basename($image,".php");
		?>
	<tr>
	 	<td width="90%"><?php echo "<img src='$pic' style='vertical-align:middle' class='img-circle' height='55' width='55' alt='Avatar'>";?>&nbsp;&nbsp;<span style=""><?php echo "$pname"." "."$lname";?></span></td>
	 	<td><form action='infor.php' method='post'><button type="profile" name="profile" value="<?php echo $fname;?>" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-user"></span> View Profile 
        </button>
        
        </form></td>
        
	</tr>
	<?php } ?>
</table>

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

</body>
</html>

