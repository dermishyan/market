<?php

include "admin/connect.php";
session_start();

$error = "";
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $users_res = mysqli_query($connect,"select * from users where username = "."'$username'"." and password = "."'$password'");
    $fetch_users = mysqli_fetch_assoc($users_res);
   if(mysqli_num_rows($users_res) == 1){
       $_SESSION["user_id"] = $fetch_users["id"];
   }
    else{
        $error = "<div class='alert alert-danger'>
                    <strong>Error!</strong> Wrong username or password
                  </div>";
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Harut MArket))</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out logout" ></span> Log-Out</a></li>
            </ul>
        </div>
    </nav>

    <?php
    if(!isset($_SESSION["user_id"])){
        ?>
    <div class="login_small">Login</div>
    <div class="login_user">
        <div class="close_login">x</div>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-success " name="login">Login</button>
        </form>
            <button type="button" class="btn btn-primary registration" >
                <a href="registration.php" style="color:#000;">
                    Registration
                </a>
            </button>

        <?php echo $error;?>
    </div>
        <?php
    }?>
