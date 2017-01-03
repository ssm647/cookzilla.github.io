<?php 

if(isset($_POST['cancelc']))
{
$cancelc = $_POST['cancelc'];

$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

$sql = "DELETE FROM reviewers WHERE r_id=$cancelc";

if(mysqli_query($mysqli, $sql)){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    echo "Error deleting record: ";
}
}
?>