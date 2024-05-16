<?php

// Start session
session_start();

// Include database connection
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: ../index.php");
    exit();
}

// Get current user's details
$username = $_SESSION['username'];
$full_name = $_SESSION['full_name'];

// Get form data
$driver_id = $_POST['driver_id'];
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];
$start_location = $_POST['start_location'];
$end_location = $_POST['end_location'];

// Merge booking date and time
$book_time = $booking_date . ' ' . $booking_time;

// Get passenger ID from user_list table
$get_passenger_id_query = "SELECT u_id FROM user_list WHERE u_name = '$username' AND full_name = '$full_name'";
$get_passenger_id_result = mysqli_query($conn, $get_passenger_id_query);
if (mysqli_num_rows($get_passenger_id_result) > 0) {
    $row = mysqli_fetch_assoc($get_passenger_id_result);
    $passenger_id = $row['u_id'];

    // Insert booking details into booking_log table
    $insert_query = "INSERT INTO booking_log (driver_id, passenger_id, booked_at, book_time, start_loc, desti_loc, status) VALUES ('$driver_id', '$passenger_id', NOW(), '$book_time', '$start_location', '$end_location', 'pending')";

    if (mysqli_query($conn, $insert_query)) {
        echo '<script>alert("Booked successfully. Please wait for confirmation");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
        exit();
    } else {
        // Error inserting into booking_log table
        echo '<script>alert("Error in booking: ' . mysqli_error($conn) . '");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
    }
} else {
    // Error fetching passenger ID
    echo "Error: Passenger ID not found.";
    echo '<script>alert("Passenger ID not found.");</script>';
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
}

// Close database connection
mysqli_close($conn);

?>
