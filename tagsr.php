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

if(isset($_POST['tags']))
{
$_SESSION['pro'] = $_POST['tags'];
}
$tags = $_SESSION['pro'];

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
//if(n["submit"])) {
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

$title = $_POST['title'];
$description = $_POST['description'];

$sql = "INSERT INTO recipe (recipe_username, recipe_title, description, recipe_image, recipe_time) VALUES ('$username','$title','$description', '$target_file', '$inm')";

if(mysqli_query($mysqli, $sql)){
    echo "Records added successfully";
} else{
    echo "ERROR: Could not able to execute";
} 

}
// exit here
else
{
$title = $_POST['title'];
$description = $_POST['description'];

$sql = "INSERT INTO recipe (recipe_username, recipe_title, description, recipe_time) VALUES ('$username','$title','$description', '$inm')";

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
      <button onclick="location.href = 'all_users.php';" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-user"></span> Search Users
          <span class="glyphicon glyphicon-search"></span> 
    </button>
    </div>
    <div class="col-sm-7 text-left">

    <h4><small>RECENT POSTS</small></h4>
    <?php 
    
		$resultSet1 = $mysqli->query("SELECT first_name, last_name, no_of_servings, recipe.recipe_id as recipe_id, recipe_image, path, EXTRACT(year FROM time) as year, EXTRACT(month FROM time) as month, EXTRACT(day FROM time) as day, time(time) AS time1, recipe_username, recipe_title, description, recipe_time FROM recipe, registration, tags WHERE registration.username=recipe.recipe_username AND tags.recipe_id=recipe.recipe_id AND tag_name='$tags' ORDER BY time DESC");

		while($rows = $resultSet1->fetch_assoc())
		{
		$first_name = $rows['first_name'];
		$last_name = $rows['last_name'];
		
		$recipe_id = $rows['recipe_id'];
		$aid2 = $rows['recipe_title'];
		$recipe_time = $rows['recipe_time'];
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
		$image=$rows['recipe_image'];
		$pic = basename($image,".php");	
		?>
      <hr>

<div class="w3-panel w3-card-2 w3-white"><br>
<TABLE BORDER="0" width="100%">
<TR>

<TD width="10%"><?php 
			echo "<img src='$no' class='img-circle' height='55' width='55' alt='Avatar'>";
			?></TD>
<td width="80%"><h4><?php echo "$first_name"." "."$last_name";?></h4><small><form action='infor.php' method='post'><button type="profile" name="profile" value="<?php echo $rows['recipe_username'];?>" class="button4">View profile</button></form></small></td>

<TD><form action='modal.php' method='post'><button type="modal" name="modal" value="<?php echo $recipe_id;?>" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-pencil"></span>
        </button></form></TD>
        
<TD><form action="cancel.php" method='post'>
        <button type="cancel" name="cancel" value="<?php echo $recipe_id;?>" class="btn btn-default btn-sm">
        <span class="glyphicon glyphicon-trash"></span>
		 </button>
		 </form></TD>
</TR>
</TABLE>
	  <table>
	  <tr>
	  <td width="75%"><h3><?php echo "$aid2";?></h3></td>
	  <?php 
        
        $resultS1 = $mysqli->query("SELECT sum(rating) as sum FROM reviewers WHERE r_recipe_id='$recipe_id'");
		
		while($rows = $resultS1->fetch_assoc())
		{
        $rate12=$rows['sum'];
        } 
        
        $resultS2 = $mysqli->query("SELECT count(r_id) as count FROM reviewers WHERE r_recipe_id='$recipe_id'");

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
      <h5><span class="glyphicon glyphicon-time"></span> Post by <?= $aid1 = $rows['recipe_username']; ?>, <?php echo "$time_12, "."$monthName"." "."$day, "."$year";?></h5>
      
      <?php 
	
		$resultSet6 = $mysqli->query("SELECT tag_name FROM tags WHERE recipe_id='$recipe_id'");

		while($rows = $resultSet6->fetch_assoc())
		{ 
		$wtags = $rows['tag_name'];
		?>
      <small><form method='post' action='tagsr.php' style='display: inline;'><button type='tags' class='btn btn-info btn-xs' name='tags' value='<?php echo $wtags;?>'>
		<?php echo $wtags;?></button></form></small>
      <?php }
      ?>
      <hr width="50%" align="left">
      <b><i><?php echo "Total Time: "."$recipe_time"." "."Minutes"."<br>";?></i></b>
      <b><i><?php echo "Number of Servings: "."$servings";?></i></b>
      <hr width="50%" align="left">
      <p><?php echo "$aid3";?></p>   
     <?php
      if($pic)
      { ?>
      <img id="myImg" src="<?php echo $pic;?>" alt="<?php echo $recipe_title?>" width="300" height="200">
      <?php }
     ?>
     
     <br><br>

<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">×</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div> 
      <form method="post" action="comment.php">
      <button type="submit" value="<?php echo $recipe_id;?>" name="submit" class="btn btn-primary">Get more info</button>
      </form><br><br>
      </div>
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
<small><form method='post' action='tagsr.php' style='display: inline;'><button type='tags' class='btn btn-info btn-xs' name='tags' value='<?php echo $tag_name;?>'>
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
      <?php }} ?><a href="re_users.php">View all</a><br>
      </div>
      </div>
    </div>
  </div>
</div>



<footer class="container-fluid text-center">
  <p>Footer Text</p>
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
