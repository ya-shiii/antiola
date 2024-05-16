<?php

// Include your database connection file
include 'db_connect.php';

// Initialize response array
$response = array();

// Query to fetch count of available vehicles
$query = "SELECT COUNT(*) AS count FROM rider_list WHERE status = 'standby'";
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result) {
    // Fetch count from the result
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    // Set success flag and count in the response
    $response['success'] = true;
    $response['count'] = $count;
} else {
    // Error fetching count
    $response['success'] = false;
    $response['message'] = mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

// Encode response array into JSON and echo
echo json_encode($response);
exit();
?>
