<?php

// Include the database connection
include 'db_connect.php';

// Start session
session_start();

// Check if username and password are set
if(isset($_POST['username']) && isset($_POST['password'])) {
    // Sanitize user inputs to prevent SQL injection
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Check if the provided credentials are for admin
    if($username === 'admin' && $password === 'admin') {
        // Set session variables for admin
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin';
        $_SESSION['full_name'] = 'admin';
        echo '<script>console.log('.$username.' '.$password.');</script>';

        // Redirect to admin dashboard
        header("Location: ../admin-dashboard.html");
        exit();
    } else {
        // Query to check if the username and password match in user_list table
        $user_query = "SELECT * FROM user_list WHERE u_name='$username' AND `password`='$password'";
        $user_result = $conn->query($user_query);

        if($user_result && $user_result->num_rows > 0) {
            // Fetch user data
            $user_row = $user_result->fetch_assoc();
            $full_name = $user_row['full_name'];

            // Set session variables for user
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            $_SESSION['full_name'] = $full_name;

            // Redirect to user dashboard
            header("Location: ../client-dashboard.html");
            exit();
        }

        // Query to check if the username and password match in rider_list table
        $rider_query = "SELECT * FROM rider_list WHERE u_name='$username' AND `password`='$password'";
        $rider_result = $conn->query($rider_query);

        if ($rider_result && $rider_result->num_rows > 0) {
            // Fetch rider data
            $rider_row = $rider_result->fetch_assoc();
            $full_name = $rider_row['full_name'];

            // Set session variables for rider
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'rider';
            $_SESSION['full_name'] = $full_name;

            // Redirect to rider dashboardsssa
            header("Location: ../rider-dashboard.html");
            exit();
        }
    }
}

// Invalid username or password, redirect to index page
echo '<script>alert("Invalid username or password");';
echo 'window.location.href= "../index.html"</script>';
exit();

?>
