<?php

// Include the database connection
include 'db_connect.php';

// Initialize response array
$response = array();

// Query to count registered clients
$registered_clients_query = "SELECT COUNT(*) AS registered_clients FROM user_list";
$registered_clients_result = $conn->query($registered_clients_query);
$registered_clients_row = $registered_clients_result->fetch_assoc();
$response['registeredClients'] = $registered_clients_row['registered_clients'];

// Query to count vehicles
$vehicles_query = "SELECT COUNT(*) AS vehicles FROM rider_list WHERE vehicle IS NOT NULL";
$vehicles_result = $conn->query($vehicles_query);
$vehicles_row = $vehicles_result->fetch_assoc();
$response['vehicles'] = $vehicles_row['vehicles'];

// Query to count drivers
$drivers_query = "SELECT COUNT(*) AS drivers FROM rider_list";
$drivers_result = $conn->query($drivers_query);
$drivers_row = $drivers_result->fetch_assoc();
$response['drivers'] = $drivers_row['drivers'];

// Query to count bookings
$bookings_query = "SELECT COUNT(*) AS bookings FROM booking_log";
$bookings_result = $conn->query($bookings_query);
$bookings_row = $bookings_result->fetch_assoc();
$response['bookings'] = $bookings_row['bookings'];

// Close database connection
$conn->close();

// Encode response array into JSON and echo
echo json_encode($response);

?>
