<?php
//include php file 
    require "functions.php";

    $response = null;

    //if button is clicked, we will call the saveUser function to verify if the user exists or not
    if(isset($_POST['submit'])){
        $response = saveUser($_POST['name'], $_POST['email'], $_POST['password']);
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>PAGE</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <form action="" method="post">
        <h3>
            Create your account
        </h3>

        <label>Name</label>
        <input type="text" name="name" value="">

        <label>Email</label>
        <input type="email" name="email" value="">

        <label>Password</label>
        <input type="password" name="password" value="">

        <input type="submit" name="submit" value="Create Account">

        <?php 
            if($response == "success"){
                ?>

                <?php
            }
        ?>

        <label>Already have an account? <a href="index.php">Login</a></label>

    </form>
</body>
</html>