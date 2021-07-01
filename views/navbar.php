<?php
    // require '../config/functions.php';
    include('header.php');
    include('session.php');
?>

<header class="container-fluid" style="margin-bottom: 95px">
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top px-5 py-0">
        <a class="navbar-brand logo" href="home.php">
            <img src="../images/logo-rectangle.png" alt="NearER" class="mr-3 my-1">
        </a>
        <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarHospitalAccommodation">
            <span class="navbar-toggler-icon "></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarHospitalAccommodation">
            <ul class="navbar-nav mr-auto my-auto">
                <li class="nav-item">
                    <a class="nav-link mx-1 px-2" href="home.php" id="home">
                        <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        if ($_SESSION["hospital_type"] !== 'ADMIN') { ?>
                            Home
                        <?php } else { ?>
                            Admin
                        <?php }
                        } else { ?>
                        Home
                        <?php }
                        ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-1 px-2" href="aboutus.php" id="aboutUs">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-1 px-2" href="contactus.php" id="contactUs">Contact Us</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-md-auto">
                <li class="nav-item">
                    <?php
                        if (!isset($_SESSION['hospital_id'])){
                    ?>
                        <div id="id_loginregister" style="display: block;">
                            <a class="nav-link mx-1 px-2" href="login_form.php" id="account">
                                <i class="fa fa-sign-in" aria-hidden="true"></i> Login/Sign Up
                            </a>
                        </div>
                    <?php	
                        } else {
                    ?>
                        <div id="id_logout" style="display: block;">
                            <a class="nav-link mx-1 px-2" href="../config/logout.php">
                                <i class="fa fa-sign-out" aria-hidden="true"></i> Log Out
                            </a>
                        </div>
                    <?php
                        }
                    ?>                       
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- <script>
    //Show Logout, Hide Register
    let show_logout = "<?php //echo $show_logout ?>";
    if (show_logout === "show") {
        document.getElementById('id_logout').style.display = "block";
        document.getElementById('id_loginregister').style.display = "none";
    } else {
        document.getElementById('id_logout').style.display = "none";
        document.getElementById('id_loginregister').style.display = "block";
    }

</script> -->