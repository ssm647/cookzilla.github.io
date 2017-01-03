<?php
if(isset($_POST['submit']))
{
$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

$username = $_POST['username'];
$password = $_POST['password'];
$rem = $_POST['remember'];

$resultSet = $mysqli->query("SELECT username, password FROM login WHERE username='$username' AND password='$password'");

if($resultSet->num_rows>0)
{
	$rem = $_POST['remember'];
	if($rem)
	{
	session_start();
	$_SESSION['remember']=$rem;
	$_SESSION['username']=$username;
	$_SESSION['password']=$password;
	header("Location: new_wall.php");
	}
}
else
{
	$dErr = "   "."<font size='3' color='red'> *Warning: Incorrect username & password</font>";
} 
}
?>

<html>

<div class="vertical">
<div class="corner">

<button id="myButton" style="width:auto;">Sign up</button>
</div>
<button type="button" class="cancelbtn">Help</button>
</div>



<form id='register' method='post' accept-charset='UTF-8'>
<div class="imgcontainer">
    <img src="sharp.png" alt="Avatar" class="avatar">
  </div>

<div class="container2" style="background-color:#f1f1f1">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit" name='submit' value='Login'>Login</button>
    <input type="checkbox" name="remember" checked="checked"> Remember me
</div>

<!--<input type='submit' name='submit' value='Login' /></br>-->
<div class="container1" style="background-color:#f1f1f1">
	<span class="error"><?php echo $dErr;?></span>
</div>
<div class="container" style="background-color:#f1f1f1" align="center">
	<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Welcome to Cookzilla</button>
    
    
  </div>


</p>

<style>

form { width: 500px; }
label { float: left; width: 150px; }

fieldset{
  border: 1px solid rgb(255,232,57);
  width: 400px;
  margin:auto;
}
body 
{
    background-image: url("fresh.png");
    background-size: 100% 100%;
    background-repeat: repeat-x; 
}

form {
    margin: 0 auto; 
	width:350px;
	height:554px;
	vertical-align: middle;
	-webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
    border-radius: 15px;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    border-radius: 15px;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}

.adjust
{
	width:50px; 
	height:50px;
}

.vertical {
	position: fixed;
    top: 0;
    left: 0;
    width: 300px;
    vertical-align: middle;

}

.corner {
	position: fixed;
    top: 0;
    right: 0;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
    border-radius: 15px;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}

.imgcontainer {
    text-align: center;
    margin: 20px 0 24px 0;
}

img.avatar {
    width: 50%;
    border-radius: 50%;
 }

.container {
    padding: 16px;
    box-shadow: 10px 10px 5px black;
    border-bottom-right-radius: 15px;
    border-bottom-left-radius: 15px;
}
.container2 {
    padding: 16px;
    box-shadow: 10px 10px 5px black;
    border-top-right-radius: 15px;
    border-top-left-radius: 15px;
}
.container1 {
    padding: 2px;
    box-shadow: 10px 10px 5px black;
}

span.psw {
    float: right;
    padding-top: 16px;
}
</style>

<body>


<script type="text/javascript">
    document.getElementById("myButton").onclick = function () {
        location.href = "http://localhost:8888/registration.php";
    };
</script>

</body>
</html>