<?php

// Include the database connection
include 'db_connect.php';

// Initialize an array to store users
$users = array();

// Query to fetch users from user_list table
$query = "SELECT *, (SELECT COUNT(*) FROM booking_log WHERE passenger_id = u_id) AS num_bookings FROM user_list";
$result = $conn->query($query);

// Check if query was successful
if ($result && $result->num_rows > 0) {
    // Fetch users and add them to the array
    while ($row = $result->fetch_assoc()) {
        $user = array(
            'u_id' => $row['u_id'],
            'full_name' => $row['full_name'],
            'address' => $row['address'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'num_bookings' => $row['num_bookings'],
            'status' => $row['status']
        );
        $users[] = $user;
    }
} else {
    // No users found
    echo json_encode(array());
    exit(); // Stop further execution
}

// Close the database connection
$conn->close();

// Encode the array as JSON and echo
echo json_encode($users);
