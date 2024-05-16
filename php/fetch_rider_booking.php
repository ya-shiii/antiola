<?php
session_start();

// Include your database connection file
include 'db_connect.php';

// Check if the session username is set
if (isset($_SESSION['username'])) {
    // Get the session username
    $username = $_SESSION['username'];

    // Query to fetch the user ID (u_id) from rider_list based on the session username
    $get_user_id_query = "SELECT u_id FROM rider_list WHERE u_name = '$username'";
    $get_user_id_result = mysqli_query($conn, $get_user_id_query);

    if ($get_user_id_result) {
        // Fetch the user ID (u_id) from the result
        $row = mysqli_fetch_assoc($get_user_id_result);
        $user_id = $row['u_id'];

        // Query to count the rows in booking_log where driver_id is equal to user ID and status is not 'completed' or 'cancelled'
        $count_query = "SELECT COUNT(*) AS count FROM booking_log WHERE driver_id = '$user_id' AND status NOT IN ('completed', 'cancelled')";
        $count_result = mysqli_query($conn, $count_query);

        if ($count_result) {
            // Fetch the count from the result
            $row = mysqli_fetch_assoc($count_result);
            $count = $row['count'];

            // Prepare JSON response
            $response = array(
                'success' => true,
                'count' => $count
            );
        } else {
            // Error in counting rows
            $response = array(
                'success' => false,
                'message' => 'Error counting rows in booking log.'
            );
        }
    } else {
        // Error in fetching user ID
        $response = array(
            'success' => false,
            'message' => 'Error fetching user ID from rider list.'
        );
    }
} else {
    // Session username not set
    $response = array(
        'success' => false,
        'message' => 'Session username not set.'
    );
}

// Close the database connection
mysqli_close($conn);

// Encode response array into JSON and echo
echo json_encode($response);
?>
