<?php
    include('header.php');
    include('navbar.php');

    require '../config/functions.php';
?>

<!-- main body -->
<main>
    <!-- Login Form -->
    <section class="container-fluid d-flex justify-content-center">
        <div class="jumbotron login-jumbotron col-md-4 mx-sm-5" >
            <h1 class="account-title">LOGIN</h1>
            <br/>
            <form action="login.php" method="post">
                <div class="form-group <?php echo (!empty($email_err_login)) ? 'has-error' : ''; ?>">
                    <label for="login-email" class="login-label">Email Address</label><br>
                    <input id="login-email" name="user_email" type="email" placeholder="Enter your Email Address" value="<?php echo $user_email; ?>" required/>
                    <span class="help-block text-danger"><?php echo $email_err_login; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label for="login-password" class="login-label">Password</label>
                    <input id="login-password" name="user_password" type="password" placeholder="Enter your Password" value="<?php echo $user_password; ?>" required/>
                    <span class=" help-block text-danger"><?php echo $password_err_login; ?></span>
                </div>

                <!-- Button -->
                <input name="login_button" type="submit" value="Login" class="btn btn-lg login-btn">
            </form>

            <!-- Sign Up Container -->
            <div class="signup-container">
                <p>Not a member yet? <a class="to_register" href="signup_form.php">Join us</a></p>
            </div>
        </div>
    </section>
    <!-- /Login Form -->
</main>
<!-- End of Main Body -->

<?php include('footer.php'); ?>

<script>
    document.getElementById("account").style.color="rgba(42, 89, 213, 1)";
</script>