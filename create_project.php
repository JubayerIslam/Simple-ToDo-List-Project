<?php 

$message = "";

if(isset($_POST['project'])){
    $project = $_POST['project'];
    $start_date = date("Y-m-d");
    $end_date = date("Y-m-d");



   if ($project) {
        $sql = "INSERT INTO projects (`name`, `start_date`, `end_date`) VALUES ('".$project."','".$start_date."', '".$end_date."') ";
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