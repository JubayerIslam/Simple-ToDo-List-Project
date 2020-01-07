<?php

require "mysql_connect.php";

if (isset($_GET['id'])) {
	
	$sql = "UPDATE tasks SET status='1' WHERE id='".$_GET['id']."'";
	$result = mysqli_query($conn, $sql);

if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

}
?>