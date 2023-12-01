<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";     
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Check input errors before deleting the account
    if (empty($username_err) && empty($password_err)) {
        
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, then verify the password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, delete the account
                            $delete_sql = "DELETE FROM users WHERE id = ?";
                            if ($delete_stmt = mysqli_prepare($link, $delete_sql)) {
                                // Bind variable to the prepared statement as parameter
                                mysqli_stmt_bind_param($delete_stmt, "i", $id);
                                
                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($delete_stmt)) {
                                    // Redirect to login page or home page after successful deletion
                                    header("location: login.php");
                                } else {
                                    echo "Oops! Something went wrong. Please try again later.";
                                }

                                // Close statement
                                mysqli_stmt_close($delete_stmt);
                            }
                        } else {
                            // Display an error message if the password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if the username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>