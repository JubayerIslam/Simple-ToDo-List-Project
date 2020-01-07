<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit data</title>
	<link rel="stylesheet" type="text/css" href="css/edit.css">
</head>
<body>

<?php 

session_start();

require "header.php";
require "mysql_connect.php";

if (isset($_SESSION['user'])) {
   
?>

<?php

if(isset($_POST['submit'])){
	$id = $_POST['id'];
	$project_name = $_POST['proname'];
	$start_date = $_POST['startdate'];
	$end_date = $_POST['enddate'];
	$status = $_POST['status'];

    $sql = "UPDATE projects SET name='$project_name', start_date = '$start_date',  end_date = '$end_date', status='$status' WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
    }else{
    	echo "data no edit";
    }
}
?>



<div class="container">
	<form action="editproject.php" method="post">
		<h2>Update Your Data</h2>
		<label for="id">ID</label><br>
		<input type="text" name="id" ><br>
		<label for="name">Project Name</label><br>
		<input type="text" name="proname" ><br>
		<label for="srtdate">Start Date</label><br>
		<input type="text" name="startdate" ><br>
		<label for="enddate">End Date</label><br>
		<input type="text" name="enddate" ><br>
		<label for="status">Status</label><br>
		<input type="text" name="status" ><br>

		<input type="submit" name="submit" value="Update Data">
	</form>
</div>




<?php

	if (isset($_GET['action']) && $_GET['action'] == "logout") {
		session_destroy();
		header("Location:index.php");
	}
}else{
	require "body.php";
	
}
require "footer.php";
?>


</body>
</html>