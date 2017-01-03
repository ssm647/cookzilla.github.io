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

if(isset($_POST['modal']))
{
  $_SESSION['rid'] = $_POST['modal'];
}
$pass = $_SESSION['rid'];

function hoursToMinutes($hours)
{

	$totalMinutes = $hours * 60;
	return $totalMinutes;
}

function minutesToHours($minutes)
{
	$hours          = floor($minutes / 60);
	$decimalMinutes = $minutes - floor($minutes/60) * 60;

	# Put it together.
	$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
	return $hoursMinutes;
}


if(isset($_POST['submit']))
{

$title = $_POST['title'];
$description = $_POST['description'];
$image = $_POST['recipe_image'];
$servings = $_POST['servings'];

$hour = $_POST['hour'];
$htom = hoursToMinutes("$hour");

$minute = $_POST['minute'];
$inm = $minute+$htom;

//Upload recipe images

$target_dir = "/Applications/MAMP/htdocs/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


if($target_dir!==$target_file)
{
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
//}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$sql = "UPDATE recipe SET recipe_title='$title', description='$description' WHERE recipe_id='$pass'";

if(mysqli_query($mysqli, $sql)){
    echo "Records added successfully";
} else{
    echo "ERROR: Could not able to execute";
} 

}
// exit here
else
{
$sql = "UPDATE recipe SET recipe_title='$title', description='$description' WHERE recipe_id='$pass'";

if(mysqli_query($mysqli, $sql)){
    echo "Records added successfully";
} else{
    echo "ERROR: Could not able to execute";
} 
}
}

$resultSet1 = $mysqli->query("SELECT recipe_title, description, no_of_servings, recipe_time, recipe_image FROM recipe WHERE recipe_id='$pass'");

		while($rows = $resultSet1->fetch_assoc())
		{
		$aid2 = $rows['recipe_title'];
		$aid3 = $rows['description'];
		$aid4 = $rows['no_of_servings'];
		$aid5 = $rows['recipe_time'];
		$aid6 = $rows['recipe_image'];
		$hours = floor($aid5 / 60);
		$minutes = $aid5 % 60;
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

</style>
<body>


<form name='foo' method='post' action='my_wall.php'>
<div class="container">
<p><?php echo "<input type='text' name='title' class='form-control' value='$aid2'>";?></p>

<p><?php echo "<textarea type='text' name='description' class='form-control' style='height:100px;font-size:14pt;'>$aid3</textarea>"; ?></p>
				
              <p><b>Number of servings:</b> 
              <select type='servings' name='servings'>
              <option selected="selected"><?php echo $aid4; ?></option>
  			  <option value="1">1</option>
  			  <option value="2">2</option>
  			  <option value="3">3</option>
  			  <option value="4">4</option>
  			  <option value="5">5</option>
  			  <option value="6">6</option>
  			  <option value="7">7</option>
  			  <option value="8">8</option>
  			  <option value="9">9</option>
  			  <option value="10">10</option>
  			  <option value="11">11</option>
  			  <option value="12">12</option>
  			  <option value="13">13</option>
  			  <option value="14">14</option>
  			  <option value="15">15</option>
  			  <option value="16">16</option>
  			  <option value="17">17</option>
  			  <option value="18">18</option>
  			  <option value="19">19</option>
  			  <option value="20">20</option>
			  </select>
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <b>Total time:</b>&nbsp;
			  <select type='hour' name='hour'>
			  <option selected="selected"><?php echo $hours; ?></option>
  			  <option value="0">0</option>
  			  <option value="1">1</option>
  			  <option value="2">2</option>
  			  <option value="3">3</option>
  			  <option value="4">4</option>
  			  <option value="5">5</option>
  			  <option value="6">6</option>
  			  <option value="7">7</option>
  			  <option value="8">8</option>
			  </select>&nbsp;<i>Hour</i>
			  &nbsp;
              <select type='minute' name='minute'>
              <option selected="selected"><?php echo $minutes; ?></option>
  			  <option value="5">0</option>
  			  <option value="5">5</option>
  			  <option value="10">10</option>
  			  <option value="15">15</option>
  			  <option value="20">20</option>
  			  <option value="25">25</option>
  			  <option value="30">30</option>
  			  <option value="35">35</option>
  			  <option value="40">40</option>
  			  <option value="45">45</option>
  			  <option value="50">50</option>
  			  <option value="55">55</option>
			  </select>&nbsp;<i>Minute</i></p>	  
			  
              <p><input type="file" name="fileToUpload" value="<?php echo $aid6;?>" id="fileToUpload"></p>      
              
              <input class="form-control" rows="5" id="autocomplete-textarea" placeholder="What tags belongs to your dish ?">
 
                  <div class="btn-group">
                  <div class="pull-right">
                    <br><button type="submit" name="submit" class="btn btn-success">Save Changes</button>
                  </div>
                  </div>  
                </div>
                </form>
            </div>

</div>
  </form>
  <script>document.foo.submit();</script>
</body>
</html>
<?php } ?>