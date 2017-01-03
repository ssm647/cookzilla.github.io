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

if(isset($_POST['submit']))
{
  $_SESSION['rid'] = $_POST['submit'];
}
$rid = $_SESSION['rid'];

if(isset($_POST['submit1']))
{
$title = $_POST['title'];
$review = $_POST['review'];
$suggestion = $_POST['suggestion'];
$rating = $_POST['star'];

if(!isset($title) || trim($title) == '' || !isset($review) || trim($review) == '' )
{
	echo "<script>alert('Make sure the following fields are not empty: 1. Title 2. Review');</script>"; 
}
else
{
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
       // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$sql = "INSERT INTO reviewers (r_username, r_recipe_id, r_title, review, suggestions, r_image, rating) VALUES ('$username','$rid','$title', '$review', '$suggestion', '$target_file', '$rating')";

if(mysqli_query($mysqli, $sql)){
    //echo "Records added successfully";
} else{
    echo "ERROR: Could not able to execute";
}
}
// exit here
else
{

echo "$rating";
$sql = "INSERT INTO reviewers (r_username, r_recipe_id, r_title, review, suggestions, rating) VALUES ('$username','$rid','$title', '$review', '$suggestion', '$rating')";

if(mysqli_query($mysqli, $sql)){
    //echo "Records added successfully";
} else{
    echo "ERROR: Could not able to execute";
}
}
}
}

