<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeLink Website</title>
    <link href="../css_files/SignUp.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
    include 'signupAlgo.php'; // Include the files from signinAlgo.php where all the algorithm of the backend is done
?>

    <section>
     <img src="../pictures/safelink-logo.png" style="margin-top: 30px;">
    <div id="login_wrapper">
        <div id="login">
            <h1>Register User</h1>
            <div id="register_form">
                <form class="form" name="form_register" id="form_register" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form_row">
                        <label for="textemail">Email</label>
                        <input type="email" name="textemail" id="textemail" class="register-email required" placeholder="Enter your email" required>
                    </div>
                    <div class="form_row">
                        <label for="textpassword">Password</label>
                        <input type="password" name="textpassword" id="textpassword" class="register-password required" placeholder="Enter your password" required>
                    </div>
                     <div class="form_row">
                            <label for="sex">Sex</label>
                            <select name="sex" id="sex" class="login-sex required">
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                        <!-- Address input field -->
                        <div class="form_row">
                            <label for="address">Device ID</label>
                            <input type="text" name="deviceid" id="deviceid" class="device-address required" placeholder="Enter your Device-ID" required>
                        </div>
                    <div class="form_row">
                        <input type="submit" value="Login" name="buttonlogin" class="login-button">
                    </div>
                </form>
                <br>
                <div align="left">
                    <a href="login.php">Already have an account?</a>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>