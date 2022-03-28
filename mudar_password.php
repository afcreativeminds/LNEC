<?php

// Include config file
session_start();
require("config.php");

$email=$_POST["email"];

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check input errors before inserting in database
    if (!empty($_POST["password"])) {

        // Prepare an insert statement
        $sql = "UPDATE users SET password = ? where email = '$email'";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_1);
            $password = $_POST["password"];
            // Set parameters
            $param_1 = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                $_SESSION["return"] = "<p style='color: green'>Password alterada com sucesso.</p>";
                header("location: index.php");
            } else {
                printf("Error: %s.\n", mysqli_stmt_error($stmt));
                echo "4";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}


