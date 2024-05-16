<?php
// Include your database connection file
include 'db_connect.php';

// Check if text IDs are set and not empty
if (isset($_POST['textId1']) && isset($_POST['textId2'])) {
    // Sanitize and validate input
    $textId1 = mysqli_real_escape_string($conn, $_POST['textId1']);
    $textId2 = mysqli_real_escape_string($conn, $_POST['textId2']);

    // Initialize response array
    $response = array();

    // Fetch welcome messages from the database
    $fetch_messages_query = "SELECT * FROM welcome_message WHERE text_id IN ($textId1, $textId2)";
    $fetch_messages_result = mysqli_query($conn, $fetch_messages_query);

    // Check if messages are fetched successfully
    if ($fetch_messages_result) {
        // Initialize variables to store messages
        $firstMessage = '';
        $secondMessage = '';

        // Loop through the fetched rows
        while ($row = mysqli_fetch_assoc($fetch_messages_result)) {
            // Assign messages to variables based on text IDs
            if ($row['text_id'] == $textId1) {
                $firstMessage = $row['display_message'];
            } elseif ($row['text_id'] == $textId2) {
                $secondMessage = $row['display_message'];
            }
        }

        // Set success flag and messages in response
        $response['success'] = true;
        $response['first'] = $firstMessage;
        $response['second'] = $secondMessage;
    } else {
        // Error fetching messages
        $response['success'] = false;
        $response['message'] = 'Error fetching welcome messages.';
    }
} else {
    // Text IDs not provided
    $response['success'] = false;
    $response['message'] = 'Text IDs not provided.';
}

// Return response as JSON
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
