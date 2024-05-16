<?php
session_start();

// Include your database connection file
include 'db_connect.php';

// Check if user is logged in
if (isset($_SESSION['username'])) {
    // Fetch user ID and full name from session
    $username = $_SESSION['username'];
    $fetch_user_query = "SELECT * FROM rider_list WHERE u_name = '$username'";
    $fetch_user_result = mysqli_query($conn, $fetch_user_query);
    
    // Check if user exists
    if ($fetch_user_result && mysqli_num_rows($fetch_user_result) > 0) {
        $user_row = mysqli_fetch_assoc($fetch_user_result);
        $user_id = $user_row['u_id'];
        

        // Fetch bookings for the logged-in driver
        $fetch_bookings_query = "SELECT * FROM booking_log WHERE driver_id = '$user_id'";
        $fetch_bookings_result = mysqli_query($conn, $fetch_bookings_query);

        // Array to store bookings data
        $bookings = array();

        // Check if bookings exist
        if ($fetch_bookings_result && mysqli_num_rows($fetch_bookings_result) > 0) {
            // Fetch booking details
            while ($row = mysqli_fetch_assoc($fetch_bookings_result)) {
                // Fetch passenger details from user_list table using passenger_id from booking_log
                $passenger_id = $row['passenger_id'];
                $fetch_passenger_query = "SELECT * FROM user_list WHERE u_id = '$passenger_id'";
                $fetch_passenger_result = mysqli_query($conn, $fetch_passenger_query);
                
                // Check if passenger exists
                if ($fetch_passenger_result && mysqli_num_rows($fetch_passenger_result) > 0) {
                    $passenger_row = mysqli_fetch_assoc($fetch_passenger_result);

                    // Construct the booking array with passenger details
                    $booking = array(
                        'book_id' => $row['booking_id'],
                        'booked_at' => $row['booked_at'],
                        'start_loc' => $row['start_loc'],
                        'desti_loc' => $row['desti_loc'],
                        'book_time' => $row['book_time'],
                        'full_name' => $passenger_row['full_name'], // Passenger's full name
                        'email' => $passenger_row['email'], // Passenger's email
                        'phone' => $passenger_row['phone'], // Passenger's phone
                        'status' => $row['status']
                    );
                    // Push the booking data into the bookings array
                    array_push($bookings, $booking);
                }
            }

            // Send bookings data as JSON response
            echo json_encode($bookings);
        } else {
            // No bookings found
            echo json_encode(array());
        }
    } else {
        // User not found
        echo json_encode(array());
    }
} else {
    // User not logged in
    echo json_encode(array());
}

// Close the database connection
mysqli_close($conn);
?>
