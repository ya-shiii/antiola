<?php
// Include your database connection file
include 'db_connect.php';

// Initialize response array
$response = array();

// Check if ID is set in the POST request
if(isset($_POST['id'])) {
    // Sanitize and validate the ID
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Fetch welcome message from the database based on the provided ID
    $query = "SELECT display_message FROM welcome_message WHERE text_id = $id";
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if ($result) {
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch the message from the result
            $row = mysqli_fetch_assoc($result);
            $message = $row['display_message'];

            // Set success flag and message in response
            $response['success'] = true;
            $response['message'] = $message;
        } else {
            // No message found in the database for the provided ID
            $response['success'] = false;
            $response['message'] = 'No welcome message found for ID: ' . $id;
        }
    } else {
        // Error executing the query
        $response['success'] = false;
        $response['message'] = 'Error fetching welcome message: ' . mysqli_error($conn);
    }
} else {
    // ID not provided in the POST request
    $response['success'] = false;
    $response['message'] = 'ID not provided in the request.';
}

// Close the database connection
mysqli_close($conn);

// Encode response array into JSON and echo
echo json_encode($response);
?>
