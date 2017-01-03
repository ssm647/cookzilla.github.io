<?php
	if(!empty($_POST["save"])) {
		$servername = "localhost";
		$username = "root";
		$password = "root";
		$db = "cookzilla";

// Create connection
$conn = new mysqli($$servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

		$itemCount = count($_POST["r_steps"]);
		$itemValues=0;
		$query = "INSERT INTO steps (";
		$queryValue1 = "";
		$queryValue2 = ") VALUES (";
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
		
		if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
	} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
?>
<HTML>
<HEAD>
<TITLE>Cookzilla steps</TITLE>
<LINK href="style.css" rel="stylesheet" type="text/css" />
<SCRIPT src="http://code.jquery.com/jquery-2.1.1.js"></SCRIPT>
<SCRIPT>
function addMore() {
	$("<DIV>").load("input1.php", function() {
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
</HEAD>
<BODY>
<FORM name="frmProduct" method="post" action="">


<DIV id="product">
<?php require_once("input.php") ?>
</DIV>
<input type="button" name="add_item" value="Add More" onClick="addMore();" />
<input type="button" name="del_item" value="Delete" onClick="deleteRow();" />
<span class="success"><?php if(isset($message)) { echo $message; }?></span>
<input type="submit" name="save" value="Save" />
</form>
</BODY>
</HTML>