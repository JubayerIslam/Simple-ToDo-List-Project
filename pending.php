<?php
require "mysql_connect.php";
$sql = "SELECT id , task FROM tasks";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){

	while ($row = mysqli_fetch_assoc($result)) {
		  $id = $row['id'];
		  echo $row['id']. ".  ";
		  echo $row['task'];
		  echo "<button><a href='working.php?id=$id'>Working</a></button>" . "<br>";
	}

}
?>