<?php
$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

session_start();  

$username = $_SESSION['username'];

if(isset($_POST['group']))
{
  $_SESSION['rid'] = $_POST['group'];
}
$info = $_SESSION['rid'];

if(isset($_POST['submit']))
{
$post = $_POST['send'];
echo $post;

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

$sql = "INSERT INTO updates (event_id, username, post, ppath) VALUES ('$info','$username','$post', '$target_file')";

if(mysqli_query($mysqli, $sql)){
    echo "Records added successfully";
} else{
    echo "ERROR: Could not able to execute";
} 

}
// exit here
else
{

$sql = "INSERT INTO updates (event_id, username, post) VALUES ('$info','$username','$post')";

if(mysqli_query($mysqli, $sql)){
    echo "Records added successfully";
} else{
    echo "ERROR: Could not able to execute";
} 
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  
<link rel="stylesheet" type="text/css" href="image.css">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <meta charset="utf-8">
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
      box-shadow:0px 0px 5px 2px rgba(0,0,0,0.5);
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
  	padding-top: 100px;
  	padding-left: 280px;
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
table, td, th {    

    text-align: left;
    margin-left: 1cm;
}
th, td {
    padding: 5px;
}
tr:nth-child(even){background-color: #f2f2f2}

/* BUBBLE CHAT */

.bubble {
    position: relative;
    background: #FFFFCC;
    border: 1px solid #FFCC00;
    max-width:250px;
    padding:10px;
    font-family:arial;
    margin:0 auto;
    font-size:14px;
    border-radius:6px;

}
.bubble:after {
    border-color: rgba(255, 255, 204, 0);
    border-right-color: #FFFFCC;
    border-width: 15px;
    margin-top: -15px;
}
.bubble:before {
    border-color: rgba(255, 204, 0, 0);
    border-right-color: #FFCC00;
    border-width: 16px;
    margin-top: -16px;
}
.button4 {
	border-radius: 12px;
	background-color: #2d5399;
    border: none;
    color: white;
    text-align: center;
    display: inline-block;
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
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Blog..">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      
    </div>
    <div class="col-sm-7 text-left">
	<div class="row">
    
		

<?php

$resultSet1 = $mysqli->query("SELECT event_id, event_name, event_location, event_description, event_organizer, Date, EXTRACT(year FROM Date) as year, EXTRACT(month FROM Date) as month, EXTRACT(day FROM Date) as day, Time FROM events WHERE event_id='$info'");

		while($rows = $resultSet1->fetch_assoc())
		{
		$event_id = $rows['event_id'];
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


<table width="750">
  <tr>
    <th width="30%">Details</th><br>
    <th><small><form action='user_part.php' method='post'><button type="part" name="part" value="<?php echo $event_id;?>" class="button4">View Group Members</button></form></small></th>
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
    <td>Event Description:</td>
    <td><?php echo "$event_description"; ?></td>
</tr>
<tr>
    <td>Number of Group Members:</td>
    <td><?php echo "$enroll"; ?></td>
</tr>
</table>
<h2> &nbsp;&nbsp;Group Details & Updates </h2>
<?php } } ?>
      		
      		<div class="col-md-12">
      		<div class="panel panel-default">
      		
      		
              <form method="post" enctype="multipart/form-data">
              
              <div class="panel-body">
    			
              <p><textarea type="send" name="send" class="form-control" placeholder="Can you please describe it ?" style="height:100px;font-size:14pt;"></textarea></p>  
			  
              <p><input type="file" name="fileToUpload" id="fileToUpload"></p>      
              
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
    <hr>
    <h4><small>RECENT POSTS</small></h4>
    <?php 

		$resultSet1 = $mysqli->query("SELECT updates.username, post, ppath, path, EXTRACT(year FROM ptime) as year, EXTRACT(month FROM ptime) as month, EXTRACT(day FROM ptime) as day, time(ptime) AS time1 FROM updates, registration WHERE updates.username=registration.username AND event_id='$info' ORDER BY ptime DESC");

		while($rows = $resultSet1->fetch_assoc())
		{
		$post = $rows['post'];
		$aid3 = $rows['description'];
		$day = $rows['day'];
		$month = $rows['month'];
		$servings = $rows['no_of_servings'];
		$monthName = date('F', mktime(0, 0, 0, $month, 10));
		$time = $rows['time1'];
		$time_12  = date("g:i a", strtotime("$time"));
		$year = $rows['year'];
		$yes=$rows['path'];
		$no = basename($yes,".php");
		$image=$rows['ppath'];
		$pic = basename($image,".php");
		?>
      
      <hr>

<TABLE BORDER="0">
<tr>
<td><?php echo "<img src='$no' class='img-circle' height='55' width='55' alt='Avatar'>";?></td>
<td><div class="bubble"><p>

<?php echo $post;?><br>
<?php 
if($pic)
{ ?>
<img id="myImg" src="<?php echo $pic;?>" width="190" height="190">
<?php }
?>
<?php
?></p>
</div></td>
<tr>
</TABLE>
      <h5>
      <span class="glyphicon glyphicon-time"></span> Post by <?= $aid1 = $rows['username']; ?>, <?php echo "$time_12, "."$monthName"." "."$day, "."$year";?></h5>
      <?php
      }
      ?>
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
<small><button type='tags' class='btn btn-info btn-xs' name='tags' value='<?php echo $wtags;?>'>
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
<br>
<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

<div id="myModal" class="modal">
  <span class="close">×</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

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

</body>
</html>
