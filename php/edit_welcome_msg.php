<?php
// Include your database connection file
include 'db_connect.php';

// Check if form fields are set and not empty
if (
    isset($_POST['welcomeMessage1']) && !empty($_POST['welcomeMessage1']) &&
    isset($_POST['welcomeMessage2']) && !empty($_POST['welcomeMessage2'])
) {
    // Sanitize and validate input
    $welcomeMessage1 = mysqli_real_escape_string($conn, $_POST['welcomeMessage1']);
    $welcomeMessage2 = mysqli_real_escape_string($conn, $_POST['welcomeMessage2']);

    // Update the welcome messages in the database
    $update_query1 = "UPDATE welcome_message SET display_message = '$welcomeMessage1' WHERE text_id = 1";
    $update_query2 = "UPDATE welcome_message SET display_message = '$welcomeMessage2' WHERE text_id = 2";

    // Execute the update queries
    $result1 = mysqli_query($conn, $update_query1);
    $result2 = mysqli_query($conn, $update_query2);

    // Check if both queries executed successfully
    if ($result1 && $result2) {
        // Success message
        $response['success'] = true;
        $response['message'] = 'Welcome messages updated successfully.';
    } else {
        // Error message if queries failed
        $response['success'] = false;
        $response['message'] = 'Error updating welcome messages.';
    }
} else {
    // Error message if form fields are not set or empty
    $response['success'] = false;
    $response['message'] = 'All fields are required.';
}

// Return response as JSON
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
