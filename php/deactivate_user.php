<?php

// Include the database connection
include 'db_connect.php';

// Check if u_id is set in the POST data
if(isset($_POST['u_id'])) {
    // Sanitize the u_id to prevent SQL injection
    $u_id = $conn->real_escape_string($_POST['u_id']);

    // Update the user status to "inactive" in the user_list table
    $update_query = "UPDATE user_list SET status = 'inactive' WHERE u_id = '$u_id'";

    if ($conn->query($update_query) === TRUE) {
        // Deactivation successful
        $response['success'] = true;
        $response['message'] = "User deactivated successfully";
    } else {
        // Deactivation failed
        $response['success'] = false;
        $response['message'] = "Error deactivating user: " . $conn->error;
    }
} else {
    // u_id not provided in the POST data
    $response['success'] = false;
    $response['message'] = "User ID not provided";
}

// Close the database connection
$conn->close();

// Encode response array into JSON and echo
echo json_encode($response);

?>
