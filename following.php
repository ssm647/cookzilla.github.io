<?php 
$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

session_start();  
$username = $_SESSION['username'];

if(isset($_POST['follow']))
{
$name = $_POST['follow'];

$sql = "INSERT INTO following VALUES ('$name','$username')";

if(mysqli_query($mysqli, $sql)){
    header('Location: infor.php');
	} else
	{
   	echo "ERROR: Could not able to execute";
	}
}

if(isset($_POST['unfollow']))
{
$uname = $_POST['unfollow'];

$sql8 = "DELETE FROM following WHERE username='$uname' AND following_name='$username'";

if(mysqli_query($mysqli, $sql8)) {
    header('Location: infor.php');
} else {
    echo "Error deleting record: ";
}
}


?>