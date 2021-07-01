<?php 

    if (isset($_POST['register_button'])) {
        
        $username = $_POST['user_username'];
        $email = $_POST['user_email'];
        $pass = $_POST['user_password'];

        $fname = $_POST['user_fname'];
        $mname = $_POST['user_mname'];
        $lname = $_POST['user_lname'];

        $contact = $_POST['user_contactno'];
        $address = $_POST['user_address'];
        $bday = $_POST['user_birthdate'];
        $sex = $_POST['user_sex'];
        // $datetoday = $_POST['created_on'];

        $diabetes = $_POST['medcon_diabetes'];
        $heartdisease = $_POST['medcon_heart_disease'];
        $heartfailure = $_POST['medcon_heart_failure'];
        $stroke = $_POST['medcon_stroke'];
        $asthma = $_POST['medcon_asthma'];
        $copd = $_POST['medcon_copd'];
        $arthritis = $_POST['medcon_arthritis'];
        $cancer = $_POST['medcon_cancer'];
        $cancername = $_POST['medcon_cancer_name'];
        $hbp = $_POST['medcon_hbp'];
        $alzheimers = $_POST['medcon_alzheimers'];
        $others = $_POST['medcon_others'];
        $othersname = $_POST['medcon_others_name'];

        $food = $_POST['allergy_food'];
        $foodname = $_POST['allergy_food_name'];
        $medication = $_POST['allergy_medication'];
        $medicationname = $_POST['allergy_medication_name'];
        $environmental = $_POST['allergy_environmental'];
        $environmentalname = $_POST['allergy_environmental_name'];

        $surgeryname = $_POST['surgery_name'];
        $surgerydate = $_POST['surgery_date'];
        $surgeryhospital = $_POST['surgery_hospital'];

        // date_default_timezone_set("Asia/Manila");
        // $date = date("Y-m-d h:i:sa");

        $mysqli = new mysqli('localhost', 'root', '','nearer') or die(mysqli_error($mysqli));

        $mysqli->query("INSERT INTO users_profile (USER_USERNAME, USER_EMAIL, USER_PASSWORD, USER_FNAME, USER_MNAME, USER_LNAME, USER_ADDRESS, USER_CONTACTNO, USER_BIRTHDATE,
                        USER_SEX, MEDCON_DIABETES, MEDCON_HEART_DISEASE, MEDCON_HEART_FAILURE, MEDCON_STROKE, MEDCON_ASTHMA, MEDCON_COPD, MEDCON_ARTHRITIS, 
                        MEDCON_CANCER, MEDCON_CANCER_NAME, MEDCON_HBP, MEDCON_ALZHEIMERS, MEDCON_OTHERS, MEDCON_OTHERS_NAME, ALLERGY_FOOD, ALLERGY_FOOD_NAME, ALLERGY_MEDICATION,
                        ALLERGY_MEDICATION_NAME, ALLERGY_ENVIRONMENTAL, ALLERGY_ENVIRONMENTAL_NAME, SURGERY_NAME, SURGERY_DATE, SURGERY_HOSPITAL)
                        VALUES('$username','$email','$pass','$fname','$mname','$lname','$address','$contact','$bday','$sex','$diabetes','$heartdisease','$heartfailure',
                        '$stroke','$asthma','$copd','$arthritis','$cancer','$cancername','$hbp','$alzheimers','$others','$othersname','$food','$foodname','$medication','$medicationname',
                        '$environmental','$environmentalname','$surgeryname','$surgerydate','$surgeryhospital') ")
                         or die($mysqli->error);
                         echo "<script> alert('User Registered!'); window.location = 'login_form.php' </script>";

    }

?>