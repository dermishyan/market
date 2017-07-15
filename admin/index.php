<?php
include "connect.php";


?>
<html>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="../js/jquery-3.2.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
                <div class="form-group">
                    <label for="log">Username:</label>
                    <input type="text" class="form-control user" id="log">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control pass" id="pwd">
                </div>
                <button type="button" class="btn btn-success go-btn">Login</button>
                <div class="alert alert-danger error">
                    <strong>Error!</strong> Wrong username or password
                </div>
            </div>
        </div>




    <script src="../js/js.js"></script>
    </body>


</html>