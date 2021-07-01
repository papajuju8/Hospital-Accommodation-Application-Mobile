<?php
// Session already started at home.php

// Include config
require_once "config.php";

// Login variables
$email_login = $password_login = "";
$email_err_login = $password_err_login = "";
$email_login = "";
$show = $show_logout = "";

// Register variables
$user_username = $user_password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$user_email = $email_err = "";
$user_fname = $user_mname = $user_lname = "";
$firstName_err = $middleName_err = $lastName_err = "";
$user_address = $address_err = "";
$user_contactno = $contact_err = "";
$user_birthdate = $bdate_err = "";
$user_sex = $sex_err = $sex_male_check = $sex_female_check = "";
$terms_err = $terms_check = "";
$medcon_diabetes = $med_diabetes_check = "";
$medcon_heart_disease = $med_heart_disease_check = "";
$medcon_heart_failure = $med_heart_failure_check = "";
$medcon_stroke = $med_stroke_check = "";
$medcon_asthma = $med_asthma_check = "";
$medcon_copd = $med_COPD_check = "";
$medcon_arthritis = $med_arthritis_check = "";
$medcon_cancer = $med_cancer_check = "";
$medcon_cancer_name = $med_cancer_err = "";
$medcon_hbp = $med_hbp_check = "";
$medcon_alzheimers = $med_alzheimers_check = "";
$medcon_others = $med_others_check = "";
$medcon_others_name = $med_others_err = "";
$allergy_food = $allergy_food_check = "";
$allergy_food_name = "";
$allergy_medication = $allergy_medication_check = "";
$allergy_medication_name = "";
$allergy_environmental = $allergy_environmental_check = "";
$allergy_environmental_name = "";
$surgery_name = "";
$surgery_date = "";
$surgery_hospital = "";

// Forgot variables
$username_forgot = $username_err_forgot = "";
$email_forgot = $email_err_forgot = "";
$code_forgot = $code_err_forgot = "";
$password_forgot = $password_err_forgot = "";
$confirm_password_forgot = $confirm_password_err_forgot = "";
$verify_forgot = $verify_code = "";
$code = "";

