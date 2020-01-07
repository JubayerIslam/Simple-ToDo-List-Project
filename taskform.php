<!-----------select form---------------- -->
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
