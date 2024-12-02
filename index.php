<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeLink Website</title>
    <link href="..\css_files\MainSiteCSS.css" rel="stylesheet" type="text/css">

</head>
<body>
<?php
    include 'php_files/loginAlgo.php'; // Include the files from loginAlgo.php where all the algorithm of the backend is done
?>
    <section>
     <img src="../pictures/safelink-logo.png" style="margin-top: 30px;">
    <div id="login_wrapper">
        <div id="login">
            <h1>User Login</h1>

            <!-- Display messages -->
            <p class="errmsg"><?php if (isset($message)) echo $message; ?></p>
            <br />

            <div id="login_form">
                <form class="form" name="form_login" id="form_login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form_row">
                        <label for="textemail">Email</label>
                        <input type="email" name="textemail" id="textemail" class="login-email required" placeholder="Enter your email" required>
                    </div>
                    <div class="form_row">
                        <label for="textpassword">Password</label>
                        <input type="password" name="textpassword" id="textpassword" class="login-password required" placeholder="Enter your password" required>
                    </div>
                    <div class="form_row">
                        <input type="submit" value="Login" name="buttonlogin" class="login-button">
                    </div>

                </form>
                <br>
                <div align="left">
                    <a href="php_files/signup.php">Don't have an account?</a>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
