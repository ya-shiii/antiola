$(document).ready(function () {
    // Function to fetch full name from session and display it
    function fetchFullName() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_session.php', // You need to create this file to fetch full name from session
            dataType: 'json',
            success: function (data) {
                if (data.success && data.role === 'rider') {
                    $('#fullname-display').text(data.fullname);
                    console.log(data.fullname);
                } else {
                    // Alert unauthorized access and redirect to unauthorized page if session is not set or user is not admin
                    alert('You need to login first.');
                    window.location.href = data.success ? 'index.html' : 'index.html';
                }
            },
            error: function (xhr, status, error) {
                $('#fullname-display').text("Error fetching full name");
            }
        });
    }

    // Fetch and display full name on page load
    fetchFullName();

    // Function to fetch and populate count of available vehicles
    function fetchAvailableCount() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_rider_booking.php', // Adjust the URL to your server endpoint
            dataType: 'json',
            success: function (response) {
                // Check if count was successfully retrieved
                if (response.success) {
                    // Update the count in the HTML
                    $('#count-booking').text(response.count);
                } else {
                    // Display error message if count retrieval fails
                    console.error('Error:', response.message);
                }
            },
            error: function (xhr, status, error) {
                // Error handling
                console.error('Error fetching available count:', error);
            }
        });
    }

    // Call the function to fetch and populate count of available vehicles
    fetchAvailableCount();

    // Function to fetch welcome message based on ID
    function fetchWelcomeMessage(id) {
        $.ajax({
            type: 'POST',
            url: 'php/fetch_welcome_message.php',
            data: { id: id }, // Pass ID as data in the POST request
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Populate the message in the HTML element with id "client-msg"
                    $('#driver-msg').text(response.message);
                } else {
                    // Display error message if fetching message fails
                    console.error('Error:', response.message);
                }
            },
            error: function (xhr, status, error) {
                // Error handling
                console.error('Error fetching welcome message:', error);
            }
        });
    }

    // Call function to fetch welcome message with ID 1
    fetchWelcomeMessage(2); // Change the ID as needed

    // Logout functionality
    $('#logout-link').click(function (event) {
        event.preventDefault();
        alert('Logged out successfully.')
        window.location.href = 'php/logout.php';
    });
});
