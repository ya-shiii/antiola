<?php
// Include the database connection
include 'db_connect.php';

// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs to prevent SQL injection
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $u_name = $conn->real_escape_string($_POST['u_name']);
    $password = $conn->real_escape_string($_POST['password']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $vehicle = $conn->real_escape_string($_POST['vehicle']);
    $plate_num = $conn->real_escape_string($_POST['plate_num']);

    // Check for duplicate username in user_list
    $check_username_query = "SELECT * FROM user_list WHERE u_name='$u_name'";
    $check_username_result = $conn->query($check_username_query);
    if ($check_username_result->num_rows > 0) {
        // Username already exists
        echo '<script>alert("Username already exists.");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';

        exit();
    }

    // Check for duplicate username in rider_list
    $check_rider_username_query = "SELECT * FROM rider_list WHERE u_name='$u_name'";
    $check_rider_username_result = $conn->query($check_rider_username_query);
    if ($check_rider_username_result->num_rows > 0) {
        // Username already exists
        echo '<script>alert("Username already exists.");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';

        exit();
    }

    // Check for duplicate email in user_list
    $check_email_query = "SELECT * FROM user_list WHERE email='$email'";
    $check_email_result = $conn->query($check_email_query);
    if ($check_email_result->num_rows > 0) {
        // Email already exists
        echo '<script>alert("Email already exists.");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';

        exit();
    }

    // Check for duplicate email in rider_list
    $check_rider_email_query = "SELECT * FROM rider_list WHERE email='$email'";
    $check_rider_email_result = $conn->query($check_rider_email_query);
    if ($check_rider_email_result->num_rows > 0) {
        // Email already exists
        echo '<script>alert("Email already exists.");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';

        exit();
    }

    // Check for duplicate plate number in rider_list
    $check_plate_query = "SELECT * FROM rider_list WHERE plate_num='$plate_num'";
    $check_plate_result = $conn->query($check_plate_query);
    if ($check_plate_result->num_rows > 0) {
        // Plate number already exists
        echo '<script>alert("Plate number already exists.");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';

        exit();
    }

    // Check if the username is "admin"
    if ($u_name === 'admin') {
        // Username cannot be "admin"
        echo '<script>alert("Username cannot be \'admin\'");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';

        exit();
    }


    // Insert the new driver into the database
    $insert_query = "INSERT INTO rider_list (full_name, u_name, password, email, phone, address, vehicle, plate_num) 
                    VALUES ('$full_name', '$u_name', '$password', '$email', '$phone', '$address', '$vehicle', '$plate_num')";
    if ($conn->query($insert_query) === TRUE) {
        // Driver added successfully
        echo '<script>alert("Driver added successfully.");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
        exit();
    } else {
        // Error inserting driver
        echo '<script>alert("Error adding driver.");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
        exit();
    }
} else {
    // Form not submitted
    echo '<script>alert("Form not submitted.");</script>';
    echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
    
}

// Close database connection
$conn->close();
exit();
?>