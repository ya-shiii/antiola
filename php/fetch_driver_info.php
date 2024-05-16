<?php

// Include the database connection
include 'db_connect.php';

// Check if u_id is provided
if (isset($_POST['u_id'])) {
    // Sanitize the input to prevent SQL injection
    $u_id = $_POST['u_id'];

    // Query to fetch driver information
    $query = "SELECT * FROM rider_list WHERE u_id = $u_id"; 
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result) {
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Fetch the driver information
            $driverInfo = $result->fetch_assoc();

            // Return the driver information as JSON
            echo json_encode($driverInfo);
        } else {
            // No matching driver found
            echo json_encode(['error' => 'Driver not found']);
        }
    } else {
        // Query execution failed
        echo json_encode(['error' => 'Query failed']);
    }
} else {
    // u_id parameter is missing
    echo json_encode(['error' => 'Missing u_id parameter']);
}
?>
