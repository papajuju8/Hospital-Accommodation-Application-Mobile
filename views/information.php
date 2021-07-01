<?php
    include('header.php');
    include('navbar.php');
?>

<!-- main body -->
<main>
    <!-- Personal Information -->
    <section class="container-fluid information-container">
        <h3 class="info-title">Personal Information</h3>
        <hr/>
        <div class="row px-5 mb-4">
            <div class="col-md-6">
                <div class="row">
                    <p class="personal-info-label">Surname: </p><p class="personal-info-p" id="userSurname">Surname</p>
                </div>
                <div class="row">
                    <p class="personal-info-label">Given Name: </p><p class="personal-info-p" id="userGivenName">Given Name</p>
                </div>
                <div class="row">
                    <p class="personal-info-label">Middle Initial: </p><p class="personal-info-p" id="userMI">MI</p>
                </div>
                <div class="row">
                    <p class="personal-info-label">Address: </p><p class="personal-info-p" id="userAddress">Complete Address goes here...</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <p class="personal-info-label">Sex: </p><p class="personal-info-p" id="userSex">FeMale</p>
                </div>
                <div class="row">
                    <p class="personal-info-label">Birthdate: </p><p class="personal-info-p" id="userBirthdate">00/00/00</p>
                </div>
                <div class="row">
                    <p class="personal-info-label">Age: </p><p class="personal-info-p" id="userAge">00</p>
                </div>
                <div class="row">
                    <p class="personal-info-label">Contact No.: </p><p class="personal-info-p" id="userContact">09*********</p>
                </div>
            </div>
        </div>

        <h3 class="info-title mt-5">Medical Information</h3>
        <hr/>
        <div class="row px-3 mb-4">
            <!-- Medical Conditions -->
            <div class="col-6 mb-5">
                <h4 class="medical-con-title">Medical Conditions</h4>
                <hr/>
                <div class="row px-3">
                    <div class="col-md-6">
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Diabetes</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Heart Disease</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Heart Failure</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Stroke</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Asthma</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >COPD</label>
                        </div> <br/>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Arthritis</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Cancer: ________</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >High Blood Pressure</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Alzheimer's Disease/Dementia</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Others: _______</label>
                        </div> <br/>
                    </div>
                </div>
            </div>
            <!-- /Medical Conditions -->

            <!-- Allergies -->
            <div class="col-6 mb-4">
                <h4>Allergies</h4>
                <hr/>
                <div class="row px-3">
                    <div class="col-6">
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Food: _______</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Medication: _______</label>
                        </div> <br/>
                        <div class="form-check form-check-inline medic-info-check">
                            <input id="form-check medic-con-checkbox" name="terms" class="check-box" type="checkbox" onclick="return false;" checked>
                            <label for="form-check" >Environmental: _______</label>
                        </div> <br/>
                    </div>
                </div>
            </div>
            <!-- /Allergies -->

            <!-- Surgeries -->
            <div class="col-12 mb-4">
                <h4>Surgeries</h4>
                <hr/>
                <div class="row d-flex justify-content-center px-3 mb-3">
                <table class="table table-hover custom-table-hospital-accommodation">
                        <thead>
                            <tr>
                                <th scope="col">Surgery</th>
                                <th scope="col">Date</th>
                                <th scope="col">Hospital</th>
                            </tr>
                        </thead>
                        <!-- Table Content -->
                        <tbody>
                            <tr>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Surgeries -->
        </div>
        
    </section>
    <!-- /Personal Information -->
</main>
<!-- End of Main Body -->

<?php include('footer.php'); ?>