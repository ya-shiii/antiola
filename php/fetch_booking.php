<?php

// Include the database connection
include 'db_connect.php';

// Initialize an array to store booking details
$bookings = array();

// Query to fetch booking details with driver and passenger information
$query = "SELECT 
            booking_log.booking_id,
            booking_log.driver_id,
            rider_list.full_name AS driver_name,
            rider_list.vehicle,
            rider_list.plate_num,
            booking_log.passenger_id,
            user_list.full_name AS passenger_name,
            booking_log.booked_at,
            booking_log.book_time,
            booking_log.start_loc,
            booking_log.desti_loc,
            booking_log.status
          FROM 
            booking_log
          LEFT JOIN 
            rider_list ON booking_log.driver_id = rider_list.u_id
          LEFT JOIN 
            user_list ON booking_log.passenger_id = user_list.u_id";

$result = $conn->query($query);

// Check if query was successful
if ($result && $result->num_rows > 0) {
    // Fetch booking details and add them to the array
    while ($row = $result->fetch_assoc()) {
        $booking = array(
            'booking_id' => $row['booking_id'],
            'driver_id' => $row['driver_id'],
            'driver_name' => $row['driver_name'],
            'vehicle' => $row['vehicle'],
            'plate_num' => $row['plate_num'],
            'passenger_id' => $row['passenger_id'],
            'passenger_name' => $row['passenger_name'],
            'booked_at' => $row['booked_at'],
            'book_time' => $row['book_time'],
            'start_loc' => $row['start_loc'],
            'desti_loc' => $row['desti_loc'],
            'status' => $row['status']
        );
        $bookings[] = $booking;
    }
} else {
    // No bookings found
    echo json_encode(array());
    exit(); // Stop further execution
}

// Close the database connection
$conn->close();

// Encode the array as JSON and echo
echo json_encode($bookings);
?>