if(isset($_POST['cancelc']))
{
$cancelc = $_POST['cancelc'];

$sql = "DELETE FROM reviewers WHERE r_id=$cancelc";

if(mysqli_query($mysqli, $sql)){
    echo "Deleted ";
} else {
    echo "Error deleting record: ";
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="image.css">
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

/* STAR */

div.stars {
  width: 270px;
  display: inline-block;
}

input.star { display: none; }

label.star {
  float: right;
  padding: 10px;
  font-size: 26px;
  color: #444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\f005';
  color: #FD4;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\f006';
  font-family: FontAwesome;
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

.button4 {
	border-radius: 12px;
	background-color: #2d5399;
    border: none;
    color: white;
    text-align: center;
    display: inline-block;
	}

/*Intact star comments*/

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

/* Ingredient */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
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
        </button>
    </div>
    
<div class="col-sm-7 text-left">

    <form action="new_wall.php"><button  class="btn btn-default btn-sm"><span class="glyphicon glyphicon-chevron-left"></span>Go back</button></form>
    <h4><small>WHAT DO YOU THINK ABOUT THIS POSTS</small></h4>
      <hr>
       <?php 
		
		$resultSet1 = $mysqli->query("SELECT recipe_image, EXTRACT(year FROM time) as year, EXTRACT(month FROM time) as month, EXTRACT(day FROM time) as day, time(time) AS time1, recipe_username, recipe_title, description, path, first_name, last_name FROM recipe, registration WHERE registration.username=recipe.recipe_username AND recipe_id='$rid'");
	
		while($rows = $resultSet1->fetch_assoc())
		{
		$first_name = $rows['first_name'];
		$last_name = $rows['last_name'];
		$recipe_username = $rows['recipe_username'];
		$recipe_title = $rows['recipe_title'];
		$description = $rows['description'];
		$day = $rows['day'];
		$month = $rows['month'];
		$monthName = date('F', mktime(0, 0, 0, $month, 10));
		$time = $rows['time1'];
		$time_12  = date("g:i a", strtotime("$time"));
		$year = $rows['year'];
		$image=$rows['recipe_image'];
		$pic = basename($image,".php");
		$yes=$rows['path'];
		$no = basename($yes,".php");
		}	
		
		
		$resultSet2 = $mysqli->query("SELECT step1, step2, step3, step4, step5, step6, step7, step8, step9, step10 FROM steps WHERE recipe_id='$rid'");
	
		while($rows = $resultSet2->fetch_assoc())
		{
		$step1 = $rows['step1'];
		$step2 = $rows['step2'];
		$step3 = $rows['step3'];
		$step4 = $rows['step4'];
		$step5 = $rows['step5'];
		$step6 = $rows['step6'];
		$step7 = $rows['step7'];
		$step8 = $rows['step8'];
		$step9 = $rows['step9'];
		$step10 = $rows['step10'];
		}
		?>
		
		<?php 
	
		$resultSet7 = $mysqli->query("SELECT ing1, ing2, ing3, ing4, ing5, ing6, ing7, ing8, ing9, ing10 FROM ingredients WHERE recipe_id='$rid'");

		while($rows = $resultSet7->fetch_assoc())
		{ 
		$ing1 = $rows['ing1'];
		$ing2 = $rows['ing2'];
		$ing3 = $rows['ing3'];
		$ing4 = $rows['ing4'];
		$ing5 = $rows['ing5'];
		$ing6 = $rows['ing6'];
		$ing7 = $rows['ing7'];
		$ing8 = $rows['ing8'];
		$ing9 = $rows['ing9'];
		$ing10 = $rows['ing10'];
		} 
		?>
		
	  <table BORDER="0" width="100%">
		<tr>
		<td width="10%">
		<h3>
        <?php
			echo "<img src='$no' class='img-circle' height='55' width='55' alt='Avatar'>";
	  ?></h3></td>
	  <td width="30%"><h4><?php echo "$first_name"." "."$last_name";?></h4><small><form action='infor.php' method='post'><button type="profile" name="profile" value="<?php echo $recipe_username;?>" class="button4">View profile</button></form></small></td>
      <?php 
        
        $resultS1 = $mysqli->query("SELECT sum(rating) as sum FROM reviewers WHERE r_recipe_id='$rid'");
		
		while($rows = $resultS1->fetch_assoc())
		{
        $rate12=$rows['sum'];
        } 
        
        $resultS2 = $mysqli->query("SELECT count(r_id) as count FROM reviewers WHERE r_recipe_id='$rid'");

		while($rows = $resultS2->fetch_assoc())
		{
        $count1=$rows['count'];
        } 
    	$avg = $rate12/$count1;
        $a_rating=round($avg);
        ?>
        <td><small><i>Avg rating for this post:</i></small>
        <?php if($rate12==NULL) { ?><div><span class="stars-container stars-0">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==0) { ?><div><span class="stars-container stars-0">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==1) { ?><div><span class="stars-container stars-20">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==2) { ?><div><span class="stars-container stars-40">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==3) { ?><div><span class="stars-container stars-60">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==4) { ?><div><span class="stars-container stars-80">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==5) { ?><div><span class="stars-container stars-100">★★★★★</span></div> <?php } ?></td>
      </tr>
      </table>
      <hr>
      <h2><?php echo "$recipe_title";?></h2>
      <h5><span class="glyphicon glyphicon-time"></span> Post by <?php echo $recipe_username;?>, <?php echo "$time_12, "."$monthName"." "."$day, "."$year";?></h5>


          <!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">×</span>
    
    <table class="table table-striped">
    <thead>
      <tr>
   		 <th width="30%"></th>
    	 <th>Ingredients</th>
 	 </tr>
 	 </thead>
 	 <?php 
      if($ing1!==NULL){ ?>
      <tr>
      <td>Ingredient 1:</td>
      <td><?php echo "$ing1"."<br>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($ing2!==NULL){ ?>
      <tr>
      <td>Ingredient 2:</td>
      <td><?php echo "$ing2"."<br>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($ing3!==NULL){ ?>
      <tr>
      <td>Ingredient 3:</td>
      <td><?php echo "$ing3"."<br>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($ing4!==NULL){ ?>
      <tr>
      <td>Ingredient 4:</td>
      <td><?php echo "$ing4"."<br>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($ing5!==NULL){ ?>
      <tr>
      <td>Ingredient 5:</td>
      <td><?php echo "$ing5"."<br>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($ing6!==NULL){ ?>
      <tr>
      <td>Ingredient 6:</td>
      <td><?php echo "$ing6"."<br>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($ing7!==NULL){ ?>
      <tr>
      <td>Ingredient 7:</td>
      <td><?php echo "$ing7"."<br>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($ing8!==NULL){ ?>
      <tr>
      <td>Ingredient 8:</td>
      <td><?php echo "$ing8"."<br>"; ?></td>
      </tr> <?php } ?>
      <?php
      if($ing9!==NULL){ ?>
      <tr>
      <td>Ingredient 9:</td>
      <td><?php echo "$ing9"."<br>"; ?></td>
      </tr> <?php } ?>
      <?php
      if($ing10!==NULL){ ?>
      <tr>
      <td>Ingredient 10:</td>
      <td><?php echo "$ing10"."<br>"; ?></td>
      </tr> <?php } ?>
      </table>
    
    
  </div>

</div>
      
      <?php 
	
		$resultSet6 = $mysqli->query("SELECT tag_name FROM tags WHERE recipe_id='$rid'");

		while($rows = $resultSet6->fetch_assoc())
		{ 
		$wtags = $rows['tag_name'];
		?>
      <small><form method='post' action='tagsr.php' style='display: inline;'><button type='tags' class='btn btn-info btn-xs' name='tags' value='<?php echo $wtags;?>'>
		<?php echo $wtags;?></button></form></small>
      <?php }
      ?><hr>
      <p><?php echo "$description";?></p><hr>
      <p><h4>Following are the step to make this recipe:<button type="button" id="myBtn" class="btn btn-default btn-sm" style="float: right;">
          <span class="glyphicon glyphicon-grain"></span>&nbsp;Ingredients Needed
        </button></h4><br>
        
      <table>
      <tr>
   		 <th width="25%">Step No.</th>
    	 <th>Description</th> 
 	 </tr>
 	 <?php 
      if($step1!==NULL){ ?>
      <tr>
      <td>Step 1:</td>
      <td><?php echo "$step1"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($step2!==NULL){ ?>
      <tr>
      <td>Step 2:</td>
      <td><?php echo "$step2"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($step3!==NULL){ ?>
      <tr>
      <td>Step 3:</td>
      <td><?php echo "$step3"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($step4!==NULL){ ?>
      <tr>
      <td>Step 4:</td>
      <td><?php echo "$step4"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($step5!==NULL){ ?>
      <tr>
      <td>Step 5:</td>
      <td><?php echo "$step5"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($step6!==NULL){ ?>
      <tr>
      <td>Step 6:</td>
      <td><?php echo "$step6"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($step7!==NULL){ ?>
      <tr>
      <td>Step 7:</td>
      <td><?php echo "$step7"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
       <?php 
      if($step8!==NULL){ ?>
      <tr>
      <td>Step 8:</td>
      <td><?php echo "$step8"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
      <?php
      if($step9!==NULL){ ?>
      <tr>
      <td>Step 9:</td>
      <td><?php echo "$step9"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
      <?php
      if($step8!==NULL){ ?>
      <tr>
      <td>Step 10:</td>
      <td><?php echo "$step10"."<br>"."<hr>"; ?></td>
      </tr> <?php } ?>
      </table>
      
      </p>
	  <p><?php
      if($pic)
      { ?>
      <img id="myImg1" src="<?php echo $pic;?>" alt="<?php echo $recipe_title?>" width="550" height="350">
      <?php }
     ?>
     
     <br>

</p>

	<form method='post' enctype="multipart/form-data">
    <br><hr>      
     <div class="panel-body">
    <h4>Leave your Comment:</h4>
    <p><input type="text" name="title" class="form-control" placeholder="What is the title?"></p>
    <p><textarea type="text" name="review" class="form-control" placeholder="What's your review?" style="height:100px;font-size:14pt;"></textarea></p>
    <p><textarea type="text" name="suggestion" class="form-control" placeholder="Would you like to give any suggestion?" style="height:100px;font-size:14pt;"></textarea></p> 

        <h5>Upload your try:</h5>
        <input type="file" name="fileToUpload" id="fileToUpload"> 
        <h5>Rate this recipe:</h5>
		
		<div class="stars">
  		  <input class="star star-5" id="star-5" type="radio" name="star" value="5"/>
    	  <label class="star star-5" for="star-5"></label>
          <input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
          <label class="star star-4" for="star-4"></label>
          <input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
          <label class="star star-3" for="star-3"></label>
          <input class="star star-2" id="star-2" type="radio" name="star" value="2"/>
          <label class="star star-2" for="star-2"></label>
          <input class="star star-1" id="star-1" type="radio" name="star" value="1"/>
          <label class="star star-1" for="star-1"></label>
       </div>
		

        </br>
        
        <button type="submit1" name= "submit1" class="btn btn-success">Submit</button>
             
      </form>
      <br><br>
      
      <?php 
		$resultSet3 = $mysqli->query("SELECT count(*) as count FROM reviewers WHERE r_recipe_id='$rid'");
		while($rows = $resultSet3->fetch_assoc())
		{
		$count = $rows['count'];
		}
		?>
		<p><span class="badge"><?php echo $count;?></span> Comments:</p><br>
		<?php
		$resultSet2 = $mysqli->query("SELECT r_id, path, r_username, EXTRACT(year FROM c_time) as year, EXTRACT(month FROM c_time) as month, EXTRACT(day FROM c_time) as day, time(c_time) AS time1, r_title, review, suggestions, rating, r_image FROM reviewers, registration WHERE registration.username=reviewers.r_username AND r_recipe_id='$rid' ORDER BY c_time DESC");
		while($rows = $resultSet2->fetch_assoc())
		{
		$r_id = $rows['r_id'];
		$r_username = $rows['r_username'];
		$r_title = $rows['r_title'];
		$review = $rows['review'];
		$suggestions = $rows['suggestions'];
		$rating = $rows['rating'];
		$review = $rows['review'];
		$day = $rows['day'];
		$month = $rows['month'];
		$monthName = date('F', mktime(0, 0, 0, $month, 10));
		$time = $rows['time1'];
		$time_12  = date("g:i a", strtotime("$time"));
		$year = $rows['year'];
		$yes=$rows['path'];
		$no = basename($yes,".php");
		$r_image=$rows['r_image'];
		$cpic = basename($r_image,".php");
		?>
      
      <div class="row">
        <div class="col-sm-2 text-center">
        <p> <?php echo "<img src='$no' class='img-circle' height='55' width='55' alt='Avatar'>";?></p>
        </div>
     
        <div class="col-sm-10">
        <table><tr>
        <td width="100%">
          <h4><?php echo $r_username;?><small><?php echo " $time_12, "."$monthName"." "."$day, "."$year";?></small></h4>
         </td>
         <td> 
         
       <form method='post'>
       <?php if($r_username==$username) { ?>
        <button type="cancelc" name="cancelc" value="<?php echo $r_id;?>" class="btn btn-default btn-sm" align="right">
        <span class="glyphicon glyphicon-trash"></span>
		 </button><?php } ?>
		 </form> </td></tr></table>
          
          
          <?php if($rating) { ?>
  		<?php if($rating==0) { ?><div><span class="stars-container stars-0">★★★★★</span></div> <?php } ?>
		<?php if($rating==1) { ?><div><span class="stars-container stars-20">★★★★★</span></div> <?php } ?>
		<?php if($rating==2) { ?><div><span class="stars-container stars-40">★★★★★</span></div> <?php } ?>
		<?php if($rating==3) { ?><div><span class="stars-container stars-60">★★★★★</span></div> <?php } ?>
		<?php if($rating==4) { ?><div><span class="stars-container stars-80">★★★★★</span></div> <?php } ?>
		<?php if($rating==5) { ?><div><span class="stars-container stars-100">★★★★★</span></div> <?php } ?>
		<?php } ?>
       	  
          <p><h5>Title:</h5><?php echo $r_title;?></p>
          <p><h5>Review:</h5><?php echo $review;?></p>
          <?php if($suggestions) { ?>
          <p><h5>Suggestions:</h5><?php echo $suggestions;?></p> 
          <?php } ?>
          <p><?php
      if($cpic)
      { ?>
      <img src="<?php echo $cpic;?>" alt="<?php echo $recipe_title?>" width="300" height="200">
      <?php }
     ?>
     
     <br>
</p>
          <br>
        </div>
        </div>
        <?php 
        } 
        ?>
      </div> 
    </div>

    
      <div class="col-sm-3 sidenav">
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
<small><form method='post' action='tagsr.php' style='display: inline;'><button type='tags' class='btn btn-info btn-xs' name='tags' value='<?php echo $tag_name;?>'>
		<?php echo $tag_name;?></button></small>
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
      <?php }} ?><a href="re_users.php">View all</a><br>
      </div>
      </div>
    </div>
  </div>
</div>

  </div>
</div>

<footer class="container-fluid">
  <p>Welcome to Cookzilla</p>
</footer>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>