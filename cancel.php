<?php 

if(isset($_POST['cancel']))
{
$cancel = $_POST['cancel'];

$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

$sql8 = "DELETE FROM recipe WHERE recipe_id=$cancel";

if(mysqli_query($mysqli, $sql8)) {
    header('Location: my_wall.php');
} else {
    echo "Error deleting record: ";
}

$sql9 = "DELETE FROM steps WHERE recipe_id=$cancel";

if(mysqli_query($mysqli, $sql9)) {
    header('Location: my_wall.php');
} else {
    echo "Error deleting record: ";
}

$sql10 = "DELETE FROM ingredients WHERE recipe_id=$cancel";

if(mysqli_query($mysqli, $sql10)) {
    header('Location: my_wall.php');
} else {
    echo "Error deleting record: ";
}

}
?>