<?php

require "mysql_connect.php";

if (isset($_GET['del'])) {
	
	$id = $_GET['del'];

	$sql = "DELETE FROM projects WHERE id = '$id'";
	if (mysqli_query($conn, $sql)) {
		    echo "<script type='text/javascript'>";
            echo "function myFunction(){
            	confirm('Are you sure delete?');
            	
            }";
            echo "</script>";
	}
}
?>