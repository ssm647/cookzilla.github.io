<?php
$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

session_start();  

$count=0;

if(!$_SESSION['username'])
{
header('Location: login.php');
}

$username = $_SESSION['username'];
    
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

if(!isset($title) || trim($title) == '' || !isset($description) || trim($description) == '')
{
	echo "<script>alert('Make sure following field are filled');</script>"; 
}
else
{
$resultSet5 = $mysqli->query("SELECT max(recipe_id) as max FROM recipe");

while($rows = $resultSet5->fetch_assoc())
{
	$recipeid = $rows['max'];
	$add= $recipeid+1;
}

//steps
		$itemCount = count($_POST["r_steps"]);
		$itemValues=0;
		$query = "INSERT INTO steps (recipe_id, ";
		$queryValue1 = "";
		$queryValue2 = ") VALUES ($add,";
		for($i=0;$i<$itemCount;$i++) {
			if(!empty($_POST["r_steps"][$i])){
				$itemValues++;
				if($queryValue!="") {
					$queryValue .= ",";
				}
				if($queryValue1!="") {
					$queryValue1 .= ",";
				}
				$tmp = $i + 1;
				$queryValue1 .= "step".$tmp;
				$queryValue .= " '";
				$queryValue .= $_POST['r_steps'][$i];
				$queryValue .= "'";
			}
		}
		
		$sql = $query.$queryValue1.$queryValue2.$queryValue;
		$sql .= ")";
		
		if (mysqli_query($mysqli, $sql)) {
    //echo "New record created successfully";
	} else {
    //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

///////////

//Ingre

		$itemCount1 = count($_POST["ing"]);
		$itemV=0;
		$q = "INSERT INTO ingredients (recipe_id,";
		$queryV1 = "";
		$queryV2 = ") VALUES ($add,";
		for($i=0;$i<$itemCount1;$i++) {
			if(!empty($_POST["ing"][$i])){
				$itemV++;
				if($queryV!="") {
					$queryV .= ",";
				}
				if($queryV1!="") {
					$queryV1 .= ",";
				}
				$tmp1 = $i + 1;
				$queryV1 .= "ing".$tmp1;
				$queryV .= " '";
				$fullquan = $_POST['ing'][$i]. " " . $_POST['quan'][$i] . " " . $_POST['units'][$i];
				$queryV .= $fullquan;
				$queryV .= "'";
			}
		}
		
		$sql1 = $q.$queryV1.$queryV2.$queryV;
		$sql1 .= ")";
		
		//echo $sql1;
		
		if (mysqli_query($mysqli, $sql1)) {
   //echo "New record created successfully";
	} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
}

//////////

$tagName=$_POST['tags'];

$tagarray = explode("#", $tagName);
	
	for($i = 1; $i<(sizeof($tagarray)); $i++) {


  $sql = "INSERT INTO tags VALUES ('$add','$tagarray[$i]')";

 if(mysqli_query($mysqli, $sql)) {
    //echo "New record created successfully";
	} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

//Done inserting

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
        //echo "File is an image - " . $check["mime"] . ".";
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
      //  echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}



$sql = "INSERT INTO recipe (recipe_username, recipe_title, description, recipe_image, recipe_time, no_of_servings) VALUES ('$username','$title','$description', '$target_file', '$inm', '$servings')";

if(mysqli_query($mysqli, $sql)){
    //echo "Records added successfully";
} else{
    echo "ERROR: Could not able to execute";
} 

}
// exit here
else
{

$sql = "INSERT INTO recipe (recipe_username, recipe_title, description, recipe_time, no_of_servings) VALUES ('$username','$title','$description', '$inm', '$servings')";

if(mysqli_query($mysqli, $sql)){
    //echo "Records added successfully";
} else{
    echo "ERROR: Could not able to execute";
} 
}
}
}
//Hello

