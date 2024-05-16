<?php
session_start();

// Include your database connection file
include 'db_connect.php';

// Check if the booking ID is set and not empty
if (isset($_POST['booking_id']) && !empty($_POST['booking_id'])) {
    // Sanitize the input
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);

    // Update the status to 'completed' in the booking_log table
    $update_query = "UPDATE booking_log SET status = 'completed' WHERE booking_id = '$booking_id'";
    if (mysqli_query($conn, $update_query)) {
        $response['success'] = true;
        $response['message'] = 'Booking marked as complete.';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error marking booking as complete: ' . mysqli_error($conn);
    }
} else {
    // Booking ID not provided
    $response['success'] = false;
    $response['message'] = 'Booking ID is required.';
}

// Encode response array into JSON and echo
echo json_encode($response);
exit();
?>
