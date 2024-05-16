<?php
session_start();

// Include your database connection file
include 'db_connect.php';

// Check if user is logged in
if (isset($_SESSION['username'])) {
    // Fetch user ID and full name from session
    $username = $_SESSION['username'];
    $fetch_user_query = "SELECT u_id FROM user_list WHERE u_name = '$username'";
    $fetch_user_result = mysqli_query($conn, $fetch_user_query);
    $user_row = mysqli_fetch_assoc($fetch_user_result);
    $user_id = $user_row['u_id'];

    // Fetch bookings for the logged-in user
    $fetch_bookings_query = "SELECT * FROM booking_log WHERE passenger_id = '$user_id'";
    $fetch_bookings_result = mysqli_query($conn, $fetch_bookings_query);

    // Array to store bookings data
    $bookings = array();

    // Check if bookings exist
    if (mysqli_num_rows($fetch_bookings_result) > 0) {
        // Fetch booking details
        while ($row = mysqli_fetch_assoc($fetch_bookings_result)) {
            // Fetch driver details from rider_list table using driver_id from booking_log
            $driver_id = $row['driver_id'];
            $fetch_driver_query = "SELECT * FROM rider_list WHERE u_id = '$driver_id'";
            $fetch_driver_result = mysqli_query($conn, $fetch_driver_query);
            $driver_row = mysqli_fetch_assoc($fetch_driver_result);

            // Construct the booking array with driver details
            $booking = array(
                'booked_at' => $row['booked_at'],
                'start_loc' => $row['start_loc'],
                'desti_loc' => $row['desti_loc'],
                'book_time' => $row['book_time'],
                'full_name' => $driver_row['full_name'],
                'vehicle' => $driver_row['vehicle'],
                'plate_num' => $driver_row['plate_num'],
                'status' => $row['status']
            );
            // Push the booking data into the bookings array
            array_push($bookings, $booking);
        }

        // Send bookings data as JSON response
        echo json_encode($bookings);
    } else {
        // No bookings found
        echo json_encode(array());
    }
} else {
    // User not logged in
    echo json_encode(array());
}

// Close the database connection
mysqli_close($conn);
?>
