<!DOCTYPE html>
<html>

<head>
    <title>Simple ToDo List Project</title>
    <meta lang="en">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

    <header class="header">
        <h1 class="logo"><a href="#">ToDo</a></h1>
        <ul class="main-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Member</a></li>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'manager'){ ?>
                <li><a href="index.php?action=logout">Logout</a></li>
                <li><a href="#"><?php echo $_SESSION['user']; ?>(Ad)</a></li>
            <?php }elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'developer'){ ?>
                <li><a href="index.php?action=logout">Logout</a></li>
                <li><a href="#"><?php echo $_SESSION['user']; ?>(dev)</a></li>
            <?php }else { ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php } ?>
        </ul>
    </header>

</body>

</html>