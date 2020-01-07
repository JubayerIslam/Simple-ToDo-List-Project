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

echo '</table>';
?>

<!-- create a task table front end end end------------------------------------------------->