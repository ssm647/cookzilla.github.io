<html>
<meta charset="utf-8">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
$resultSet12 = $mysqli->query("SELECT password from login WHERE username='$username'");
$password = $_SESSION['password']; 

$resultSet1 = $mysqli->query("SELECT registration.first_name FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet2 = $mysqli->query("SELECT registration.last_name FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet3 = $mysqli->query("SELECT registration.gender FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet4 = $mysqli->query("SELECT registration.date_of_birth FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet5 = $mysqli->query("SELECT registration.zip FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet6 = $mysqli->query("SELECT registration.city FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet7 = $mysqli->query("SELECT registration.state FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet8 = $mysqli->query("SELECT registration.country FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet9 = $mysqli->query("SELECT registration.discription FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet10 = $mysqli->query("SELECT registration.password FROM registration, login WHERE registration.username=login.username AND registration.username='$username' AND password='$password'");
$resultSet12 = $mysqli->query("SELECT username, password from login WHERE username='$username' AND password='$password'");

while($rows = $resultSet1->fetch_assoc())
	{
	$aid1 = $rows['first_name'];
	}
while($rows = $resultSet2->fetch_assoc())
	{
	$aid2 = $rows['last_name'];
	}
while($rows = $resultSet3->fetch_assoc())
	{
	$aid3 = $rows['gender'];
	}
while($rows = $resultSet4->fetch_assoc())
	{
	$aid4 = $rows['date_of_birth'];
	}
while($rows = $resultSet5->fetch_assoc())
	{
	$aid5 = $rows['zip'];
	}
while($rows = $resultSet6->fetch_assoc())
	{
	$aid6 = $rows['city'];
	}
while($rows = $resultSet7->fetch_assoc())
	{
	$aid7 = $rows['state'];
	}
while($rows = $resultSet8->fetch_assoc())
	{
	$aid8 = $rows['country'];
	}
while($rows = $resultSet9->fetch_assoc())
	{
	$aid9 = $rows['discription'];
	}
	
//Password
while($rows = $resultSet12->fetch_assoc())
	{
	$aid11 = $rows['username'];
	$aid12 = $rows['password'];
	}
	
if(isset($_POST['submit1']))
 {
 $search = $mysqli->real_escape_string($_POST['fname']);
 $sql = "UPDATE registration SET first_name='$search' WHERE username='$username'";
 
if(mysqli_query($mysqli, $sql)){
    $message = "First name updated successfully";
	} else
	{
   	$message = "ERROR: Could not able to execute";
	}
 echo '<script type="text/javascript">location.reload();</script>';
 }
 
 if(isset($_POST['submit2']))
 {
 $search = $mysqli->real_escape_string($_POST['lname']);
 $sql = "UPDATE registration SET last_name='$search' WHERE username='$username'";
 
if(mysqli_query($mysqli, $sql)){
    $message = "Username updated successfully";
	} else
	{
   	$message = "ERROR: Could not able to execute";
	}
 echo '<script type="text/javascript">location.reload();</script>';
 }
 
 /* gender*/
if(isset($_POST['submit3']))
 {
  $search = $mysqli->real_escape_string($_POST['gender']);
  $sql = "UPDATE registration SET gender='$search' WHERE username='$username'";
 
if(mysqli_query($mysqli, $sql)){
    $message = "Username updated successfully";
	} else
	{
   	$message = "ERROR: Could not able to execute";
	}
 echo '<script type="text/javascript">location.reload();</script>';
 }
  /* dob*/
 if(isset($_POST['submit4']))
 {
  $dob = $mysqli->real_escape_string($_POST['birthday']);
	$your_date = date("Y-m-d", strtotime($dob));

  $sql = "UPDATE registration SET date_of_birth='$your_date' WHERE username='$username'";
 
if(mysqli_query($mysqli, $sql)){
    $message = "Username updated successfully";
	} else
	{
   	$message = "ERROR: Could not able to execute";
	}
 echo '<script type="text/javascript">location.reload();</script>';
 }
 
 if(isset($_POST['submit5']))
 {
 $search = $mysqli->real_escape_string($_POST['zip']);
 $sql = "UPDATE registration SET zip='$search' WHERE username='$username'";
 
if(mysqli_query($mysqli, $sql)){
    $message = "Username updated successfully";
	} else
	{
   	$message = "ERROR: Could not able to execute";
	}
 echo '<script type="text/javascript">location.reload();</script>';
 }
  if(isset($_POST['submit6']))
 {
 $search = $mysqli->real_escape_string($_POST['city']);
 $sql = "UPDATE registration SET city='$search' WHERE username='$username'";
 
if(mysqli_query($mysqli, $sql)){
    $message = "Username updated successfully";
	} else
	{
   	$message = "ERROR: Could not able to execute";
	}
 echo '<script type="text/javascript">location.reload();</script>';
 }
  if(isset($_POST['submit7']))
 {
 $search = $mysqli->real_escape_string($_POST['state']);
 $sql = "UPDATE registration SET state='$search' WHERE username='$username'";
 
if(mysqli_query($mysqli, $sql)){
    $message = "Username updated successfully";
	} else
	{
   	$message = "ERROR: Could not able to execute";
	}
 echo '<script type="text/javascript">location.reload();</script>';
 }
  if(isset($_POST['submit8']))
 {
 $search = $mysqli->real_escape_string($_POST['country']);
 $sql = "UPDATE registration SET country='$search' WHERE username='$username'";
 
if(mysqli_query($mysqli, $sql)){
    $message = "Username updated successfully";
	} else
	{
   	$message = "ERROR: Could not able to execute";
	}
 echo '<script type="text/javascript">location.reload();</script>';
 }
 if(isset($_POST['submit9']))
 {
 $search = $mysqli->real_escape_string($_POST['description']);
 $sql = "UPDATE registration SET discription='$search' WHERE username='$username'";
 
if(mysqli_query($mysqli, $sql)){
    $message = "Username updated successfully";
	} else
	{
   	$message = "ERROR: Could not able to execute";
	}
 echo '<script type="text/javascript">location.reload();</script>';
 }
  
 //Password submission
 
 if(isset($_POST['submit12']))
 {
 $search = $mysqli->real_escape_string($_POST['password']);
 echo $search;
 $csearch = $mysqli->real_escape_string($_POST['cpassword']);
 echo $csearch;
 if($search==$csearch) {
 $sql = "UPDATE login SET password='$search' WHERE username='$username'";

if(mysqli_query($mysqli, $sql)){  
	 echo "<script>alert('Password change successful. Please logout the system to reflect the changes.');</script>";
 }
 else
 {
 echo "<script>alert('Make sure your password and confirm password matches');</script>";
 }
 }
 }
 
 
 
$target_dir = "/Applications/MAMP/htdocs/images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<script>alert('File uploaded successfully!');</script>";
    } else {
    	echo "Sorry, there was an error uploading your file.";
    }
    
    if(isset($_POST['submit']))
{
	
	$sql = "UPDATE registration SET path='$target_file' WHERE username='$username'";
	if(mysqli_query($mysqli, $sql)){
    //echo "Records added successfully.";
	} else{
    echo "ERROR: Could not able to execute";
    }
}

}
?>

<html>
<head>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}
tr:hover {
	background-color:#f2f2f2
}
tr:nth-child(odd){background-color: #f2f2f2}
tr:nth-child(even){background-color: white}

th {
    background-color: #4CAF50;
    color: white;
}
/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
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
    width: 100%;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}

.table {
	padding: 0px;
    width: 100%;
    border-radius: 15px;
    
}

/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
    width:100%;
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

body 
{
    background-size: 100% 100%;
    background-repeat: repeat-x; 
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

/* menu */


ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111;
}

/* scroll down */

button.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

button.accordion.active, button.accordion:hover {
    background-color: #ddd;
}

button.accordion:after {
    content: '\02795';
    font-size: 13px;
    color: #777;
    float: right;
    margin-left: 5px;
}

button.accordion.active:after {
    content: "\2796";
}

div.panel {
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: 0.6s ease-in-out;
    opacity: 0;
}

div.panel.show {
    opacity: 1;
    max-height: 500px;
}

.roundrect {
border-radius: 15px;
}

.test{
    height:20px;
    width:40px;
}

</style>

</head>
<body>

<div class="container">
	<div class="row">
    
		<div class="col-md-13">
		<br>
      	<?php 
	
		$resultSet1 = $mysqli->query("SELECT first_name, last_name, gender, zip, city, country, state, discription, path, EXTRACT(year FROM date_of_birth) as year, EXTRACT(month FROM date_of_birth) as month, EXTRACT(day FROM date_of_birth) as day FROM registration WHERE username='$username'");

		while($rows = $resultSet1->fetch_assoc())
		{
		$fname = $rows['first_name'];
		$lname = $rows['last_name'];
		$gender = $rows['gender'];
		$zip = $rows['zip'];
		$city = $rows['city'];
		$country = $rows['country'];
		$state = $rows['state'];
		$description = $rows['discription'];
		$day1 = $rows['day'];
		$month1 = $rows['month'];
		$dateObj   = DateTime::createFromFormat('!m', $month1);
		$monthName1 = $dateObj->format('F');
		$time1 = $rows['time'];
		$time12  = date("g:i a", strtotime("$time"));
		$year1 = $rows['year'];
		$pro=$rows['path'];
		$dp = basename($pro,".php");
		?>
		<table BORDER="0" width="100%">
		<tr>
		<td width="20%"></td>
		<td width="35%">
		<?php echo "<img src='$dp' class='roundrect' height='210' width='210' alt='Avatar'>"; ?>
		</td>
		<td>
		<?php
		echo "<p>"."Name: "."$fname"." "."$lname"."</p>";
		echo "<p>"."Gender: "."$gender"."</br>"."</p>";
		echo "<p>"."Date of birth: "."$monthName1"." "."$day1, "."$year1"."</p>";
		echo "<p>"."Zip: "."$zip"."</br>"."</p>";
		echo "<p>"."City: "."$city"."</br>"."</p>";
		echo "<p>"."State: "."$state"."</br>"."</p>";
		echo "<p>"."Country: "."$country"."</br>"."</p>";
		echo "<p>"."Description: "."$description"."</p>";
		
		?>
		</td>
		</tr>
		</table>
		<?php
		}
		?>
           
           
          </div>
	</div>
</div>

<h2>Profile settings</h2>
<button class="accordion">Change profile picture</button>
<div class="panel">
  <form action="" method="post" enctype="multipart/form-data">
  <table border=0>
  <tr>
  <td>Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload"></td>
   <td><input type="submit" value="Upload Image" name="submit"></td>
  </tr>
  </table>
</form>
</div>

<button class="accordion">Profile details</button>
<div class="panel">
  <div class="table">
<table>
  <tr>
    <th>Detail</th>
    <th>Information</th>
    <th></th>
  </tr>
  <tr>
    <td>First Name</td>
    <td><?php echo "$aid1" ?></td>
    <td><button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">edit</button></td>
  </tr>
  <tr>
    <td>Last Name</td>
    <td><?php echo "$aid2" ?></td>
    <td><button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">edit</button></td>
  </tr>
  <tr>
    <td>Gender</td>
    <td><?php echo "$aid3" ?></td>
    <td><button onclick="document.getElementById('id03').style.display='block'" style="width:auto;">edit</button></td>
</tr>
<tr>
    <td>Date of Birth</td>
    <td><?php echo "$aid4" ?></td>
    <td><button onclick="document.getElementById('id04').style.display='block'" style="width:auto;">edit</button></td>
</tr>
<tr>
    <td>Description</td>
    <td><?php echo "$aid9" ?></td>
    <td><button onclick="document.getElementById('id09').style.display='block'" style="width:auto;">edit</button></td>
</tr>
</table>
</div>
</div>

<button class="accordion">Address details</button>
`<div class="panel">
  <div class="table">
<table>
  <tr>
    <th>Detail</th>
    <th>Information</th>
    <th></th>
  </tr>
  <tr>
    <td>Zip</td>
    <td><?php echo "$aid5" ?></td>
    <td><button onclick="document.getElementById('id05').style.display='block'" style="width:auto;">edit</button></td>
</tr>
<tr>
    <td>City</td>
    <td><?php echo "$aid6" ?></td>
    <td><button onclick="document.getElementById('id06').style.display='block'" style="width:auto;">edit</button></td>
</tr>
<tr>
    <td>State</td>
    <td><?php echo "$aid7" ?></td>
    <td><button onclick="document.getElementById('id07').style.display='block'" style="width:auto;">edit</button></td>
</tr>
<tr>
    <td>Country</td>
    <td><?php echo "$aid8" ?></td>
    <td><button onclick="document.getElementById('id08').style.display='block'" style="width:auto;">edit</button></td>
</tr>
</table>
</div>
</div>
<h2>User Credentials</h2>
<hr>

<button class="accordion">Change Username & Password</button>
`<div class="panel">
  <div class="table">
<table>
  <tr>
    <th>Detail</th>
    <th>Information</th>
    <th></th>
  </tr>
  <tr>
    <td>Username</td>
    <td><?php echo "$aid11" ?></td>
    <small><i>Username once set cannot be change</i></small>
</tr>
<tr>
    <td>Password</td>
    <td><input type="password" value="<?php echo "$aid12" ?>" readonly></td>
    <td><button onclick="document.getElementById('id12').style.display='block'" style="width:auto;">edit</button></td>
    
</button>
</tr>
</table>
</div>
</div>

<body>

<div id="id01" class="modal">
  
  <form method="post" class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Set your new first name</b></label>
      <input type="text" placeholder="Enter your first name" name="fname" required>
      
     
      <button type="submit1" name="submit1">Confirm</button>
    </div>
  </form>
</div>

<div id="id02" class="modal">
  
  <form method="post" class="modal-content animate"> 
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Set your new last name</b></label>
      <input type="text" placeholder="Enter your last name" name="lname" required>
        
      <button type="submit2" name="submit2">Confirm</button>
    </div>
  </form>
</div>

<div id="id03" class="modal">
  
  <form method="post" class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label for="gender"><b>Set your gender</b></label>
		<input type="radio" name="gender" value="male" checked> Male
		<input type="radio" name="gender" value="female"> Female
		<input type="radio" name="gender" value="other"> Other
        
      <button type="submit3" name="submit3">Confirm</button>
    </div>
  </form>
</div>

<div id="id04" class="modal">
  
  <form method="post" class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Set your Date of Birth</b></label>
      <input type="date" placeholder="Enter your date of birth" name="birthday" id="birthday" required>
        
      <button type="submit4" name="submit4">Confirm</button>
    </div>
  </form>
</div>


<div id="id05" class="modal">
  
  <form method="post" class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Set your new Zip</b></label>
      <input type="text" placeholder="Enter your zip" name="zip" required>
        
      <button type="submit5" name="submit5">Confirm</button>
    </div>
  </form>
</div>

<div id="id06" class="modal">
  
  <form method="post" class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id06').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Set your new City</b></label>
      <input type="text" placeholder="Enter your city" name="city" required>
        
      <button type="submit6" name="submit6">Confirm</button>
    </div>
  </form>
</div>

<div id="id07" class="modal">
  
  <form method="post" class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id07').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Set your new State</b></label>
      <input type="text" placeholder="Enter your state" name="state" required>
        
      <button type="submit7" name="submit7">Confirm</button>
    </div>
  </form>
</div>

<div id="id08" class="modal">
  
  <form method="post" class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id08').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Set your new Country</b></label>
      <input type="text" placeholder="Enter your country" name="country" required>
      <button type="submit8" name="submit8">Confirm</button>
    </div>
  </form>
</div>

<div id="id09" class="modal">
  
  <form method="post" class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id08').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Set your Description</b></label>
      <textarea type="text" placeholder="Enter your Description" name="description"></textarea>
      <button type="submit9" name="submit9">Confirm</button>
    </div>
  </form>
</div>


<div id="id12" class="modal">
  
  <form method="post" class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id12').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Set your new password</b></label>
      <input type="password" placeholder="Enter your new password" name="password" required>
      <label><b>Confirm password</b></label>
      <input type="password" placeholder="Enter your new password" name="cpassword" required>
      <button type="submit12" name="submit12">Confirm</button>
    </div>
  </form>
</div>


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

<script>
// Get the modal
var modal = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('id03');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('id04');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


<script>
// Get the modal
var modal = document.getElementById('id05');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('id06');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('id07');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('id08');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('id09');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('id12');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
//scroll down
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function(){
        this.classList.toggle("active");
        this.nextElementSibling.classList.toggle("show");
  }
}
</script>

<script>
function show() {
    var p = document.getElementById('pwd');
    p.setAttribute('type', 'text');
}

function hide() {
    var p = document.getElementById('pwd');
    p.setAttribute('type', 'password');
}

var pwShown = 0;

document.getElementById("eye").addEventListener("click", function () {
    if (pwShown == 0) {
        pwShown = 1;
        show();
    } else {
        pwShown = 0;
        hide();
    }
}, false);
</script>

<script type="text/javascript">
    var datefield=document.createElement("input")
    datefield.setAttribute("type", "date")
    if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n') 
    }
</script>
 
<script>
if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
    jQuery(function($){ //on document.ready
        $('#birthday').datepicker();
    })
}
</script>

</body>
</html>