//spam
if(isset($_POST['spam']))
{
$rid = $_POST['spam'];

$sql = "Insert into spam (recipe_id, username) values ($rid, '$username')";

if(mysqli_query($mysqli, $sql)){
echo "Perfect";
}
else
{
echo "Can't spam twice";
}
$sql8 = "delete from recipe where recipe.recipe_id in(select t1.recipe_id from (SELECT * FROM spam) as t1 GROUP by t1.recipe_id HAVING count(t1.recipe_id) >=2)";

if(mysqli_query($mysqli, $sql8)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: ";
}

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home Page</title>
  
	<link rel="stylesheet" type="text/css" href="image.css">
  <meta charset="utf-8">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
    /* Status Box*/
    .panel {
    -webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	border-radius: 0px;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	margin-bottom: 30px;
	margin-top:10px;
	}

	.panel.panel-default {
	border: 1px solid #d4d4d4;
	-webkit-box-shadow: 0 2px 1px -1px rgba(0, 0, 0, 0.1);
	-moz-box-shadow: 0 2px 1px -1px rgba(0, 0, 0, 0.1);
	box-shadow: 0 2px 1px -1px rgba(0, 0, 0, 0.1);
	}

	.btn-icon {
	color: #484848;
	}
	.container {
    /* remember to set a width */
    margin-right: auto;
    margin-left: auto;
}
img {
    border-radius: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    box-shadow:0px 0px 5px 2px rgba(0,0,0,0.5);
}
.SearchBar {
     position: absolute;
     top: 355px;
     left: 575px;
}

.SearchBar input {
     height: 30px;
     width: 50px;
}

.button4 {
	border-radius: 12px;
	background-color: #2d5399;
    border: none;
    color: white;
    text-align: center;
    display: inline-block;
	}
/*Star Comment*/

body { font-size: 18px; }

.stars-container {
  position: relative;
  display: inline-block;
  color: transparent;
}

.stars-container:before {
  position: absolute;
  top: 0;
  left: 0;
  content: '★★★★★';
  color: lightgray;
}

.stars-container:after {
  position: absolute;
  top: 0;
  left: 0;
  content: '★★★★★';
  color: gold;
  overflow: hidden;
}

.stars-0:after { width: 0%; }
.stars-10:after { width: 10%; }
.stars-20:after { width: 20%; }
.stars-30:after { width: 30%; }
.stars-40:after { width: 40%; }
.stars-50:after { width: 50%; }
.stars-60:after { width: 60%; }
.stars-70:after { width: 70%; }
.stars-80:after { width: 80%; }
.stars-90:after { width: 90%; }
.stars-100:after { width: 100; }

body {
    background-color: white;
}
.button2 {background-color: #008CBA; border-radius: 12px; width:100%}
.button2:hover {
    background-color: #3e8e41;
}
input[type=text11] {
    width: 130px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('searchicon.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text11]:focus {
    width: 100%;
}
  </style>
</head>
<body>


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="new_wall.php">Cookzilla</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav" width="80%">
        <li class="active"><a href="new_wall.php">Home</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="user_profile.php">Profile</a></li>
        <li><a href="about.php">Contact</a></li>
          
      </ul>
      <ul class="nav navbar-nav navbar-center">  
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li>
      <form method="post" action="search_all.php" class="navbar-form" role="search">
      
            <button type="submit" class="btn btn-default">
      <span class="glyphicon glyphicon-search"></span> Search
    </button>
          
        </form></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

  
<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-sm-2 sidenav">
    
    
    	<?php 
		$resultSet1 = $mysqli->query("SELECT first_name, last_name, path FROM registration WHERE username='$username'");

		while($rows = $resultSet1->fetch_assoc())
		{
		$aid4 = $rows['first_name'];
		$aid5 = $rows['last_name'];
		$yes=$rows['path'];
		$no = basename($yes,".php");
		echo "<img src='$no' class='img-circle' height='90' width='90' alt='Avatar'>";
      	} 
      ?>
      </br>
      <p><h4><?php echo "$aid4"." "."$aid5";?></h4></p>
      <ul class="nav nav-pills nav-stacked">
        <li><a href="new_wall.php">Home</a></li>
        <li><a href="my_wall.php">My Wall</a></li>
      </ul><br>
      <button onclick="location.href = 'all_users.php';" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-user"></span> Search Users
          <span class="glyphicon glyphicon-search"></span> 
        </button><br><br>
       
    </div>
    <div class="col-sm-7 text-left">

<div class="container">

	<div class="row">
    
		<div class="col-md-7"><br>
		<button type="button" class="button2" data-toggle="collapse" data-target="#demo"><span class="glyphicon glyphicon-pencil"></span>Write your own recipe</button>
 			 <div id="demo" class="collapse">

      		<div class="panel panel-default">
      	
              <form method='post' enctype="multipart/form-data">
              
              <div class="panel-body">
              <p><input type="text" name="title" class="form-control" placeholder="What's your recipe title ?"></p>
    			
              <p><textarea type="text" name="description" class="form-control" placeholder="Can you please describe it ?" style="height:100px;font-size:14pt;"></textarea></p>
            
              <p><b>Number of servings:</b>
              <select type='servings' name='servings'>
              <option selected="selected">1</option>
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
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <b>Total time:</b>&nbsp;
			  <select type='hour' name='hour'>
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
              <option selected="selected">5</option>
  			  <option value="0">0</option>
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
			  
			  <!--Recipe-->
			    
<DIV id="product">
<?php require_once("input.php") ?>
</DIV>
<div align="right">
<button type="button" name="add_item" value="Add More" onClick="addMore();" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-plus"></span>
        </button>
<button type="button" name="del_item" value="Delete" onClick="deleteRow();" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-remove"></span> 
        </button>
        <span class="success"><?php if(isset($message)) { echo $message; }?></span>
</div>

<hr>

<DIV id="product1">
<?php require_once("input1.php") ?>
</DIV>
<div align="right">
<button type="button" name="add_item" value="Add More" onClick="addMore1();" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-plus"></span>
        </button>
<button type="button" name="del_item" value="Delete" onClick="deleteRow1();" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-remove"></span> 
        </button>
<span class="success"><?php if(isset($message)) { echo $message; }?></span>
</div>



              <p><input type="file" name="fileToUpload" id="fileToUpload" ></p>      
              <small><i>Use # tag to add tags for e.g. #veg #nonveg #indian</i></small>
    		 <input type="tags" name="tags" id="tname" size="50" class="form-control" placeholder="What tags belongs to your dish ?">

              </div>
              
                <div class="panel-footer">
                  <div class="btn-group">
                  <div class="pull-right">
                    <button type="submit" name="submit" class="btn btn-success">Post</button>
                  </div>
                  </div>  
                </div>
                </form>
				</div>
            </div>
          </div>
	</div>
</div>

    <h4><small>RECENT POSTS</small></h4>
    <?php 
	
		$resultSet1 = $mysqli->query("SELECT first_name, last_name, recipe_image, recipe_id, path, EXTRACT(year FROM time) as year, EXTRACT(month FROM time) as month, EXTRACT(day FROM time) as day, time(time) AS time1, recipe_username, recipe_title, description, recipe_time, no_of_servings FROM recipe, registration, following WHERE registration.username=recipe.recipe_username AND following.username=recipe.recipe_username AND following.following_name='$username' ORDER BY time DESC");

		while($rows = $resultSet1->fetch_assoc())
		{
		$recipeid = $rows['recipe_id'];
		$recipe_username = $rows['recipe_username'];
		$first_name = $rows['first_name'];
		$last_name = $rows['last_name'];
		$aid2 = $rows['recipe_title'];
		$recipe_time = $rows['recipe_time'];
		$servings = $rows['no_of_servings'];
		$aid3 = $rows['description'];
		$day = $rows['day'];
		$month = $rows['month'];
		$monthName = date('F', mktime(0, 0, 0, $month, 10));
		$time = $rows['time1'];
		$time_12  = date("g:i a", strtotime("$time"));
		$year = $rows['year'];
		$yes=$rows['path'];
		$no = basename($yes,".php");
		$image=$rows['recipe_image'];
		$pic = basename($image,".php");
		?>
		<hr>
     <div class="w3-panel w3-card-2 w3-white">
       <table BORDER="0" width="100%">
		<tr>
		<td width="10%">
		<h3>
    <?php
			echo "<img src='$no' class='img-circle' height='55' width='55' alt='Avatar'>";
	  ?></h3></td>
	  <td width="80%"><h4><?php echo "$first_name"." "."$last_name";?></h4><small><form action='infor.php' method='post'><button type="profile" name="profile" value="<?php echo $rows['recipe_username'];?>" class="button4">View profile</button></form></small></td>
      <td><small><h5>Spam?</h5></small>
      
      <form method='post'><button type="spam" name="spam" value="<?php echo $recipeid;?>" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-alert"></span>
        </button></form>
        
        </h3></td>
        </tr>
	  	</table>
	  
	  <table BORDER="0" width="100%">
		<tr>
		<td width="30%"><h3><?php echo "$aid2";?></h3></TD>
		
        <?php 
        
        $resultS1 = $mysqli->query("SELECT sum(rating) as sum FROM reviewers WHERE r_recipe_id='$recipeid'");
		
		while($rows = $resultS1->fetch_assoc())
		{
        $rate12=$rows['sum'];
        } 
        
        $resultS2 = $mysqli->query("SELECT count(r_id) as count FROM reviewers WHERE r_recipe_id='$recipeid'");

		while($rows = $resultS2->fetch_assoc())
		{
        $count1=$rows['count'];
        } 
    	$avg = $rate12/$count1;
        $a_rating=round($avg);
        ?>
        <td><i>Avg rating:</i>
        <?php if($rate12==NULL) { ?><div><span class="stars-container stars-0">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==0) { ?><div><span class="stars-container stars-0">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==1) { ?><div><span class="stars-container stars-20">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==2) { ?><div><span class="stars-container stars-40">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==3) { ?><div><span class="stars-container stars-60">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==4) { ?><div><span class="stars-container stars-80">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==5) { ?><div><span class="stars-container stars-100">★★★★★</span></div> <?php } ?></td>
		</tr>
	  </table>
	  
      <h5><span class="glyphicon glyphicon-time"></span> Post by <?php echo $recipe_username; ?>, <?php echo "$time_12, "."$monthName"." "."$day, "."$year";?></h5>
<form method='post' action='tagsr.php'>
      <?php 
	
		$resultSet6 = $mysqli->query("SELECT tag_name FROM tags WHERE recipe_id='$recipeid'");

		while($rows = $resultSet6->fetch_assoc())
		{ 
		$wtags = $rows['tag_name'];
		?>
   
      	<small><button type='tags' class='btn btn-info btn-xs' name='tags' value='<?php echo $wtags;?>'>
		<?php echo $wtags;?></button></small>
		
      <?php }
      ?></form>
      <hr width="50%" align="left">
      <b><i><?php echo "Total time to make: "."$recipe_time"." "."Minutes";?></i></b></br>
      <?php if(!$servings==0) { ?>
      <b><i><?php echo "Number of servings:"." "."$servings";?></i></b>
      <?php }?>
      <hr width="50%" align="left"><p><?php echo "$aid3";?></p>
      <?php
      if($pic)
      { ?>
      <img id="myImg" src="<?php echo $pic;?>" alt="<?php echo $aid2 ?>" width="650" height="400">
      <?php } ?>

     <br>
  
     <!--<img id="myImg" src="sharp.png" alt="Trolltunga, Norway" width="300" height="200">-->
     <br>
      <form method='post' action='comment.php'>
      <button type="submit" name="submit" value="<?php echo $recipeid;?>" class="btn btn-primary">Get more info</button>
      </form><br>
      </div>
      <?php 
      }
      ?>
    </div>
    
    <div class="col-sm-3 sidenav">
     <ul class="nav navbar-nav navbar-center">
     	<li>Notifications:&nbsp;<button type="button" class="btn btn-default btn-sm" onclick="document.getElementById('id01').style.display='block'">
          <span class="glyphicon glyphicon-user"></span>
        </button></li>
      	<li><button type="button" class="btn btn-default btn-sm" onclick="document.getElementById('id02').style.display='block'">
          <span class="glyphicon glyphicon-info-sign"></span>
        </button></li>
        <li><button type="button" class="btn btn-default btn-sm" onclick="document.getElementById('id03').style.display='block'">
          <span class="glyphicon glyphicon-globe"></span>
        </button></li>
        <li><button type="button" class="btn btn-default btn-sm" onclick="document.getElementById('id04').style.display='block'">
          <span class="glyphicon glyphicon-map-marker"></span>
        </button></li>
      </ul>
      <br>
    <div class="w3-panel w3-card-2 w3-white">
    <div class="w3-panel w3-card-2 w3-white"><hr><h4><small>MOST FREQUENT TAGS:</small></h4>
    <p><?php 
$resultSet9 = $mysqli->query("select distinct(tags.tag_name) as tag_name from tags, recipe
where tags.recipe_id = recipe.recipe_id
and tags.recipe_id in (select recipe_id from recipe where recipe_username ='$username') ORDER BY RAND() LIMIT 8");

while($rows = $resultSet9->fetch_assoc())
{
$tag_name = $rows['tag_name']; 
?>
<small><form method='post' style='display: inline;' action='tagsr.php'><button type='tags' class='btn btn-info btn-xs' name='tags' value='<?php echo $tag_name;?>'>
		<?php echo $tag_name;?></button></form></small>
<?
}	
?>
    </p><hr>
    </div>
    <div class="w3-panel w3-card-2 w3-white">
        <h4><small>COOK SUGGESTIONS YOU MAY LIKE:</small></h4>
      <hr>
      
      <!-- Friend Sugg code-->
<?php 
$resultSet2 = $mysqli->query("SELECT distinct(f2.username) as uname from following f2 where f2.following_name in (select f1.username from following f1 where f1.following_name = '$username') and f2.username != '$username' and f2.username not in (select f1.username from following  f1 where f1.following_name = '$username') ORDER BY RAND()
LIMIT 3");

while($rows = $resultSet2->fetch_assoc())
{
$uname1 = $rows['uname']; 

	$resultSet3 = $mysqli->query("SELECT first_name, last_name, path FROM registration WHERE username='$uname1'");

	while($rows = $resultSet3->fetch_assoc())
	{
	$firstname = $rows['first_name'];
	$lastname = $rows['last_name'];
	$image1=$rows['path'];
	$pic1 = basename($image1,".php");
		
?>
<table>
<tr>
<td width=20%><?php
			echo "<img src='$pic1' class='img-circle' height='55' width='55' alt='Avatar'>";
	  ?></td>
<td><p><?php echo $firstname." ".$lastname; ?></p><p><small><form action='infor.php' method='post'><button type="profile" name="profile" value="<?php echo $uname1;?>" class="button4">View profile</button></form></small></p></td>
</tr>
</table>
        <hr>
      <?php }} ?>
      
      <a href="re_users.php">View all</a><br>
      </div>
      </div>
    </div>
  </div>
</div>



<div id="myModal" class="modal">
  <span class="close">×</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
   


 <div id="id01" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn">&times;</span>
        <p><h4>Notification</h4></p>
        <p>
<?php
$resultSe2 = $mysqli->query("SELECT following_name FROM following WHERE username='$username' AND following_name!='$username' LIMIT 5");

while($rows = $resultSe2->fetch_assoc())
{
echo "<hr>";
$fname = $rows['following_name'];?>
<form action='infor.php' method='post'>
<b>User <button type="profile" name="profile" value=<?php echo $fname;?> class="btn btn-default btn-xs"><?php echo $fname?></button> started following you.</b></form>
<?php
}
?><hr>
        </p>
      </div>
    </div>
  </div>
  
  <div id="id02" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id02').style.display='none'" class="w3-closebtn">&times;</span>

        <p><h4>Notifications:</h4></p>
        <p>
    
<?php
$resultSe3 = $mysqli->query("SELECT recipe_id, recipe_title, r_username FROM recipe, reviewers WHERE recipe.recipe_id=reviewers.r_recipe_id AND recipe_username='$username' AND r_username!='$username' ORDER BY c_time DESC LIMIT 4;");

while($rows = $resultSe3->fetch_assoc())
{
echo "<hr>";
$recipe_id = $rows['recipe_id'];
$recipe_title = $rows['recipe_title'];
$r_username = $rows['r_username'];

;?>

<b>User <form action='infor.php' method='post' style='display: inline;'><button type="profile" name="profile" value=<?php echo $r_username;?> class="btn btn-default btn-xs"><?php echo "$r_username";?></button></form> commented on your post titled <form action='comment.php' method='post' style='display: inline;'><button type="submit" name="submit" value=<?php echo $recipe_id;?> class="btn btn-default btn-xs"><?php echo "$recipe_title";?></button>.</b></form>
<?php 
}
?> <hr>
 <hr>
        </p>
      </div>
    </div>
  </div>
  
   <div id="id03" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id03').style.display='none'" class="w3-closebtn">&times;</span>

        <p><h4>Notifications:</h4></p>
        <p>
    
<?php
$resultSe4 = $mysqli->query("SELECT recipe_id, recipe_title, r_username FROM recipe, reviewers WHERE recipe.recipe_id=reviewers.r_recipe_id AND r_username!='$username' AND r_recipe_id IN (SELECT r_recipe_id FROM reviewers WHERE r_username='$username') ORDER BY c_time LIMIT 5;");

while($rows = $resultSe4->fetch_assoc())
{
echo "<hr>";
$recipe_id = $rows['recipe_id'];
$recipe_title = $rows['recipe_title'];
$r_username = $rows['r_username'];

;?>

<b>User <form action='infor.php' method='post' style='display: inline;'><button type="profile" name="profile" value=<?php echo $r_username;?> class="btn btn-default btn-xs"><?php echo "$r_username";?></button></form> commented on the post titled <form action='comment.php' method='post' style='display: inline;'><button type="submit" name="submit" value=<?php echo $recipe_id;?> class="btn btn-default btn-xs"><?php echo "$recipe_title";?></button> of your interest.</b></form>
<?php 
}
?> <hr>
        </p>
      </div>
    </div>
  </div>
  
     <div id="id04" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id04').style.display='none'" class="w3-closebtn">&times;</span>

        <p><h4>Notifications:</h4></p>
        <p>
    
<?php
$resultSe5 = $mysqli->query("SELECT DISTINCT rsvp.event_id as event_id, event_name as event_name, updates.username as r_username
FROM events, rsvp, updates
WHERE events.event_id=updates.event_id AND rsvp.event_id=events.event_id  AND updates.username!='$username' AND
rsvp.event_id IN (SELECT event_id FROM rsvp WHERE username='$username') ORDER BY Time DESC LIMIT 5;");

while($rows = $resultSe5->fetch_assoc())
{
echo "<hr>";
$event_id = $rows['event_id'];
$event_name = $rows['event_name'];
$r_username = $rows['r_username'];

;?>

<b>User <form action='infor.php' method='post' style='display: inline;'><button type="profile" name="profile" value=<?php echo $r_username;?> class="btn btn-default btn-xs"><?php echo "$r_username";?></button></form> made a post in the event <form action='detail.php' method='post' style='display: inline;'><button type="group" name="group" value=<?php echo $event_id;?> class="btn btn-default btn-xs"><?php echo "$event_name";?></button> you participated in.</b></form>
<?php 
}
?> <hr>
        </p>
      </div>
    </div>
  </div>
  
<br>
<footer class="container-fluid">
  <p>www.cookzilla.com</p>
</footer>

<script>
// #1 - Search configuration - To replace with your own
var ALGOLIA_APPID = '';
var ALGOLIA_SEARCH_APIKEY = '';
var ALGOLIA_INDEX_NAME = 'actors';
var NB_RESULTS_DISPLAYED = 5;

// #2- Algolia API Client Initialization
var algoliaClient = new algoliasearch(ALGOLIA_APPID, ALGOLIA_SEARCH_APIKEY); 
var index = algoliaClient.initIndex(ALGOLIA_INDEX_NAME);

var lastQuery = '';
$('#autocomplete-textarea').textcomplete([
  {
    // #3 - Regular expression used to trigger the autocomplete dropdown
    match: /(^|\s)@(\w*(?:\s*\w*))$/,
    // #4 - Function called at every new keystroke
    search: function(query, callback) {
      lastQuery = query;
      index.search(lastQuery, { hitsPerPage: NB_RESULTS_DISPLAYED })
        .then(function searchSuccess(content) {
          if (content.query === lastQuery) {
            callback(content.hits);
          }
        })
        .catch(function searchFailure(err) {
          console.error(err);
        });
    },
    // #5 - Template used to display each result obtained by the Algolia API
    template: function (hit) {
      // Returns the highlighted version of the name attribute
      return hit._highlightResult.name.value;
    },
    // #6 - Template used to display the selected result in the textarea
    replace: function (hit) {
      return ' @' + hit.name.trim() + ' ';
    }
  }
], {
  footer: '&lt;div style="text-align: center; display: block; font-size:12px; margin: 5px 0 0 0;"&gt;Powered by &lt;a href="http://www.algolia.com"&gt;&lt;img src="https://www.algolia.com/assets/algolia128x40.png" style="height: 14px;" /&gt;&lt;/a&gt;&lt;/div&gt;'
});
</script>

<script>


(function ($) {

  $.fn.rating = function () {

    var element;

    // A private function to highlight a star corresponding to a given value
    function _paintValue(ratingInput, value) {
      var selectedStar = $(ratingInput).find('[data-value=' + value + ']');
      selectedStar.removeClass('glyphicon-star-empty').addClass('glyphicon-star');
      selectedStar.prevAll('[data-value]').removeClass('glyphicon-star-empty').addClass('glyphicon-star');
      selectedStar.nextAll('[data-value]').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
    }

    // A private function to remove the selected rating
    function _clearValue(ratingInput) {
      var self = $(ratingInput);
      self.find('[data-value]').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
      self.find('.rating-clear').hide();
      self.find('input').val('').trigger('change');
    }

    // Iterate and transform all selected inputs
    for (element = this.length - 1; element >= 0; element--) {

      var el, i, ratingInputs,
        originalInput = $(this[element]),
        max = originalInput.data('max') || 5,
        min = originalInput.data('min') || 0,
        clearable = originalInput.data('clearable') || null,
        stars = '';

      // HTML element construction
      for (i = min; i <= max; i++) {
        // Create <max> empty stars
        stars += ['<span class="glyphicon glyphicon-star-empty" data-value="', i, '"></span>'].join('');
      }
      // Add a clear link if clearable option is set
      if (clearable) {
        stars += [
          ' <a class="rating-clear" style="display:none;" href="javascript:void">',
          '<span class="glyphicon glyphicon-remove"></span> ',
          clearable,
          '</a>'].join('');
      }

      el = [
        // Rating widget is wrapped inside a div
        '<div class="rating-input">',
        stars,
        // Value will be hold in a hidden input with same name and id than original input so the form will still work
        '<input type="hidden" name="',
        originalInput.attr('name'),
        '" value="',
        originalInput.val(),
        '" id="',
        originalInput.attr('id'),
        '" />',
        '</div>'].join('');

      // Replace original inputs HTML with the new one
      originalInput.replaceWith(el);

    }

    // Give live to the newly generated widgets
    $('.rating-input')
      // Highlight stars on hovering
      .on('mouseenter', '[data-value]', function () {
        var self = $(this);
        _paintValue(self.closest('.rating-input'), self.data('value'));
      })
      // View current value while mouse is out
      .on('mouseleave', '[data-value]', function () {
        var self = $(this);
        var val = self.siblings('input').val();
        if (val) {
          _paintValue(self.closest('.rating-input'), val);
        } else {
          _clearValue(self.closest('.rating-input'));
        }
      })
      // Set the selected value to the hidden field
      .on('click', '[data-value]', function (e) {
        var self = $(this);
        var val = self.data('value');
        self.siblings('input').val(val).trigger('change');
        self.siblings('.rating-clear').show();
        e.preventDefault();
        false
      })
      // Remove value on clear
      .on('click', '.rating-clear', function (e) {
        _clearValue($(this).closest('.rating-input'));
        e.preventDefault();
        false
      })
      // Initialize view with default value
      .each(function () {
        var val = $(this).find('input').val();
        if (val) {
          _paintValue(this, val);
          $(this).find('.rating-clear').show();
        }
      });

  };

  // Auto apply conversion of number fields with class 'rating' into rating-fields
  $(function () {
    if ($('input.rating[type=number]').length > 0) {
      $('input.rating[type=number]').rating();
    }
  });

}(jQuery));

</script>

<script>
    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }
        
        $( "#tname" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 1,
            source: function( request, response ) {
                // delegate back to autocomplete, but extract the last term
                $.getJSON("skills.php", { term : extractLast( request.term )},response);
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.value );
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );
                return false;
            }
        });
    });
    </script>
    
    <LINK href="style.css" rel="stylesheet" type="text/css" />
<SCRIPT src="http://code.jquery.com/jquery-2.1.1.js"></SCRIPT>
<SCRIPT>
function addMore() {

	$("<DIV>").load("input.php", function() {
			$("#product").append($(this).html());
	});	
}
function deleteRow() {

	$('DIV.product-item').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				$(item).remove();
            }
        });
	});
}
</SCRIPT>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}
</script>
   
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

<SCRIPT>
function addMore1() {
	$("<DIV>").load("input1.php", function() {
			$("#product1").append($(this).html());
	});	
}
function deleteRow1() {
	$('DIV.product-item1').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				$(item).remove();
            }
        });
	});
}
</SCRIPT>

</body>

</html>
