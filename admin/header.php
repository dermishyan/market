<?php
include "connect.php";
session_start();

if(!isset($_SESSION["admin_id"])){
    header("location:index.php");
}
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="../js/jquery-3.2.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="admin.php">WebSiteName</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="admin.php">Home</a></li>
                    <li><a href="#">Page 1</a></li>
                    <li><a href="#">Page 2</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out logout" ></span> Log-Out</a></li>
                </ul>
            </div>
        </nav>
