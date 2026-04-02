<?php
    require_once __DIR__ . '/../controller/user-controller.php';
    require_once __DIR__. '/../controller/functions/general-functions.php';

    $response = null;

    if(isset($_POST['submit'])){
        $user = new User(
            $_POST['name'],
            $_POST['email'],
            $_POST['password'],
            generate_code()
        );
        $response = controller_save_user($user);
    }

    if($response === "success"){
        // Redirect to the login page after successful registration
        header("Location: login-page.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>signup-page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='js/main.js'></script>
</head>
<body>
    <div class="form-container">
        <div class="logo">
            <h1 class="logo-text">JYMSON</h1>
            <p class="logo-subtitle">Create your account and start building workouts with a clean and modern experience.</p>
        </div>
        <form action="" method="post">
            <h3>
                Create your account
            </h3>
            <input placeholder="Name" type="text" name="name" value="">

            <input placeholder="Email" type="email" name="email" value="">

            <div class="password_group">
                <input id="password" placeholder="Password" type="password" name="password" value="">
                <i class="fa fa-eye password-toggle" onclick="togglePassword('password', this)"></i>
            </div>
            
            <div class="password_group">
                <input id="confirm_password" placeholder="Confirm Password" type="password" name="confirm_password" value="">
            </div>

            <input type="submit" name="submit" value="Create Account">

            <?php 
                if($response == "success"){
                    ?>
                        <p class="success">Your account has been created successfully!</p>
                    <?php
                    }
                if($response == "Error, passwords do not match"){
                        ?>
                            <p class="error">Error, passwords do not match</p>
                        <?php
                    }
                if($response == "error"){
                        ?>
                            <p class="error">An account with this email already exists. Please try again.</p>
                        <?php
                    }
            ?>

            <label>Already have an account? <a href="login-page.php">Login</a></label>

        </form>
    </div>
</body>
</html>