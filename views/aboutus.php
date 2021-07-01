<?php
    include('header.php');
    include('navbar.php');

    $mysqli = new mysqli('localhost', 'root', '','request') or die(mysqli_error($mysqli));
    $result = $mysqli->query("SELECT * FROM products") or die($mysqli->error);
?>

<!-- main body -->
<main>
    <!-- About Us Page -->
    <section class="container-fluid">
        <div class="general-container">
            <div class="about-container mb-5">
                <h1 class="about-title">About Us</h1>
                <br />
                <div class="about-content">
                    <p>
                        Welcome to NearER, your helper in finding the nearest hospital in your area. We're dedicated to giving you the very best of your medical attention, with a focus on world-class service.<br/>
                    </p>
                    <p>
                        Founded in 2021 by Nearer Inc., NearER has come a long way from its beginnings in the Technological University of the Philippines. When NearER first started out, their passion for providing medical support to patients drove them to provide better services by contacting hospitals and we're able to turn our passion into our own application. <br/>
                    </p>
                    <p>
                        We hope you enjoy our services as much as we enjoy offering them to you. If you have any questions or comments, please don't hesitate to contact us.<br/>
                    </p>
                    <p>Sincerely,<br/>NearER Inc.</p>
                </div>
            </div>

            <hr class="short-line mx-auto"/>

            <div class="certificate-container my-5 mx-auto">
                <h1 class="about-title">Certificates</h1>
                <br />
                <div class="row mx-auto d-flex justify-content-center">
                    <div class="mx-auto mb-3">
                        <img src="../images/certif.png" class="certificate mx-auto" alt="DTI Permit" />
                        <br/>
                        <h5 class="certif-title">DTI Permit</h5>
                    </div>
                    <div class="mx-auto mb-3">
                        <img src="../images/doh-fda.jpg" class="certificate mx-auto" alt="DOH FDA" />
                        <br/>
                        <h5 class="certif-title">DOH-FDA Permit</h5>
                    </div>
                </div>
            </div>

            <hr class="short-line mx-auto"/>

            <div class="members-container my-5">
                <h1 class="about-title">Meet the Team</h1>
                <div class="row mx-auto d-flex justify-content-center">
                    <div class="col-md-3 col-sm-6 my-3">
                        <div class="round-image-container mx-auto d-flex justify-content-center">
                            <img src="../images/members/ascano.png" class="round-image" />
                        </div>
                        <p class="member my-2">Christian Ascaño</p>
                    </div>
                    <div class="col-md-3 col-sm-6 my-3">
                        <div class="round-image-container mx-auto d-flex justify-content-center">
                            <img src="../images/members/ilarina.jpg" class="round-image" />
                        </div>
                        <p class="member my-2">Rachel Ilarina</p>
                    </div>
                    <div class="col-md-3 col-sm-6 my-3">
                        <div class="round-image-container mx-auto d-flex justify-content-center">
                            <img src="../images/members/alonzo.png" class="round-image" />
                        </div>
                        <p class="member my-2">Alonzo Ramos</p>
                    </div>
                    <div class="col-md-3 col-sm-6 my-3">
                        <div class="round-image-container mx-auto d-flex justify-content-center">
                            <img src="../images/members/julius.png" class="round-image" />
                        </div>
                        <p class="member my-2">Julius Villa</p>
                    </div>
                </div>
            </div>
        </div>
    <!-- /About Us Page -->
</main>
<!-- End of Main Body -->


<?php include('footer.php'); ?>

<script>
    document.getElementById("aboutUs").style.color="rgba(42, 89, 213, 1)";
</script>