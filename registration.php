<?php
if(isset($_POST['submit']))
{
$servername = "localhost";
$username = "sheif";
$password = "root";
$dbname = "cookzilla";

$mysqli = new Mysqli($servername, $username, $password, $dbname);

$username = $_POST['username'];
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$gender = $_POST['gender'];
$dob = $_POST['birthday'];
$your_date = date("Y-m-d", strtotime($dob));
$zip = $_POST['zip'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$discription = $_POST['description'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

if($password!=$cpassword)
{
	echo "<script>alert('Password do not match!');</script>";
}
else
{
$sql = "INSERT INTO registration (username, path, first_name, last_name, gender, date_of_birth, zip, city, country, state, discription) 
VALUES ('$username', '/Applications/MAMP/htdocs/default.png','$firstname', '$lastname', '$gender', '$your_date', '$zip', '$city', '$country', '$state', '$discription')";

if(mysqli_query($mysqli, $sql)){
   
    
$sql1 = "INSERT INTO login (username, password) VALUES ('$username', '$password')";

if(mysqli_query($mysqli, $sql1)){
    echo "<script>alert('Registration Successful! Please close this popup and go back to login page');</script>"; 
} else{
    echo "<script>alert('Make sure your username is correct and your password matches');</script>";
}    

} else{
    echo "<script>alert('Something went Wrong please check the form again!');</script>";
}


//User always follow him/her 

$sql1 = "INSERT INTO following VALUES ('$username','$username')";

if(mysqli_query($mysqli, $sql1)){
    header('Location: infor.php');
	}
}
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="image.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<form action='login.php'><button class="btn btn-info btn-block">Go back</button></form>
<form id='register' onsubmit="return validateForm()" method='post' accept-charset='UTF-8'>
<input type='hidden' name='submitted' id='submitted' value='1'required/>
</br>

<div class="container1" style="background-color:#f1f1f1">
<label for="username">UserName*:</label> 
<input type='text' name='username' id='username' maxlength="20" pattern=".{6,}" required/>
<span class="error"><?php echo $usernameErr;?></span>


<p>
<label for="password">Password*:</label> 
<input type='password' name='password' id='password' maxlength="20" pattern=".{6,}" required/>
<span class="error"><?php echo $passwordErr;?></span>
</br>
</p>

<p>
<label for="cpassword">Confirm Password*:</label> 
<input type='password' name='cpassword' id='cpassword' maxlength="20" pattern=".{6,}" required/>
<span class="error"><?php echo $cpasswordErr;?></span>
</br>
</p>
<hr>
<p>
<label for="fname">First Name*:</label>  
<input type='text' name='fname' id='fname' maxlength="20" pattern=".{2,}" required/>
<span class="error"><?php echo $fnameErr;?></span>
</br>
</p>

<p>
<label for="lname">Last Name*:</label>  
<input type='text' name='lname' id='lname' maxlength="20" pattern=".{2,}" required/>
<span class="error"><?php echo $lnameErr;?></span>
</br>
</p>

<p>
<label for="gender">Gender*:</label>  
<input type="radio" name="gender" value="male" checked> Male
<input type="radio" name="gender" value="female"> Female
<input type="radio" name="gender" value="other"> Other 
</br>
</p>

<p>
<label for="dob">Date of Birth*:</label>  

<input type="date" id="birthday" name="birthday" size="20" required/>
<!--<input type='date' name='dob' id='calendar' />-->
</br>
</p>

<p>
<label for="zip">Zip*:</label>  
<input type='text' name='zip' id='zip' maxlength="20" pattern=".{3,}" required/>
</br>
</p>

<p>
<label for="city">City*:</label>  
<input type='text' name='city' id='city' maxlength="20" pattern=".{3,}" required/>
</br>
</p>

<p>
<label for="state">State*:</label> 
<input type='text' name='state' id='state' maxlength="20" pattern=".{4,}" required/>
</br>
</p>

<p>
<label for="country">Country*:</label>  
<input type='text' name='country' id='country' maxlength="20" pattern=".{3,}" required/>
</br>
</p>

<p>
<label for="description">Description*:</label>  
<textarea type='text' name='description' style="width:245px; height:50px;" pattern=".{30,}" required/></textarea>
</br>
</p>
</div>
<div class="container2" style="background-color:#f1f1f1">
<button type='submit' name="submit" value='submit'>Submit</button>
</div>
</form>
<style>

form { width: 500px; }
label { float: left; width: 150px; }

input[type=text], input[type=password], input[type=date] {
    width: 40%;
    padding: 6px 20px;
    margin: 4px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
    border-radius: 15px;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}
body 
{
    background-image: url("reg.png");
    background-size: 100% 100%;
    background-repeat: repeat-x; 
}
form {
    margin: 0 auto; 
	width:650px;
	vertical-align: middle;
	text-align: center;
}
input [type=text] {
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
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 30%;
    border-radius: 15px;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
}
.container1 {
    padding: 16px;
    box-shadow: 10px 10px 5px black;
    border-top-right-radius: 15px;
    border-top-left-radius: 15px;
}
.container2 {
    padding: 16px;
    box-shadow: 10px 10px 5px black;
    border-bottom-right-radius: 15px;
    border-bottom-left-radius: 15px;
}
</style>

<body background="sharp.jpg">

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
