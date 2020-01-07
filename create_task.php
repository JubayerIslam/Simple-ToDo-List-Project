<?php


require "mysql_connect.php";


$message = "";


if (isset($_POST['submit'])) {
    $project_id = $_POST['project_id'];
    $task = $_POST['task'];
    $description = $_POST['description'];
    $created_at = date("Y-m-d h:i:sa");
    $updated_at = date("Y-m-d h:i:sa");
    $assignto = $_POST['assignto'];


    
    if ($project_id && $task && $description && $assignto) {
        
        $sql = "INSERT INTO tasks (`project_id`, `task`, `description`, `created_at`, `created_by`,`updated_at`, `updated_by`, `assign_to`) VALUES ('".$project_id."', '".$task."', '".$description."', '".$created_at."', '".$_SESSION['userId']."', '".$updated_at."', '".$_SESSION['userId']."', '".$assignto."')";
        if (mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>";
            echo "alert('New record created successfully')";
            echo "</script>";
        }else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }else{
        $message = "**Please fill all the fields**";
    }
}

?>