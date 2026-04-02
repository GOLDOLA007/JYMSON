<?php
    require_once __DIR__ . '/../controller/user-controller.php';
    require_once __DIR__. '/../controller/functions/general-functions.php';
    require_once __DIR__ . '/../model/User.php';
    
    $response = null;

    if(isset($_POST['submit'])){
        $user = new User(
            "",
            $_POST['email'],
            $_POST['password'],
            ""
        );
        $response = controller_search_user($user);
    }

    if($response == "success"){
        header("Location: mainMenu-page.php");
        exit();
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>login-page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='js/main.js'></script>
</head>
<body>
    <div class="form-container">
        <div class="logo">
            <h1 class="logo-text">JYMSON</h1>
            <p class="logo-subtitle">Sign in to keep your workouts synced and your motivation high.</p>
        </div>
        
        <form action="" method="post">
            <h3>
                Welcome back
            </h3>
            <input placeholder="Email" type="email" name="email" value="">

            <div class="password_group">
                <input id="password" placeholder="Password" type="password" name="password">
            </div>

            <input type="submit" name="submit" value="Login">

            <?php 
                if($response == "success"){
                    ?>
                        <p class="success">You have logged in successfully!</p>
                    <?php
                }else if($response == "error"){
                    ?>
                        <p class="error">Invalid name, email or password. Please try again.</p>
                    <?php
                };
            ?>

            <label>Don't have an account? <a href="signup-page.php">Sign up</a></label>

        </form>
    </div>
</body>
</html>