<?php
$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

session_start();  

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

/*edit*/

input[type=text], input[type=password] {
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
    
}


span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
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
    <div class="col-sm-8 text-left">
              
      <hr>
    <h4><small>RECENT POSTS</small></h4>
    <?php 

		$resultSet1 = $mysqli->query("SELECT recipe_id, recipe_image, recipe_id, path, EXTRACT(year FROM time) as year, EXTRACT(month FROM time) as month, EXTRACT(day FROM time) as day, time(time) AS time1, recipe_username, recipe_title, description, recipe_time FROM recipe, registration WHERE registration.username=recipe.recipe_username AND username='$username' ORDER BY time DESC");

		while($rows = $resultSet1->fetch_assoc())
		{
		$recipe_id = $rows['recipe_id'];
		$aid2 = $rows['recipe_title'];
		$recipe_time = $rows['recipe_time'];
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
<TABLE BORDER="0" width="100%">
<TR>

<TD width="90%"><?php 
			echo "<img src='$no' class='img-circle' height='55' width='55' alt='Avatar'>";
			?></TD>
<TD><form action='edit.php' method='post'>
        <button type="edit" name="edit" class="btn btn-default btn-sm" value="<?php echo $recipe_id;?>" onclick="document.getElementById('id01').style.display='block'">
          <span class="glyphicon glyphicon-pencil"></span>
        </button></form></TD>
        
<TD><form action='cancel.php' method='post'>
        <button type="cancel" name="cancel" value="<?php echo $recipe_id;?>" class="btn btn-default btn-sm">
        <span class="glyphicon glyphicon-remove"></span>
		 </button>
		 </form></TD>
</TR>
</TABLE>

	  <h3><?php echo "$aid2";?></h3>
      <h5><span class="glyphicon glyphicon-time"></span> Post by <?= $aid1 = $rows['recipe_username']; ?>, <?php echo "$time_12, "."$monthName"." "."$day, "."$year";?></h5>
      <h5><span class="label label-success">Lorem</span></h5><br>
      <b><i><?php echo "$recipe_time"." "."Minutes";?></i></b>
      <p><?php echo "$aid3";?></p>
      <?php
      if($pic)
      {
      echo "<p><img src='$pic' height='190' width='190' alt='Avatar'></p>";
      }
     ?>
      
      <form method="post" action="blog.php">
      <button type="submit" value="<?php echo $rows['recipe_id'];?>" name="submit" class="btn btn-primary">Get more info</button>
      </form>
      <?php 
      } 
      ?>
    </div>
    
    <div class="col-sm-2 sidenav">
      <div class="well">
        <p>Notification</p>
      </div>
      <div class="well">
        <p>Under Construction</p>
      </div>
    </div>
  </div>
</div>
<br>
<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

<!--EDIT-->

<div id="id01" class="modal">
  
  <!--<form class="modal-content animate" action="action_page.php">-->

   <div class="container">
	<div class="row">
    
		<div class="col-md-8">

      		<div class="panel panel-default">
      		
              <form method='post' enctype="multipart/form-data" action="action_page.php">
              
              <div class="panel-body">
              <p><input type="text" name="title" class="form-control" placeholder="What's your recipe title ?" value="<?php echo "Hello"; ?>"></p>
    			
              <p><textarea type="text" name="description" class="form-control" placeholder="Can you please describe it ?" style="height:100px;font-size:14pt;"></textarea></p>
            
              <p><b>Number of servings:</b>
              <select type='servings' name='servings'>
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
			  
              <p><input type="file" name="fileToUpload" id="fileToUpload"></p>      
              
              <input class="form-control" rows="5" id="autocomplete-textarea" placeholder="What tags belongs to your dish ?">
              
              </div>
              
                <div class="panel-footer">
                  <div class="btn-group">
                  <div class="pull-right">
                    <button type="submit" name="submit" class="btn btn-success">Save Changes</button>
                  </div>
                  </div>  
                </div>
                </form>
            </div>
          </div>
	</div>
</div>
    
  <!--</form>-->
</div>



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
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
