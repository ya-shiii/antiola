<?php
session_start();

// Include your database connection file
include 'db_connect.php';

// Check if form fields are set and not empty
if (
    isset($_POST['full_name']) && !empty($_POST['full_name']) &&
    isset($_POST['address']) && !empty($_POST['address']) &&
    isset($_POST['phone']) && !empty($_POST['phone']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['password']) && !empty($_POST['password'])
) {
    // Sanitize form inputs
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Get username from session
    $username = $_SESSION['username'];

    // Query to check if the provided password matches the one in the database
    $check_password_query = "SELECT * FROM user_list WHERE u_name = '$username' AND password = '$password'";
    $check_password_result = mysqli_query($conn, $check_password_query);

    // Check if password is correct
    if (mysqli_num_rows($check_password_result) > 0) {
        // Password is correct, proceed with updating user information

        // Construct the UPDATE query
        $update_query = "UPDATE user_list SET full_name = '$full_name', address = '$address', phone = '$phone', email = '$email' WHERE u_name = '$username'";

        // Execute the UPDATE query
        if (mysqli_query($conn, $update_query)) {
            // Query executed successfully
            $_SESSION['message'] = 'Account information updated successfully.';
            $_SESSION['message_type'] = 'success';
        } else {
            // Error executing the UPDATE query
            $_SESSION['message'] = mysqli_error($conn);
            $_SESSION['message_type'] = 'danger';
        }
    } else {
        // Password provided is incorrect
        $_SESSION['message'] = 'Incorrect password. Please try again.';
        $_SESSION['message_type'] = 'danger';
    }
} else {
    // Required fields not provided
    $_SESSION['message'] = 'All fields are required.';
    $_SESSION['message_type'] = 'danger';
}

// Close the database connection
mysqli_close($conn);

// Redirect back to the previous page
echo "<script>alert('" . $_SESSION['message'] . "'); window.location.href = '../client-account.html';</script>";
exit();
?>
