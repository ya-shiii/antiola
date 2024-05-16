<?php
session_start();

// Include your database connection file
include 'db_connect.php';

// Check if session variables are set
if (isset($_SESSION['username'])) {
    // Sanitize session variables
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);

    // Construct the query to fetch user information based on session username and full name
    $query = "SELECT * FROM user_list WHERE u_name = '$username'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if query execution was successful
    if ($result) {
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch user information
            $row = mysqli_fetch_assoc($result);

            // Store user information in an array
            $user_info = array(
                'full_name' => $row['full_name'],
                'address' => $row['address'],
                'phone' => $row['phone'],
                'email' => $row['email']
            );

            // Encode user information array into JSON format and echo
            echo json_encode($user_info);
        } else {
            // No matching user found
            echo json_encode(array('error' => 'User not found'));
        }
    } else {
        // Error executing the query
        echo json_encode(array('error' => 'Error executing query'));
    }
} else {
    // Session variables not set
    echo json_encode(array('error' => 'Session variables not set'));
}

// Close the database connection
mysqli_close($conn);
?>
