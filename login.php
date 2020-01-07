<?php
session_start();
if(count($_SESSION) > 0) {
    
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400|Raleway&display=swap" rel="stylesheet">
</head>

<?php


require "header.php";
require "mysql_connect.php";


$message = "";
$role = "";
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
   


        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if($row['role'] == 'manager'){
                    $_SESSION['userId'] = $row['id']; // manager
                    $_SESSION['user'] = $row['username'];
                    $_SESSION['role'] = $row['role'];
                    header("Location:index.php");
                }else{
                    $_SESSION['userId'] = $row['id']; // developer
                    $_SESSION['user'] = $row['username'];
                    $_SESSION['role'] = $row['role'];
                    header("Location:index.php");
                }
            }
        }else{
            $message = "Invalid Username or Password";
        }
    }

echo $role;
?>


<body>

            <form class="modal-content animate" action="login.php" method="post">
                <div class="imgcontainer">
                    <img src="images/profile.png" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                    <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="username">

                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password">
                    <span class="error"><?php echo $message; ?></span><br><br>

                    <input type="submit" name="submit" value="Login">
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> Remember me
                    </label>
                </div>
            </form>

<?php require "footer.php"; ?>
</body>

</html>