// Process Login
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["login_button"]))) {

    // Check
    if (empty(trim($_POST["user_email"]))) {
        $show = "show";
        $email_err_login = "Please enter your email.";
    } else {
        $username_login = trim($_POST["user_username"]);
        $email_login = trim($_POST["user_email"]);
    }

    // Check
    if (empty(trim($_POST["user_password"]))) {
        $show = "show";
        $password_err_login = "Please enter your password.";
    } else {
        $password_login = trim($_POST["user_password"]);
    }

    // Validate
    if (empty($email_err_login) && empty($password_err_login)) {

        // SQL Select
        $sql_user_login = "SELECT user_ID, user_USERNAME, user_PASSWORD FROM users_profile WHERE user_USERNAME = ?";
        $sql_email_login = "SELECT user_ID, user_EMAIL, user_PASSWORD FROM users_profile WHERE user_EMAIL = ?";
        $stmt_user_login = mysqli_prepare($link, $sql_user_login);
        $stmt_email_login = mysqli_prepare($link, $sql_email_login);

        // Bind vars
        mysqli_stmt_bind_param($stmt_user_login, "s", $param_username_login);
        mysqli_stmt_bind_param($stmt_email_login, "s", $param_email_login);

        // Set params
        $param_username_login = $username_login;
        $param_email_login = $email_login;

        // Execute
        if (mysqli_stmt_execute($stmt_user_login)) {
            mysqli_stmt_store_result($stmt_user_login);

            // Check username/email
            if (mysqli_stmt_num_rows($stmt_user_login) == 1) {
                mysqli_stmt_bind_result($stmt_user_login, $id_login, $username_login, $hashed_password_login);
                if (mysqli_stmt_fetch($stmt_user_login)) {
                    if (password_verify($password_login, $hashed_password_login)) {

                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $id_login;
                        $_SESSION["user_email"] = $email_login;

                        // Check admin
                        $query_login = "SELECT * FROM users_profile WHERE user_EMAIL='$email_login' LIMIT 1";
                        $results_login = mysqli_query($link, $query_login);

                        $logged_in_user_login = mysqli_fetch_assoc($results_login);

                        date_default_timezone_set('Asia/Manila');
                        $dt = new DateTime();
                        $today = $dt->format('Y-m-d H:i:s');

                        // Admin
                        if ($logged_in_user_login['ADMIN'] == 'ADMIN') {
                            $_SESSION["user_type"] = $logged_in_user_login['ADMIN'];
                            if ($logged_in_user_login['ACTIVE'] == 0) {
                                $sql = "UPDATE users_profile SET ACTIVE = 1, MODIFIED_ON = '$today' WHERE user_EMAIL='$email_login'";
                                mysqli_query($link, $sql);
                                echo '<script type="text/javascript">alert("Account is Activated!"); window.location = "./admin_site.php"; </script>';
                            } else {
                                header("location: ./admin_site.php");
                            }
                        }
                        // User
                        else {
                            $_SESSION["user_type"] = $logged_in_user_login['ADMIN'];
                            if ($logged_in_user_login['ACTIVE'] == 0) {
                                $sql = "UPDATE users_profile SET ACTIVE = 1, MODIFIED_ON = '$today' WHERE user_EMAIL='$email_login'";
                                mysqli_query($link, $sql);
                                echo '<script type="text/javascript">alert("Account is Activated!"); window.location = "./home.php"; </script>';
                            } else {
                                header("location: ./home.php");
                            }
                        }
                    } else {
                        $show = "show";
                        $password_err_login = "The password you entered was invalid.";
                    }
                }
            }

            // Check email
            else if (mysqli_stmt_execute($stmt_email_login)) {
                mysqli_stmt_store_result($stmt_email_login);

                if (mysqli_stmt_num_rows($stmt_email_login) == 1) {
                    mysqli_stmt_bind_result($stmt_email_login, $id_login, $email_login, $hashed_password_login);
                    if (mysqli_stmt_fetch($stmt_email_login)) {
                        if (password_verify($password_login, $hashed_password_login)) {

                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id_login;
                            $_SESSION["user_email"] = $email_login;

                            // Check admin
                            $query_login = "SELECT * FROM users_profile WHERE user_EMAIL='$email_login' LIMIT 1";
                            $results_login = mysqli_query($link, $query_login);

                            $logged_in_user_login = mysqli_fetch_assoc($results_login);

                            date_default_timezone_set('Asia/Manila');
                            $dt = new DateTime();
                            $today = $dt->format('Y-m-d H:i:s');

                            // Admin
                            if ($logged_in_user_login['ADMIN'] == 'ADMIN') {
                                $_SESSION["user_type"] = $logged_in_user_login['ADMIN'];
                                if ($logged_in_user_login['ACTIVE'] == 0) {
                                    $sql = "UPDATE users_profile SET ACTIVE = 1, MODIFIED_ON = '$today' WHERE user_EMAIL='$email_login'";
                                    mysqli_query($link, $sql);
                                    echo '<script type="text/javascript">alert("Account is Activated!"); window.location = "./admin_site.php"; </script>';
                                } else {
                                    header("location: ./admin_site.php");
                                }
                            }
                            // User
                            else {
                                $_SESSION["user_type"] = $logged_in_user_login['ADMIN'];
                                if ($logged_in_user_login['ACTIVE'] == 0) {
                                    $sql = "UPDATE users_profile SET ACTIVE = 1, MODIFIED_ON = '$today' WHERE user_EMAIL='$email_login'";
                                    mysqli_query($link, $sql);
                                    echo '<script type="text/javascript">alert("Account is Activated!"); window.location = "./home.php"; </script>';
                                } else {
                                    header("location: ./home.php");
                                }
                            }
                        } else {
                            $show = "show";
                            $password_err_login = "The password you entered was invalid.";
                        }
                    }
                }
                // Account not found 
                else {
                    $show = "show";
                    $username_err_login = "The username and password that you entered did not matched our records.";
                }
            }
        } else {
            echo "Something went wrong. Please reload or try again later.";
        }

        mysqli_stmt_close($stmt_user_login);
        mysqli_stmt_close($stmt_email_login);
    }
}

