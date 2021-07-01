<?php
    include('header.php');
    include('navbar.php');
?>

<!-- main body -->
<main>
    <!-- About Us Page -->
    <section class="container-fluid">
        <div class="general-container">
            <div class="about-container mb-5">
                <h1 class="about-title">Contact Us</h1>
                <br />
                <div class="contact-content">
                    <p><span class="contact-subtitle">Email:</span> nearer@example.com.ph</p>
                    <p><span class="contact-subtitle">Contact No.:</span> 09123456789</p>
                </div>
            </div>

            <hr class="short-line mx-auto"/>

            <div class="contact-container my-5">
                <h1 class="about-title">Issues and Concerns</h1>
                <br />
                <form action="contact.php" method="post">
                    <div class="contact-form">
                        <h4>Subject</h4>
                        <div class="form-group pb-4">
                            <input id="issue-subject" name="issueSubject" type="text" required/>
                        </div>

                        <h4>Description</h4>
                        <div class="form-group pb-4">
                            <textarea id="issue-description" name="desc" type="text" rows="8" required></textarea>
                        </div>
                    </div>
                    <div class="row repair-form d-flex justify-content-end px-3">
                        <a href="home.php" class="btn btn-lg custom-cancel mx-4">Cancel</a>
                        <input name="submit_button" type="submit" value="Submit" class="btn btn-lg custom-submit">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /About Us Page -->
</main>
<!-- End of Main Body -->


<?php include('footer.php'); ?>

<script>
    document.getElementById("contactUs").style.color="rgba(42, 89, 213, 1)";
</script>