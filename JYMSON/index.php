<?php
//include php file 
    require "functions.php";

    $response = null;

    if(isset($_POST['submit'])){
        $response = search_user($_POST['name'], $_POST['email'], $_POST['password']);
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <form action="" method="post">
        <h3>
            Welcome back!
        </h3>

        <label>Name</label>
        <input type="text" name="name" value="">

        <label>Email</label>
        <input type="email" name="email" value="">

        <label>Password</label>
        <input type="password" name="password">

        <input type="submit" name="submit" value="Login">

        <?php 
            if($response == "success"){
                
            }else{

            };
        ?>

        <label>Don't have an account? <a href="signup.php">Sign up</a></label>

    </form>
</body>
</html>