// Process Register
else if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["register_button"]))) {

    // Validate username
    if (empty(trim($_POST["user_username"]))) {
        $username_err = "Please enter a username.";
    } else if (strlen(trim($_POST["user_username"])) < 4) {
        $username_err = "Username must have at least 4 characters.";
    } else {
        // SQL SELECT
        $sql = "SELECT user_ID FROM users_profile WHERE user_USERNAME = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind vars
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set params
            $param_username = trim($_POST["user_username"]);

            // Execute
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["user_username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Validate email
    if (empty(trim($_POST["user_email"]))) {
        $email_err = "Please enter your email.";
    } else {
        // SQL SELECT
        $sql = "SELECT user_ID FROM users_profile WHERE user_EMAIL = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind vars
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set params
            $param_email = trim($_POST["user_email"]);

            // Execute
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["user_email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["user_password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["user_password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["user_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate firstname
    if (empty(trim($_POST["user_fname"]))) {
        $firstName_err = "Please enter your first name.";
    } else {
        $firstName = ucfirst($_POST["user_fname"]);
    }

    // Validate m.i.
    if (empty(trim($_POST["user_mname"]))) {
    } else if (strlen(trim($_POST["user_mname"])) > 1) {
        $middleName_err = "Please enter your valid middle Name";
    } else {
        $middleName = ucfirst($_POST["user_mname"]);
    }

    // Validate lastname
    if (empty(trim($_POST["user_lname"]))) {
        $lastName_err = "Please enter your last name.";
    } else {
        $lastName = ucfirst($_POST["user_lname"]);
    }

    // Validate address
    if (empty(trim($_POST["user_address"]))) {
        $address_err = "Please enter your address.";
    } else {
        $user_address = $_POST["user_address"];
    }

    // Validate bdate
    if (empty($_POST["user_birthdate"])) {
        $bdate_err = "Please enter your birth date.";
    } else {
        $user_birthdate = $_POST["user_birthdate"];

        // Validate age
        $birthdate = new DateTime($user_birthdate);
        $today = new DateTime();
        $age = $birthdate->diff($today)->y;
        if ($age < 10) {
            $bdate_err = "User must be 10y/o and above.";
        } else if ($age > 100) {
            $bdate_err = "User must be still alive.";
        }
    }

    // Validate sex
    if (isset($_POST['user_sex'])) {
        $sex = $_POST['user_sex'];
        if ($sex == 1) {
            $sex_male_check = "checked";
        } else {
            $sex_female_check = "checked";
        }
    } else {
        $sex_err = "Please enter your sex.";
    }

    // Validate terms
    if (empty($_POST['terms'])) {
        $terms_err = "Please read and agree to our Terms & Conditions.";
    } else {
        $terms_check = "checked";
    }

    // Validate Contact
    if (empty(trim($_POST["user_contactno"]))) {
        $contact_err = "Please enter your contact number.";
    } else if (strlen(trim($_POST["user_contactno"])) == 11) {
        // SQL SELECT
        $sql = "SELECT user_ID FROM users_profile WHERE user_CONTACTNO = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind vars
            mysqli_stmt_bind_param($stmt, "s", $param_contact);

            // Set params
            $param_contact = trim($_POST["user_contactno"]);

            // Execute
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $contact_err = "This contact is already registered.";
                } else {
                    $contact = trim($_POST["user_contactno"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        $contact_err = "Please enter a valid 11-digit contact number.";
    }

    // Validate Medical Conditions
    if (isset($_POST['medcon_diabetes'])) {
        $diabetes = $_POST['medcon_diabetes'];
        if ($diabetes == 1) {
            $medcon_diabetes_checked = "checked";
        } else {
            $medcon_diabetes_checked = "disabled";
        }
    }

    if (isset($_POST['medcon_heart_disease'])) {
        $heartdisease = $_POST['medcon_heart_disease'];
        if ($heartdisease == 2) {
            $medcon_heart_disease_checked = "checked";
        } else {
            $medcon_heart_disease_checked = "disabled";
        }
    }

    if (isset($_POST['medcon_heart_failure'])) {
        $heartfailure = $_POST['medcon_heart_failure'];
        if ($heartfailure == 3) {
            $medcon_heart_failure_checked = "checked";
        } else {
            $medcon_heart_failure_checked = "disabled";
        }
    }

    if (isset($_POST['medcon_stroke'])) {
        $stroke = $_POST['medcon_stroke'];
        if ($stroke == 4) {
            $medcon_stroke_checked = "checked";
        } else {
            $medcon_stroke_checked = "disabled";
        }
    }

    if (isset($_POST['medcon_asthma'])) {
        $asthma = $_POST['medcon_asthma'];
        if ($asthma == 5) {
            $medcon_asthma_checked = "checked";
        } else {
            $medcon_asthma_checked = "disabled";
        }
    }

    if (isset($_POST['medcon_copd'])) {
        $copd = $_POST['medcon_copd'];
        if ($copd == 6) {
            $medcon_COPD_checked = "checked";
        } else {
            $medcon_COPD_checked = "disabled";
        }
    }

    if (isset($_POST['medcon_arthritis'])) {
        $arthritis = $_POST['medcon_arthritis'];
        if ($arthritis == 7) {
            $medcon_arthritis_checked = "checked";
        } else {
            $medcon_arthritis_checked = "disabled";
        }
    }

    if (isset($_POST['medcon_cancer'])) {
        $cancer = $_POST['medcon_cancer'];
        if ($cancer == 8) {
            $medcon_cancer_checked = "checked";
        } else {
            $medcon_cancer_checked = "disabled";
        }
    }

    if (empty(trim($_POST["medcon_cancer_name"]))) {
        $med_cancer_err = "Please indicate the type of cancer.";
    } else {
        $cancer_name = $_POST["medcon_cancer_name"];
    }

    if (isset($_POST['medcon_hbp'])) {
        $hbp = $_POST['medcon_hbp'];
        if ($hbp == 9) {
            $medcon_hbp_checked = "checked";
        } else {
            $medcon_hbp_checked = "disabled";
        }
    }

    if (isset($_POST['medcon_alzheimers'])) {
        $alzheimers = $_POST['medcon_alzheimers'];
        if ($alzheimers == 10) {
            $medcon_alzheimers_checked = "checked";
        } else {
            $medcon_alzheimers_checked = "disabled";
        }
    }

    if (isset($_POST['medcon_others'])) {
        $others = $_POST['medcon_others'];
        if ($others == 11) {
            $medcon_others_checked = "checked";
        } else {
            $medcon_others_checked = "disabled";
        }
    }

    if (empty(trim($_POST["medcon_others_name"]))) {
        $med_others_err = "Please indicate your sickness/disease.";
    } else {
        $others_name = $_POST["medcon_others_name"];
    }

    // Check errors
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($firstName_err) && empty($middleName_err) && empty($lastName_err) && empty($address_err) && empty($contact_err) && empty($bdate_err) && empty($sex_err) && empty($terms_err)) {

        // SQL INSERT
        $sql = "INSERT INTO users_profile (user_USERNAME, user_EMAIL, user_PASSWORD) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind vars
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);

            // Set params
            $param_username = $user_username;
            $param_email = $user_email;
            $param_password = password_hash($user_password, PASSWORD_DEFAULT); // Creates a password hash

            // Execute
            if (mysqli_stmt_execute($stmt)) {
                $query = "SELECT * FROM users_profile WHERE user_ID";
                $results = mysqli_query($link, $query);

                while ($row = mysqli_fetch_assoc($results)) {
                    if ($row["user_USERNAME"] === $param_username) {
                        $user_id = $row["user_ID"];
                    }
                }

                $sql2 = "INSERT INTO users_profile (user_ID, user_FNAME, user_MNAME, user_LNAME, user_CONTACTNO, user_SEX, user_BIRTHDATE, user_AGE) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt2 = mysqli_prepare($link, $sql2);
                mysqli_stmt_bind_param($stmt2, "issssisi", $param_user_id, $param_firstName, $param_lastName, $param_MN, $param_contact, $param_sex, $param_bdate, $param_age);
                $param_user_id = $user_id;
                $param_firstName = $user_fname;
                $param_MN = $user_mname;
                $param_lastName = $user_lname;
                $param_contact = $user_contactno;
                $param_sex = $user_sex;
                $param_bdate = $user_birthdate;
                $param_age = $user_age;
                mysqli_stmt_execute($stmt2);

                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["user_type"] = "USERS";

                echo '<script type="text/javascript">alert("Sign up Successful. Directing you to the home page."); window.location = "./home.php"; </script>';
            } else {
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
            mysqli_stmt_close($stmt2);
        }
    }
}

// // Edit Profile
// else if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["save_edit_button"]))) {

//     // Validate firstname
//     if (empty(trim($_POST["firstName"]))) {
//         $firstName_err = "Please enter your first name.";
//     } else {
//         $firstName = ucfirst($_POST["firstName"]);
//     }

//     // Validate m.i.
//     if (empty(trim($_POST["middleName"]))) {
//     } else if (strlen(trim($_POST["middleName"])) > 1) {
//         $middleName_err = "Please enter your valid middle initial";
//     } else {
//         $middleName = ucfirst($_POST["middleName"]);
//     }

//     // Validate lastname
//     if (empty(trim($_POST["lastName"]))) {
//         $lastName_err = "Please enter your last name.";
//     } else {
//         $lastName = ucfirst($_POST["lastName"]);
//     }

//     // Validate address
//     if (empty(trim($_POST["address"]))) {
//         $address_err = "Please enter your address.";
//     } else {
//         $address = $_POST["address"];
//     }

//     // Validate bdate
//     if (empty($_POST["bdate"])) {
//         $bdate_err = "Please enter your birth date.";
//     } else {
//         $bdate = $_POST["bdate"];

//         // Validate age
//         $birthdate = new DateTime($bdate);
//         $today = new DateTime();
//         $age = $birthdate->diff($today)->y;
//         if ($age < 10) {
//             $bdate_err = "User must be 10y/o and above.";
//         } else if ($age > 100) {
//             $bdate_err = "User must be still alive.";
//         }
//     }

//     // Validate sex
//     if (isset($_POST['sex'])) {
//         $sex = $_POST['sex'];
//     }

//     // Validate Contact
//     if (empty(trim($_POST["contact"]))) {
//     } else if (strlen(trim($_POST["contact"])) == 11) {
//         // SQL SELECT
//         $sql = "SELECT user_ID FROM users_profile WHERE CONTACT_NO = ?";

//         if ($stmt = mysqli_prepare($link, $sql)) {
//             // Bind vars
//             mysqli_stmt_bind_param($stmt, "s", $param_contact);

//             // Set params
//             $param_contact = trim($_POST["contact"]);

//             // Execute
//             if (mysqli_stmt_execute($stmt)) {
//                 mysqli_stmt_store_result($stmt);

//                 if (mysqli_stmt_num_rows($stmt) == 1) {
//                     $contact_err = "This contact is already registered.";
//                 } else {
//                     $contact = trim($_POST["contact"]);
//                 }
//             } else {
//                 echo "Oops! Something went wrong. Please try again later.";
//             }

//             mysqli_stmt_close($stmt);
//         }
//     } else {
//         $contact_err = "Please enter a valid 11-digit contact number.";
//     }

//     // Check errors
//     if (empty($firstName_err) && empty($middleName_err) && empty($lastName_err) && empty($address_err) && empty($contact_err) && empty($bdate_err)) {
//         date_default_timezone_set('Asia/Manila');
//         $dt = new DateTime();
//         $today = $dt->format('Y-m-d H:i:s');

//         if (empty(trim($_POST["contact"]))) {
//             $sql = "UPDATE users_profile SET FIRST_NAME = '$firstName', MI = '$middleName', LAST_NAME = '$lastName', ADDRESS = '$address', GENDER_ID = '$sex', AGE = '$age', BIRTHDATE = '$bdate', MODIFIED_ON = '$today' WHERE user_ID = ?";

//             if ($stmt_prof = mysqli_prepare($link, $sql)) {
//                 mysqli_stmt_bind_param($stmt_prof, "i", $param_id);

//                 // Set parameters
//                 $param_id = $_SESSION["user_id"];

//                 if (mysqli_stmt_execute($stmt_prof)) {
//                     header("location: ./profile.php");
//                 } else {
//                     echo "Oops! Something went wrong. Please try again later.";
//                 }
//             }
//         } else {
//             $sql = "UPDATE users_profile SET FIRST_NAME = '$firstName', MI = '$middleName', LAST_NAME = '$lastName', CONTACT_NO = '$contact', ADDRESS = '$address', GENDER_ID = '$sex', AGE = '$age', BIRTHDATE = '$bdate', MODIFIED_ON = '$today' WHERE user_ID = ?";

//             if ($stmt_prof = mysqli_prepare($link, $sql)) {
//                 mysqli_stmt_bind_param($stmt_prof, "i", $param_id);

//                 // Set parameters
//                 $param_id = $_SESSION["user_id"];

//                 if (mysqli_stmt_execute($stmt_prof)) {
//                     header("location: ./profile.php");
//                 } else {
//                     echo "Oops! Something went wrong. Please try again later.";
//                 }
//             }
//         }

//         // Close statement
//         mysqli_stmt_close($stmt_prof);
//     }
// }

// // Edit Account
// else if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["edit_account_button"]))) {

//     // Validate username
//     if (empty(trim($_POST["user_username"]))) {
//         //$username_err = "Please enter a username.";
//     } else if (strlen(trim($_POST["user_username"])) < 4) {
//         $username_err = "Username must have at least 4 characters.";
//     } else {
//         // SQL SELECT
//         $sql = "SELECT user_ID FROM users_profile WHERE user_USERNAME = ?";

//         if ($stmt = mysqli_prepare($link, $sql)) {
//             // Bind vars
//             mysqli_stmt_bind_param($stmt, "s", $param_username);

//             // Set params
//             $param_username = trim($_POST["user_username"]);

//             // Execute
//             if (mysqli_stmt_execute($stmt)) {
//                 mysqli_stmt_store_result($stmt);

//                 if (mysqli_stmt_num_rows($stmt) == 1) {
//                     $username_err = "This username is already taken.";
//                 } else {
//                     $username = trim($_POST["user_username"]);
//                 }
//             } else {
//                 echo "Oops! Something went wrong. Please try again later.";
//             }

//             mysqli_stmt_close($stmt);
//         }
//     }

//     // Validate email
//     if (empty(trim($_POST["user_email"]))) {
//         //$email_err = "Please enter your email.";
//     } else {
//         // SQL SELECT
//         $sql = "SELECT user_ID FROM users_profile WHERE user_EMAIL = ?";

//         if ($stmt = mysqli_prepare($link, $sql)) {
//             // Bind vars
//             mysqli_stmt_bind_param($stmt, "s", $param_email);

//             // Set params
//             $param_email = trim($_POST["user_email"]);

//             // Execute
//             if (mysqli_stmt_execute($stmt)) {
//                 mysqli_stmt_store_result($stmt);

//                 if (mysqli_stmt_num_rows($stmt) == 1) {
//                     $email_err = "This email is already registered.";
//                 } else {
//                     $email = trim($_POST["user_email"]);
//                 }
//             } else {
//                 echo "Oops! Something went wrong. Please try again later.";
//             }

//             mysqli_stmt_close($stmt);
//         }
//     }

//     // Validate password
//     if (empty(trim($_POST["user_password"]))) {
//         //$password_err = "Please enter a password.";
//     } elseif (strlen(trim($_POST["user_password"])) < 6) {
//         $password_err = "Password must have at least 6 characters.";
//     } else {
//         $password = trim($_POST["user_password"]);
//     }

//     // Validate confirm password
//     if (empty(trim($_POST["confirm_password"])) && !empty(trim($_POST["user_password"]))) {
//         $confirm_password_err = "Please confirm password.";
//     } else {
//         $confirm_password = trim($_POST["confirm_password"]);
//         if (empty($password_err) && ($user_password != $confirm_password)) {
//             $confirm_password_err = "Password did not match.";
//         }
//     }

//     // Check input errors
//     if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
//         date_default_timezone_set('Asia/Manila');
//         $dt = new DateTime();
//         $today = $dt->format('Y-m-d H:i:s');

//         // Prepare
//         if (empty($user_username) && empty($user_email) && empty($user_password)) {
//             header("location: ./profile.php");
//         } else if (empty($user_username) && !empty($user_email) && !empty($user_password)) {
//             $sql = "UPDATE users_profile SET user_EMAIL = '$user_email', VERIFIED = '0', MODIFIED_ON = '$today', user_PASSWORD = ? WHERE user_ID = ?";
//             if ($stmt_acc = mysqli_prepare($link, $sql)) {
//                 // Bind variables
//                 mysqli_stmt_bind_param($stmt_acc, "si", $param_password, $param_id);
//                 // Set parameters
//                 $param_password = password_hash($user_password, PASSWORD_DEFAULT);
//                 $param_id = $_SESSION["user_id"];
//                 if (mysqli_stmt_execute($stmt_acc)) {
//                     header("location: ./profile.php");
//                 } else {
//                     echo "Oops! Something went wrong. Please try again later.";
//                 }
//             }
//         } else if (empty($user_email) && !empty($user_username) && !empty($user_password)) {
//             $sql = "UPDATE users_profile SET user_USERNAME = '$user_username', MODIFIED_ON = '$today', user_PASSWORD = ? WHERE user_ID = ?";
//             if ($stmt_acc = mysqli_prepare($link, $sql)) {
//                 // Bind variables
//                 mysqli_stmt_bind_param($stmt_acc, "si", $param_password, $param_id);
//                 // Set parameters
//                 $param_password = password_hash($user_password, PASSWORD_DEFAULT);
//                 $param_id = $_SESSION["user_id"];
//                 if (mysqli_stmt_execute($stmt_acc)) {
//                     header("location: ./profile.php");
//                 } else {
//                     echo "Oops! Something went wrong. Please try again later.";
//                 }
//             }
//         } else if (empty($user_username) && empty($user_email) && !empty($user_password)) {
//             $sql = "UPDATE users_profile SET MODIFIED_ON = '$today', user_PASSWORD = ? WHERE user_ID = ?";
//             if ($stmt_acc = mysqli_prepare($link, $sql)) {
//                 // Bind variables
//                 mysqli_stmt_bind_param($stmt_acc, "si", $param_password, $param_id);
//                 // Set parameters
//                 $param_password = password_hash($user_password, PASSWORD_DEFAULT);
//                 $param_id = $_SESSION["user_id"];
//                 if (mysqli_stmt_execute($stmt_acc)) {
//                     header("location: ./profile.php");
//                 } else {
//                     echo "Oops! Something went wrong. Please try again later.";
//                 }
//             }
//         } else if (empty($user_username) && empty($user_password) && !empty($user_email)) {
//             $sql = "UPDATE users_profile SET user_EMAIL = '$user_email', VERIFIED = '0', MODIFIED_ON = '$today' WHERE user_ID = ?";
//             if ($stmt_acc = mysqli_prepare($link, $sql)) {
//                 // Bind variables
//                 mysqli_stmt_bind_param($stmt_acc, "i", $param_id);
//                 // Set parameters
//                 $param_id = $_SESSION["user_id"];
//                 if (mysqli_stmt_execute($stmt_acc)) {
//                     header("location: ./profile.php");
//                 } else {
//                     echo "Oops! Something went wrong. Please try again later.";
//                 }
//             }
//         } else if (empty($user_email) && empty($user_password) && !empty($user_username)) {
//             $sql = "UPDATE users_profile SET user_USERNAME = '$username', MODIFIED_ON = '$today' WHERE user_ID = ?";
//             if ($stmt_acc = mysqli_prepare($link, $sql)) {
//                 // Bind variables
//                 mysqli_stmt_bind_param($stmt_acc, "i", $param_id);
//                 // Set parameters
//                 $param_id = $_SESSION["user_id"];
//                 if (mysqli_stmt_execute($stmt_acc)) {
//                     header("location: ./profile.php");
//                 } else {
//                     echo "Oops! Something went wrong. Please try again later.";
//                 }
//             }
//         } else if (empty($user_password) && !empty($user_username) && !empty($user_email)) {
//             $sql = "UPDATE users_profile SET user_USERNAME = '$user_username', user_EMAIL = '$user_email', VERIFIED = '0', MODIFIED_ON = '$today' WHERE user_ID = ?";
//             if ($stmt_acc = mysqli_prepare($link, $sql)) {
//                 // Bind variables
//                 mysqli_stmt_bind_param($stmt_acc, "i", $param_id);
//                 // Set parameters
//                 $param_id = $_SESSION["user_id"];
//                 if (mysqli_stmt_execute($stmt_acc)) {
//                     header("location: ./profile.php");
//                 } else {
//                     echo "Oops! Something went wrong. Please try again later.";
//                 }
//             }
//         } else {
//             $sql = "UPDATE users_profile SET user_USERNAME = '$user_username', user_EMAIL = '$user_email', VERIFIED = '0', MODIFIED_ON = '$today', user_PASSWORD = ? WHERE user_ID = ?";
//             if ($stmt_acc = mysqli_prepare($link, $sql)) {
//                 // Bind variables
//                 mysqli_stmt_bind_param($stmt_acc, "si", $param_password, $param_id);
//                 // Set parameters
//                 $param_password = password_hash($user_password, PASSWORD_DEFAULT);
//                 $param_id = $_SESSION["user_id"];
//                 if (mysqli_stmt_execute($stmt_acc)) {
//                     header("location: ./profile.php");
//                 } else {
//                     echo "Oops! Something went wrong. Please try again later.";
//                 }
//             }
//         }

//         // Close statement
//         mysqli_stmt_close($stmt_acc);
//     }
// }

// // Process Verify Email
// else if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["verify_email_button"]))) {

//     // Check
//     $id = $_SESSION["user_id"];

//     // Check
//     $query_forgot = "SELECT * FROM users_profile WHERE user_ID = '$user_id' LIMIT 1";
//     $results_forgot = mysqli_query($link, $query_forgot);

//     $fetch_forgot = mysqli_fetch_assoc($results_forgot);

//     $email_forgot = $fetch_forgot['user_EMAIL'];

//     // Email
//     if ($fetch_forgot['VERIFIED'] == 0) {
//         $show_code = "show_code";

//         if (empty($_POST["code"])) {

//             // Check existing code
//             while ($code == "") {
//                 $temp_code = rand(600000, 800000);

//                 // SQL Select
//                 $sql_check = "SELECT * FROM users_profile WHERE VERIFY_CODE = '$temp_code'";
//                 $stmt_check = mysqli_prepare($link, $sql_check);

//                 // Execute
//                 mysqli_stmt_execute($stmt_check);
//                 mysqli_stmt_store_result($stmt_check);

//                 // Check code
//                 if (mysqli_stmt_num_rows($stmt_check) == 0) {
//                     $code = $temp_code;
//                 }

//                 mysqli_stmt_close($stmt_check);
//             }

//             include('email.php');
//             $verify_code = "Enter code sent to your email.";

//             // Insert code
//             $sql = "UPDATE users_profile SET VERIFY_CODE = '$code' WHERE user_ID = '$user_id'";
//             mysqli_query($link, $sql);
//         } else {
//             $code_forgot = trim($_POST["code"]);

//             // Check code
//             $query_code = "SELECT * FROM users_profile WHERE user_ID = '$user_id' LIMIT 1";
//             $results_code = mysqli_query($link, $query_code);

//             $code_check = mysqli_fetch_assoc($results_code);

//             if ($code_forgot === $code_check['VERIFY_CODE']) {
//                 date_default_timezone_set('Asia/Manila');
//                 $dt = new DateTime();
//                 $today = $dt->format('Y-m-d H:i:s');

//                 $sql = "UPDATE users_profile SET VERIFIED = '1', MODIFIED_ON = '$today' WHERE user_ID = '$user_id'";
//                 mysqli_query($link, $sql);

//                 echo '<script type="text/javascript">alert("Email is Verified! Directing you to the Profile Page."); window.location = "./profile.php"; </script>';

//                 $show_code = "reset";
//             } else {
//                 $code_err_forgot = "Code is invalid. Please enter the code again or clear the code input then submit to send a new code verification.";
//             }
//         }
//     } else {
//         $verify_forgot = "Email is already verified.";
//     }
// }

// // Process Forgot Password
// else if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["forgot_button"]))) {

//     // Check
//     if (empty(trim($_POST["user_username"]))) {
//         $username_err_forgot = "Please enter username.";
//     } else {
//         $username_forgot = trim($_POST["user_username"]);
//     }

//     // Check
//     if (empty(trim($_POST["user_email"]))) {
//         $email_err_forgot = "Please enter email.";
//     } else {
//         $email_forgot = trim($_POST["user_email"]);
//     }

//     // Validate
//     if (empty($username_err_forgot) && empty($email_err_forgot)) {

//         // SQL Select
//         $sql_forgot = "SELECT user_ID, user_USERNAME, user_EMAIL FROM users_profile WHERE user_USERNAME = ?";
//         $stmt_forgot = mysqli_prepare($link, $sql_forgot);

//         // Bind vars
//         mysqli_stmt_bind_param($stmt_forgot, "s", $param_username_forgot);

//         // Set params
//         $param_username_forgot = $username_forgot;

//         // Execute
//         if (mysqli_stmt_execute($stmt_forgot)) {
//             mysqli_stmt_store_result($stmt_forgot);

//             // Check username
//             if (mysqli_stmt_num_rows($stmt_forgot) == 1) {

//                 // Check
//                 $query_forgot = "SELECT * FROM users_profile WHERE user_USERNAME='$username_forgot' LIMIT 1";
//                 $results_forgot = mysqli_query($link, $query_forgot);

//                 $fetch_forgot = mysqli_fetch_assoc($results_forgot);

//                 // Email
//                 if ($fetch_forgot['user_EMAIL'] == $email_forgot) {
//                     $verify_forgot = "Username and Email matched.";
//                     $show_code = "show_code";

//                     if (empty($_POST["code"])) {

//                         // Check existing code
//                         while ($code == "") {
//                             $temp_code = rand(300000, 500000);

//                             // SQL Select
//                             $sql_check = "SELECT * FROM users_profile WHERE VERIFY_CODE = '$temp_code'";
//                             $stmt_check = mysqli_prepare($link, $sql_check);

//                             // Execute
//                             mysqli_stmt_execute($stmt_check);
//                             mysqli_stmt_store_result($stmt_check);

//                             // Check code
//                             if (mysqli_stmt_num_rows($stmt_check) == 0) {
//                                 $code = $temp_code;
//                             }

//                             mysqli_stmt_close($stmt_check);
//                         }

//                         include('email.php');
//                         $verify_code = "Enter code sent to your email.";

//                         // Insert code
//                         $sql = "UPDATE users_profile SET VERIFY_CODE = '$code' WHERE user_USERNAME = '$username_forgot'";
//                         mysqli_query($link, $sql);
//                     } else {
//                         $code_forgot = trim($_POST["code"]);

//                         // Check code
//                         $query_code = "SELECT * FROM users_profile WHERE user_USERNAME ='$username_forgot' LIMIT 1";
//                         $results_code = mysqli_query($link, $query_code);

//                         $code_check = mysqli_fetch_assoc($results_code);

//                         if ($code_forgot === $code_check['VERIFY_CODE']) {
//                             $show_code = "show_code2";
//                             $verify_code = "Code is verified.";

//                             // Validate password
//                             if (empty(trim($_POST["user_password"]))) {
//                                 $password_err_forgot = "Please enter a new password.";
//                             } elseif (strlen(trim($_POST["user_password"])) < 6) {
//                                 $show_code = "show_code3";
//                                 $password_err_forgot = "Password must have at least 6 characters.";
//                             } else {
//                                 $password_forgot = trim($_POST["user_password"]);
//                             }
//                             // Validate confirm password
//                             if (empty(trim($_POST["confirm_password"]))) {
//                                 $confirm_password_err_forgot = "Please confirm password.";
//                             } else {
//                                 $show_code = "show_code3";
//                                 $confirm_password_forgot = trim($_POST["confirm_password"]);
//                                 if (empty($password_err_forgot) && ($password_forgot != $confirm_password_forgot)) {
//                                     $confirm_password_err_forgot = "Password did not match.";
//                                 }
//                             }

//                             // Set new password
//                             if (empty($password_err_forgot) && empty($confirm_password_err_forgot)) {
//                                 date_default_timezone_set('Asia/Manila');
//                                 $dt = new DateTime();
//                                 $today = $dt->format('Y-m-d H:i:s');

//                                 $sql_reset = "UPDATE users_profile SET user_PASSWORD = ?, MODIFIED_ON = '$today' WHERE user_USERNAME = '$username_forgot'";

//                                 if ($stmt = mysqli_prepare($link, $sql_reset)) {
//                                     mysqli_stmt_bind_param($stmt, "s", $param_password);

//                                     $param_password = password_hash($password_forgot, PASSWORD_DEFAULT);

//                                     if (mysqli_stmt_execute($stmt)) {

//                                         // Password updated successful
//                                         echo '<script type="text/javascript">alert("Password reset is successful. Please login to continue."); </script>';

//                                         $show_code = "reset";
//                                     } else {
//                                         echo "Something went wrong. Please try again later.";
//                                     }

//                                     // Close statement
//                                     mysqli_stmt_close($stmt);
//                                 }
//                             }
//                         } else {
//                             $code_err_forgot = "Code is invalid. Please enter the code again or clear the code input then submit to send a new code verification.";
//                         }
//                     }
//                 }
//                 // User
//                 else {
//                     $username_err_forgot = "Username and Email doesn't match or exist.";
//                 }
//             } else {
//                 $username_err_forgot = "Username and Email doesn't match or exist.";
//             }
//         } else {
//             echo "Something went wrong. Please reload or try again later.";
//         }

//         mysqli_stmt_close($stmt_forgot);
//     }
// }

// // View Movie
// else if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["view_movie"]))) {
//     $_SESSION["movie_id"] = $_POST["view_id"];
//     header("location: movie_profile.php");
// }

// // Search Direct
// else if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["search_button"]))) {
//     $temp_search = trim($_POST["search_title"]);
//     $test_search = substr($temp_search, -4);
//     if (is_numeric($test_search) == 1) {
//         $temp_search = substr($temp_search, 0, -4);
//     }
//     $temp_word = $temp_search;
//     $temp_search = strtoupper($temp_search);
//     $sql = "SELECT * FROM movies WHERE MOVIE_TITLE LIKE '%$temp_search%'";
//     $res = mysqli_query($link,  $sql);
//     if (mysqli_num_rows($res) > 0) {
//         while ($row = mysqli_fetch_assoc($res)) {
//             $temp_row = trim($row['MOVIE_TITLE']);
//             $temp_row = strtoupper($temp_row);
//             if ($temp_search == $temp_row) {
//                 $_SESSION["movie_id"] = $row['MOVIE_ID'];
//             } else {
//                 $_SESSION["movie_id"] = $temp_word;
//             }
//         }
//     } else {
//         $_SESSION["movie_id"] = 0;
//     }
//     header("location: movie_profile.php");
// }

// // Search
// if (isset($_REQUEST["search_term"])) {
//     $search = $_REQUEST["search_term"];
//     $sql = "SELECT * FROM movies WHERE MOVIE_TITLE LIKE '%$search%' LIMIT 5";
//     if ($stmt = mysqli_prepare($link, $sql)) {
//         if (mysqli_stmt_execute($stmt)) {
//             $result = mysqli_stmt_get_result($stmt);
//             if (mysqli_num_rows($result) > 0) {
//                 while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//                     $date = substr($row['PREMIERE_DATE'], 0, 4);
//                     echo '<p class="row"><img src="../images/movies/poster/' . $row['POSTER'] . '" style="width: 45px; margin-right:0px;"> ';
//                     echo '<span class="pt-0 col-8">' . $row["MOVIE_TITLE"] . '<br><span class="text-secondary">' . $date . '</span></span></p>';
//                 }
//             } else {
//                 echo "<p>No matches found</p>";
//             }
//         } else {
//             echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
//         }
//     }
//     mysqli_stmt_close($stmt);
// }
