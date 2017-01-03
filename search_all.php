<?php
$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

session_start();  


$username = $_SESSION['username'];

if(isset($_POST['search']))
{
$search = $_POST['search'];
}
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
	
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

tr:hover{background-color:#f5f5f5}

input[type=text1] {
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

input[type=text1]:focus {
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
    
    <div class="col-sm-9 text-left">
           
<input type="text1" id="myInput" value="<?php echo $_POST['search']; ?>" onkeyup="myFunction()" placeholder="Search" title="Type in a name">
           
<table id="myTable">
  <tr class="header">
  <th style="width:60%;">Recipe Title</th>
    <th style="width:30%;">Rating</th>
    <th style="width:30%;">Get info</th>
  </tr>
  <?php 
    
		$resultSet1 = $mysqli->query("SELECT first_name, last_name, no_of_servings, recipe_id, recipe_image, path, EXTRACT(year FROM time) as year, EXTRACT(month FROM time) as month, EXTRACT(day FROM time) as day, time(time) AS time1, recipe_username, recipe_title, description, recipe_time FROM recipe, registration WHERE registration.username=recipe.recipe_username AND recipe.recipe_title!='Welcome to Cookzilla' AND recipe_title LIKE '%$searchTerm%' ORDER BY recipe.time DESC");

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
  <tr>
  	
    <td><?php
      if($pic)
      { ?>
      <img  src="<?php echo $pic;?>" alt="<?php echo $aid2 ?>" width="95" height="60">
      <?php } echo $aid2; ?></td>
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
        ?><td>
        <?php if($rate12==NULL) { ?><div><span class="stars-container stars-0">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==0) { ?><div><span class="stars-container stars-0">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==1) { ?><div><span class="stars-container stars-20">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==2) { ?><div><span class="stars-container stars-40">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==3) { ?><div><span class="stars-container stars-60">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==4) { ?><div><span class="stars-container stars-80">★★★★★</span></div> <?php } ?>
		<?php if($a_rating==5) { ?><div><span class="stars-container stars-100">★★★★★</span></div> <?php } ?></td>
		
      <td><form method="post" action="comment.php">
      <button type="submit" value="<?php echo $recipe_id;?>" name="submit" class="btn btn-primary">Get more info</button>
      </form></td>
</tr> 
      <?php 
      } 
      ?>
     
</table> 

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

<div id="id01" class="modal"> 
  <form class="modal-content animate">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
<div class="scrollit">

<?php 

$resultSet1 = $mysqli->query("SELECT first_name, last_name, path, following_name FROM following, registration WHERE following.following_name=registration.username AND following.username='$username' ORDER BY RAND()");

		while($rows = $resultSet1->fetch_assoc())
		{
		$foname = $rows['following_name']; 
		$pname = $rows['first_name'];
		$lname = $rows['last_name'];
		$path = $rows['path'];
		$dp = basename($path,".php");
		?>	

		<table BORDER="0" width="100%">
		<tr>
		<td width="10%"></td>
		<td width="14%">
		<h3>
    	<?php
			echo "<img src='$dp' class='img-circle' height='55' width='55' alt='Avatar'>";
	  	?></h3></td>
	 	<td width="80%"><h4><?php echo "$pname"." "."$lname";?></h4><small><form action='infor.php' method='post'><button type="profile" class="btn btn-primary btn-xs" name="profile" value="<?php echo $foname;?>">View profile</button></form></small></td>
		</tr>
		</table>
		
<?php
		}
?>
</div>
    
  </form>
</div>


<div id="id02" class="modal"> 
  <form class="modal-content animate">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
<div class="scrollit">
<?php 

$resultSet1 = $mysqli->query("SELECT first_name, last_name, path, following.username as username FROM following, registration WHERE following.username=registration.username AND following.following_name='$username' ORDER BY RAND()");

		while($rows = $resultSet1->fetch_assoc())
		{
		$fname = $rows['username']; 
		$pname = $rows['first_name'];
		$lname = $rows['last_name'];
		$path = $rows['path'];
		$dp = basename($path,".php");
		?>	
		
		<table BORDER="0" width="100%">
		<tr>
		<td width="10%"></td>
		<td width="14%">
		<h3>
    	<?php
			echo "<img src='$dp' class='img-circle' height='55' width='55' alt='Avatar'>";
	  	?></h3></td>
<td width="80%"><h4><?php echo "$pname"." "."$lname";?></h4><small><form action='infor.php' method='post'><button type="profile" class="btn btn-primary btn-xs" name="profile" value="<?php echo $fname;?>">View profile</button></form></small></td>
		</tr>
		</table>
		
		
<?php
		}
		
?>
</div>
<hr>
    
  </form>
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
