<?php 

session_start();



if (isset($_GET['action']) && $_GET['action'] == "logout") {
    session_destroy();
    header("Location:index.php");  
}

require "header.php";
require "mysql_connect.php";

if (isset($_SESSION['user'])) {
	
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Simple ToDo project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body>

<!-- Create project validation and insert data ---------------------------------------------->



<!---------------------Create Project start ------------------------------------------------->

<?php require "create_project.php"; ?>


<?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'manager'){ ?>
    <div class="create-project">
        <form action="index.php" method="post">
        <h2>Create Projects:</h2><br>
        <input type="text" name="project" placeholder="Create project">
        <input type="submit" value="Add Project"><br>
        <span style="color: red;"><?php echo $message; ?></span>
        </form>
    </div>
<?php } ?>



<div class="row">
    <div class="col">
        <strong>ID</strong>
    </div>
    <div class="col">
        <strong>Projects Name</strong>
    </div>
    <div class="col">
        <strong>Start Date</strong>
    </div>
    <div class="col">
        <strong>End Date</strong>
    </div>
    <div class="col">
        <strong>Status</strong>
    </div>
    <div class="col">
        <strong>Action</strong>
    </div>
</div>


<?php 

require "delete.php";

$sql = "SELECT * FROM projects";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $status = $row['status'];

            echo '<div class="row">
                    <div class="col">'.$id.'</div>
                    <div class="col">'.$name.'</div>
                    <div class="col">'.$start_date.'</div>
                    <div class="col">'.$end_date.'</div>
                    <div class="col">'.$status.'</div>
                    <div class="col">'."<button><a href='editproject.php'>Edit</a></button>"."<button onclick='myFunction()'><a href='index.php?del=$id'>Delete</a></button>".'</div>

                </div>';
    }
}

?>

<!--------------------------------Create Project End--------------------------------------------------->


<!-- ----------------------------Create Task start --------------------------------------------------->

<?php require "create_task.php"; ?>

<?php
$sql = "SELECT id, name FROM projects WHERE status = 1";
$result = mysqli_query($conn, $sql);
$projects = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $projects[] = $row;
    }
}
?>
<!-----------select form---------------- -->
<?php 

$sql = "SELECT id, username FROM users";
$result = mysqli_query($conn, $sql);
$users = [];

if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
?>


    <div class="add-task">
        <form action="index.php" method="post">
            <h2>Add Task For Developer</h2><br>
            <span class="error"> <?php echo $message; ?> </span><br>
            <select class="select-css" name="project_id">
                <option>Select a project id</option>
                <?php foreach($projects as $project) { ?>
                <option value="<?=$project['id']?>"><?=$project['name']?></option>
                <?php } ?>
            </select>
            <input type="text" name="task" placeholder="Create task"><br>
            <textarea name="description" placeholder="Description, be nice!" cols="113" rows="20"></textarea><br>
            <select class="select-css" name="assignto">
                <option>assign to</option>
                <?php foreach ($users as $user) { ?>
                   <option value="<?=$user['id']?>"><?=$user['username']?></option>
                <?php } ?>
            </select><br>
            <input type="submit" name="submit" value="Add Task"><br>
        </form>
    </div>
<!---------------------------- Create Task End ------------------------------------------>


<!-- create a task table front end ---------------------------------------------------->
  
<?php echo '<table id="customers">' ?>
    <tr>
        <th>Id</th>
        <th>Projects Name</th>
        <th>Task</th>
        <th>Description</th>
        <th>Created At</th>
        <th>Created By</th>
        <th>Assign To</th>
        <th>Status</th>
    </tr>

<?php

$sql = "SELECT aset.id, aset.name, aset.task, aset.description, aset.created_at, aset.created_by, aset.status, bset.assign_to FROM (SELECT tasks.id, projects.name, tasks.task, tasks.description, tasks.created_at, users.username AS created_by, tasks.status FROM tasks JOIN projects ON projects.id = tasks.`project_id` JOIN users ON users.id = tasks.`created_by`) AS aset JOIN (SELECT tasks.id, projects.name, tasks.task, tasks.description, users.username AS assign_to FROM tasks JOIN projects ON projects.id = tasks.`project_id` JOIN users ON users.id = tasks.`assign_to`) AS bset ON bset.id = aset.id";
$result = mysqli_query($conn, $sql);
// $data = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // $data[] = $row;
        echo "<tr><td>".$row['id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['task']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$row['created_at']."</td>";
        echo "<td>".$row['created_by']."</td>";
        echo "<td>".$row['assign_to']."</td>";
        echo "<td>".$row['status']."</td></tr>";
    }
}
// print("<pre>");
// print_r($data);

echo "</table>";
?>

<!-- create a task table front end ---------------------------------------------------->

<div class="work">
    <div class="tabs-button">
        <button class="tablinks one" onclick="openPendingWork(event, 'Pending')" id="defaultOpen">Pending</button>
        <button class="tablinks two" onclick="openPendingWork(event, 'Working')">Working</button>
        <button class="tablinks three" onclick="openPendingWork(event, 'Done')">Done</button>
    </div>

    <div id="Pending" class="tabcontent">
        <?php require "pending.php"; ?>
    </div>
    <div id="Working" class="tabcontent">
        <?php require "working.php"; ?>
        <?php

            $sql = "SELECT id, task FROM tasks WHERE status=1";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        echo $row['id']. ".   ";
                        echo $row['task'];
                        echo "<button><a href='doneWork.php?id=$id'>Done</a></button>" . "<br>";
                }
            }
        ?>
    </div>
    <div id="Done" class="tabcontent">
        <?php require "working.php"; ?>

        <?php

            $sql = "SELECT id, task FROM tasks WHERE status=2";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                        echo $row['id']. ".   ";
                        echo $row['task'];
                        echo "<br>";
                }
            }
        ?>

    </div>
</div>

	<script type="text/javascript" src="js/app.js"></script>

</body>
</html>

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


