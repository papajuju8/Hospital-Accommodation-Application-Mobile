<?php
    include('header.php');
    include('navbar.php');
?>

<!-- main body -->
<main>
    <!-- Table -->
    <section class="container-fluid">
        <h1 class="table-title">Hospital Accommodation</h1> <br/>
        <div class="general-container d-flex justify-content-center">
            <div class="row">
                <table class="table table-hover custom-table-hospital-accommodation">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time Requested</th>
                            <th scope="col">Time Responded</th>
                            <th scope="col">Status</th>
                            <th scope="col">Personnel in Charge</th>
                        </tr>
                    </thead>
                    <!-- Table Content -->
                    <tbody>
                        <tr>
                            <th scope="row">3</th>
                            <td><a href="information.php" target="_blank">Alonzo Ramos</a></td>
                            <td>Valenzuela City</td>
                            <td>4/25/21</td>
                            <td>23:42</td>
                            <td>23:43</td>
                            <td id="accept-reject">
                                <button class="btn btn-success btn-accept" onclick="acceptFunction()">Accept</button>
                                <button class="btn btn-danger btn-reject" onclick="rejectFunction()">Reject</button>
                            </td>
                            <td>Nurse Choi</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td><a href="information.php" target="_blank">Rachel Ilarina</a></td>
                            <td>Malabon City</td>
                            <td>4/24/21</td>
                            <td>12:18</td>
                            <td>12:19</td>
                            <td>Rejected</td>
                            <td>Nurse Choi</td>
                        </tr>
                        <tr>
                        <th scope="row">1</th>
                        <td><a href="information.php" target="_blank">Christian Jay Ascaño</a></td>
                            <td>Cavite</td>
                            <td>4/23/21</td>
                            <td>03:21</td>
                            <td>03:21</td>
                            <td>Accepted</td>
                            <td>Nurse Choi</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- /Table -->
</main>
<!-- End of Main Body -->

<?php include('footer.php'); ?>