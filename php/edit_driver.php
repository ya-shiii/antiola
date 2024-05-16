<?php

// Include the database connection
include 'db_connect.php';

// Check if form fields are submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent SQL injection
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $u_name = mysqli_real_escape_string($conn, $_POST['u_name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $vehicle = mysqli_real_escape_string($conn, $_POST['vehicle']);
    $plate_num = mysqli_real_escape_string($conn, $_POST['plate_num']);

    // Query to update driver information
    $query = "UPDATE rider_list SET full_name='$full_name', u_name='$u_name', password='$password', email='$email', phone='$phone', address='$address', vehicle='$vehicle', plate_num='$plate_num' WHERE u_id=$user_id";

    // Execute query
    if (mysqli_query($conn, $query)) {
        // Update successful
        echo '<script>alert("Driver information updated successfully.");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
    } else {
        // Update failed
        echo '<script>alert("Error updating driver information: ' . mysqli_error($conn) . '");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
    }
} else {
    // Form fields not submitted
    echo '<script>alert("Form fields not submitted.");</script>';
    echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
}
?>
