<?php
// session_start();
// if(count($_SESSION) === 0) {
//     header("Location: index.php");
// }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Register Form</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>

</style>

<body>


<?php
require "header.php";
require "mysql_connect.php";

$username = $email = $password = $confirm_psw = "";
$usernameErr = $emailErr = $passwordErr = $confirm_pswErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error = 0;

    if (empty($_POST['username'])) {
        $error++;
    }

    $username = validate($_POST['username']);
    $email = validate($_POST['email']);
    $password = validate($_POST['psw']);
    $pass_en = md5($password);
    $confirm_psw = validate($_POST['psw-repeat']);
    $date = date("Y-m-d");
    $role = "";

    $usernamelength = strlen($username);
    $passwordlength = strlen($password);


    if (empty($_POST['username'])) {
        $usernameErr = "**Username is required**";
    }else{
        $username = validate($_POST['username']);
        if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
            $usernameErr = "**Only letters and white space allowed**";
        } elseif ($usernamelength  <= 4 || $usernamelength > 20) {
            $usernameErr = "**Username must be 4 charecter to 20 charecter**";
        }
    }


    if (empty($_POST['email'])) {
        $emailErr = "**Email is required**";
    }else{
        $email = validate($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "**Invalid email formats**";
        }
    }


    if (empty($_POST['psw'])) {
        $passwordErr = "**Password is required**";
    }else{
        if ($passwordlength < 8) {
            $passwordErr = "**Password longer than 8 charecter**";
        }
        $password = validate($_POST['psw']);
    }


    if ($error === 0) {
        if ($username && $email && $password && $confirm_psw) {
            if ($password == $confirm_psw) {
                $sql = "INSERT INTO `users` (`username`, `email`, `password`,`date`) VALUES ('".$username."', '".$email."', '".$pass_en."', '".$date."')";
                if(mysqli_query($conn, $sql)){
                    echo "You have Registered <a href='login.php'>here</a>  to login";
                }else{
                echo "Failed $sql" . "<br>" . mysqli_error($conn);
                }
            }else{
                $confirm_pswErr = "**password doesn't match **";
            }
        } 
    }
}


function validate($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

            <form class="modal-content" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <div class="container">
                    <h1>Sign Up</h1>
                    <p style="color: red;">Please fill in this form to create an account.</p>
                    <hr>
                    <label for="username"><b>Username</b></label>
                    <input type="text" placeholder="Username" name="username">
                    <span class="error"><?php echo $usernameErr;?></span><br><br>

                    <label for="email"><b>Email</b></label>
                    <input type="text" placeholder="Enter Email" name="email">
                    <span class="error"><?php echo $emailErr;?></span><br><br>

                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw">
                    <span class="error"><?php echo $passwordErr;?></span><br><br>

                    <label for="psw-repeat"><b>Repeat Password</b></label>
                    <input type="password" placeholder="Repeat Password" name="psw-repeat">
                    <span class="error"><?php echo $confirm_pswErr;?></span><br><br>

                    <label>
                        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
                    </label>

                    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
                        <input type="submit" name="submit" value="Register">
                    </div>
                </div>
            </form>

<?php require 'footer.php'; ?>

</body>

</html>