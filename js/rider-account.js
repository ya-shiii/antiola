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

    // Function to fetch user account information
    function fetchAccountInfo() {
        $.ajax({
            type: 'POST',
            url: 'php/fetch_rider_info.php', // Update the URL to fetch user info
            dataType: 'json',
            success: function (data) {
                // Prefill form fields with user account information
                $('#registerFullName').val(data.full_name);
                $('#registerAddress').val(data.address);
                $('#registerPhone').val(data.phone);
                $('#registerEmail').val(data.email);
                $('#plate_num').val(data.plate_num);
                $('#vehicle').val(data.vehicle);
                $('#registerPassword').val('');
            },
            error: function (xhr, status, error) {
                console.error("Error fetching account info:", error);
            }
        });
    }

    // Call function to fetch and prefill account information
    fetchAccountInfo();

    // Logout functionality
    $('#logout-link').click(function (event) {
        event.preventDefault();
        alert('Logged out successfully.')
        window.location.href = 'php/logout.php';
    });
});
