<!-- Prototype tester for Mobile Application -->

<?php
    include('header.php');
    require '../config/functions.php';
?>

<body>
    <?php include('navbar.php'); ?>
    <!-- main body -->
    <main>
        <!-- Mobile Tester -->
        <section class="container-fluid d-flex justify-content-center">
            <div class="jumbotron mobile-tester" >
                <h1 class="mobile-title">Mobile Tester</h1>
                <br/>

                <!-- Alert Button -->
                <button class="round-button alert-button" >TAP</button>

            </div>
        </section>
        <!-- /Mobile Tester -->
    </main>
    <!-- End of Main Body -->

    <?php include('footer.php'); ?>

    <script>
        document.getElementById("home").style.color="rgba(42, 89, 213, 1)";
    </script>

</body>

</html>