$(document).ready(function () {
    // Function to fetch full name from session and display it
    function fetchFullName() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_session.php', // You need to create this file to fetch full name from session
            dataType: 'json',
            success: function (data) {
                if (data.success && data.role === 'admin') {
                    console.log(data.fullname);
                } else {
                    // Alert unauthorized access and redirect to unauthorized page if session is not set or user is not admin
                    alert('Unauthorized access.');
                    window.location.href = data.success ? 'index.html' : 'index.html';
                }
            },
            error: function (xhr, status, error) {
                console.log('Error fetching full name');
            }
        });
    }

    // Fetch and display full name on page load
    fetchFullName();

    // Logout functionality
    $('#logout-link').click(function (event) {
        event.preventDefault();
        alert('Logged out successfully.')
        window.location.href = 'php/logout.php';
    });

    function fetchStatistics() {
        $.ajax({
            url: 'php/fetch_statistics.php', // Replace with the actual URL of your PHP file
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Update the counts
                $('#registered-clients-count').text(data.registeredClients);
                $('#vehicles-count').text(data.vehicles);
                $('#drivers-count').text(data.drivers);
                $('#bookings-count').text(data.bookings);
            },
            error: function (xhr, status, error) {
                console.error("Failed to fetch statistics:", error);
            }
        });
    }

    // Call the fetchStatistics function on page load
    fetchStatistics();


    $('#editMessageModal').on('show.bs.modal', function (event) {
        // Get the modal
        var modal = $(this);

        // AJAX request to fetch welcome messages
        $.ajax({
            type: 'POST',
            url: 'php/fetch_welcome_messages.php',
            data: { textId1: 1, textId2: 2 }, // Send text IDs to fetch
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Populate text areas with fetched messages
                    modal.find('#welcomeMessage1').val(response.first);
                    modal.find('#welcomeMessage2').val(response.second);
                } else {
                    // Handle error if messages cannot be fetched
                    console.error('Error fetching welcome messages:', response.message);
                }
            },
            error: function (xhr, status, error) {
                // Handle AJAX error
                console.error('AJAX Error:', error);
            }
        });
    });

    // Submit the form and handle the response
    $('#editMessageForm').submit(function (event) {
        // Prevent the default form submission
        event.preventDefault();

        // Serialize the form data
        var formData = $(this).serialize();

        // Send an AJAX request to edit_welcome_msg.php
        $.ajax({
            type: 'POST',
            url: 'php/edit_welcome_msg.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Display the response message in an alert
                alert(response.message);

                // Redirect to the referrer page
                window.location.reload();
            },
            error: function (xhr, status, error) {
                // Display an error message if the request fails
                console.error('Error:', error);
            }
        });
    });
});


