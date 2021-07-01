<?php

    require '../config/functions.php';

    // Check if user already logged in
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === 'ADMIN') {
            header("location: admin_site.php");
        } else {
            header("location: home.php");
        }
        exit;
    }

    include('header.php');
    include('navbar.php');

?>

<!-- main body -->
<main>
    <!-- Sign Up Form -->
    <section class="container-fluid d-flex justify-content-center">
        <div class="signup-form ">
            <h1 class="account-title">SIGN UP</h1>
            <hr />
            <form action="register.php" method="post">
                <div class="row">
                    <div class="col-md-6 px-4">
                        <h4>LOGIN INFORMATION</h4>
                        <hr />
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label for="signup-username" class="signup-label">Username</label>
                            <input id="signup-username" name="user_username" type="text" placeholder="Enter your Username" value="<?php echo $user_username; ?>" pattern="[a-zA-Z0-9_]{1,}" title="A-Z, a-z, 0-9, _ are only allowed" />
                            <span class="help-block text-danger"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label for="signup-email" class="signup-label">Email Address</label><br>
                            <input id="signup-email" name="user_email" type="email" placeholder="Enter your Email Address" value="<?php echo $user_email; ?>" />
                            <span class="help-block text-danger"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label for="signup-password" class="signup-label">Password</label>
                            <input id="signup-password" name="user_password" type="password" placeholder="Enter your Password" value="<?php echo $user_password; ?>" />
                            <span class=" help-block text-danger"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <input id="signup-re-password" name="confirm_password" type="password" placeholder="Re-type your Password" value="<?php echo $confirm_password; ?>" />
                            <span class="help-block text-danger"><?php echo $confirm_password_err; ?></span>
                        </div>
                    </div>

                    <div class="col-md-6 px-4">
                        <h4>PERSONAL INFORMATION</h4>
                        <hr />
                        <div class="form-group <?php echo (!empty($firstName_err)) ? 'has-error' : ''; ?>">
                            <label for="signup-fname" class="signup-label">First Name</label><br>
                            <input id="signup-fname" name="user_fname" type="text" placeholder="Enter your First Name" value="<?php echo $user_fname; ?>" pattern="[a-zA-Z]{1,}" title="First name only." />
                            <span class="help-block text-danger"><?php echo $firstName_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($middleName_err)) ? 'has-error' : ''; ?>">
                            <label for="signup-name" class="signup-label">Middle Name (optional)</label><br>
                            <input id="signup-mname" name="user_mname" type="text" placeholder="Enter your Middle Name" value="<?php echo $user_mname; ?>" pattern="[a-zA-Z]{1,}" title="Middle Name only" />
                            <span class=" help-block text-danger"><?php echo $middleName_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($lastName_err)) ? 'has-error' : ''; ?>">
                            <label for="signup-lname" class="signup-label">Last Name</label><br>
                            <input id="signup-lname" name="user_lname" type="text" placeholder="Enter your Last Name" value="<?php echo $user_lname; ?>" pattern="[a-z A-Z]{1,}" title="Last name only" />
                            <span class="help-block text-danger"><?php echo $lastName_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label for="signup-address" class="signup-label">Address</label><br>
                            <input id="signup-address" name="user_address" type="text" placeholder="Enter your Address" value="<?php echo $user_address; ?>" />
                            <span class="help-block text-danger"><?php echo $address_err; ?></span>
					    </div>
                        <div class="form-group <?php echo (!empty($contact_err)) ? 'has-error' : ''; ?>">
                            <label for="signup-contact" class="signup-label">Contact Number</label><br>
                            <input id="signup-contact" name="user_contactno" type="tel" placeholder="09*********" value="<?php echo $user_contactno; ?>" pattern="[0]{1}[9]{1}[0-9]{9}" title="09********* (11-digits)" />
                            <span class="help-block text-danger"><?php echo $contact_err; ?></span>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group <?php echo (!empty($bdate_err)) ? 'has-error' : ''; ?>">
                                    <label for="signup-bdate" class="signup-label">Birth Date</label><br>
                                    <input id="signup-bdate" name="user_birthdate" type="date" value="<?php echo $user_birthdate; ?>" />
                                </div>
                                <span class="help-block text-danger"><?php echo $bdate_err; ?></span>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-group <?php echo (!empty($sex_err)) ? 'has-error' : ''; ?>">
                                    <label for="signup-gender" class="signup-label">Sex</label><br>
                                    <form class="gender-form">
                                        <input id="signup-gender-male" name="user_sex" class="radio-button" type="radio" value=1 <?php echo $sex_male_check; ?> />
                                        <label for="signup-gender-male">Male &nbsp;</label>
                                        <input id="signup-gender-female" name="user_sex" class="radio-button" type="radio" value=2 <?php echo $sex_female_check; ?> />
                                        <label for="signup-gender-female">Female</label>
                                    </form>
                                    <br><span class="help-block text-danger"><?php echo $sex_err; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 px-4">
                        <h4>MEDICAL INFORMATION</h4>
                        <hr />
                        <div class="row medical-information">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="medical-conditions" class="signup-label">MEDICAL CONDITIONS</label><br>
                                <form class="medical-conditions">
                                    <input id="med-diabetes" name="medcon_diabetes" class="check-box" type="checkbox" value=1 <?php echo $med_diabetes_check; ?> />
                                    <label for="med-diabetes">Diabetes</label>
                                    <br/>
                                    <input id="med-heart-disease" name="medcon_heart_disease" class="check-box" type="checkbox" value=2 <?php echo $med_heart_disease_check; ?> />
                                    <label for="med-heart-disease">Heart Disease</label>
                                    <br/>
                                    <input id="med-heart-failure" name="medcon_heart_failure" class="check-box" type="checkbox" value=3 <?php echo $med_heart_failure_check; ?> />
                                    <label for="med-heart-failure">Heart Failure</label>
                                    <br/>
                                    <input id="med-stroke" name="medcon_stroke" class="check-box" type="checkbox" value=4 <?php echo $med_stroke_check; ?> />
                                    <label for="med-stroke">Stroke</label>
                                    <br/>
                                    <input id="med-asthma" name="medcon_asthma" class="check-box" type="checkbox" value=5 <?php echo $med_asthma_check; ?> />
                                    <label for="med-asthma">Asthma</label>
                                    <br/>
                                    <input id="med-COPD" name="medcon_COPD" class="check-box" type="checkbox" value=6 <?php echo $med_COPD_check; ?> />
                                    <label for="med-COPD">COPD</label>
                                    <br/>
                                    <input id="med-arthritis" name="medcon_arthritis" class="check-box" type="checkbox" value=7 <?php echo $med_arthritis_check; ?> />
                                    <label for="med-arthritis">Arthritis</label>
                                    <br/>
                                    <label for="med-cancer">Cancer:</label><br/>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input id="med-cancer" name="medcon_cancer" class="check-box" type="checkbox" value=8 <?php echo $med_cancer_check; ?> />
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="medcon_cancer_name" placeholder="Cancer" >
                                    </div>
                                    <br/>
                                    <input id="med-high-bp" name="medcon_hbp" class="check-box" type="checkbox" value=9 <?php echo $med_hbp_check; ?> />
                                    <label for="med-high-bp">High Blood Pressure</label>
                                    <br/>
                                    <input id="med-alzheimer" name="medcon_alzheimers" class="check-box" type="checkbox" value=10 <?php echo $med_alzheimers_check; ?> />
                                    <label for="med-alzheimer">Alzheimer's Disease/Dementia</label>
                                    <br/>
                                    <label for="med-others">Others:</label><br/>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input id="med-others" name="medcon_others" class="check-box" type="checkbox" value=11 <?php echo $med_others_check; ?> />
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="medcon_others_name" placeholder="Please indicate">
                                    </div>
                                </form>
                            </div>

                            <div class="form-group col-md-6 col-sm-12">
                                <label for="allergies" class="signup-label">ALLERGIES</label><br>
                                <form class="allergies">
                                <label for="allergy-food">Food (Separate with a comma if multiple):</label><br/>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input id="allergy-food" name="allergy_food" class="check-box" type="checkbox" value=1 <?php echo $allergy_food_check; ?> />
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="allergy_food_name" placeholder="Food Allergy">
                                    </div>

                                    <label for="allergy-medication">Medication (Separate with a comma if multiple):</label><br/>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input id="allergy-medication" name="allergy_medication" class="check-box" type="checkbox" value=2 <?php echo $allergy_medication_check; ?> />
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="allergy_medication_name" placeholder="Medication Allergy">
                                    </div>

                                    <label for="allergy-environmental">Environmental (Separate with a comma if multiple):</label><br/>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input id="allergy-environmental" name="allergy_environmental" class="check-box" type="checkbox" value=3 <?php echo $allergy_environmental_check; ?> />
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="allergy_environmental_name" placeholder="Environmental Allergy">
                                    </div>
                                </form>

                                <hr/>

                                <label for="surgeries" class="signup-label">SURGERIES</label><br>
                                <form class="surgeries">
                                    <div class="form-group">
                                        <label for="surgery-name" class="signup-label">Surgery</label><br>
                                        <input id="surgery-name" name="surgery_name" type="text" placeholder="Enter Surgery Detail" value="<?php echo $surgery_name; ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="surgery_date" class="signup-label">Birth Date</label><br>
                                        <input id="surgery_date" name="surgery_date" type="date" value="<?php echo $surgery_date; ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="surgery_hospital" class="signup-label">Hospital</label><br>
                                        <input id="surgery_hospital" name="surgery_hospital" type="text" placeholder="Enter Hospital Name" value="<?php echo $surgery_hospital; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr />
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <div class="<?php echo (!empty($terms_err)) ? 'has-error' : ''; ?>">
                                    <div class=signup-confirmation>
                                        <div class="form-check form-check-inline custom-form-check">
                                            <input id="form-check signup-checkbox" name="terms" class="check-box" type="checkbox" <?php echo $terms_check; ?>>
                                            <label for="form-check signup-checkbox" class="confirmation-label">I have read and agree to the <a data-toggle="modal" data-target="#tncModal"><u>Terms and Conditions</u></a> of NearER.</label>
                                        </div>
                                    </div>
                                    <span class="help-block text-danger"><?php echo $terms_err; ?></span>
                                </div>
                            </div>
                            <div class="col-md-2 my-2">
                                <a href="home.php" class="btn btn-outline btn-lg custom-cancel">CANCEL</a>
                            </div>
                            <div class="col-md-2 my-2">
                                <input name="register_button" type="submit" value="SIGN UP" class="btn btn-lg custom-signup">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /Sign Up Form -->
</main>
<!-- End of Main Body -->

<?php
    include('termsandconditions.php');
    include('footer.php');
?>

<script>
    document.getElementById("account").style.color="rgba(42, 89, 213, 1)";
</script>