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

    // Function to fetch and populate cards for users
    function fetchAndPopulateCards() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_rider_bookings.php',
            dataType: 'json',
            success: function (data) {

                // Loop through each booking and populate cards
                data.forEach(function (booking) {
                    var statusColor = '';
                    switch (booking.status) {
                        case 'accepted':
                            statusColor = 'success';
                            break;
                        case 'pending':
                            statusColor = 'warning';
                            break;
                        case 'completed':
                            statusColor = 'primary';
                            break;
                        case 'cancelled':
                            statusColor = 'danger';
                            break;
                        default:
                            statusColor = 'secondary';
                            break;
                    }

                    var bookedAt = new Date(booking.booked_at);
                    var currentTime = new Date();
                    var timeElapsed = Math.floor((currentTime - bookedAt) / 1000); // Time elapsed in seconds

                    // Format time elapsed
                    var timeElapsedStr = '';
                    if (timeElapsed < 60) {
                        timeElapsedStr = timeElapsed + ' second(s) ago';
                    } else if (timeElapsed < 3600) {
                        timeElapsedStr = Math.floor(timeElapsed / 60) + ' minute(s) ago';
                    } else if (timeElapsed < 86400) {
                        timeElapsedStr = Math.floor(timeElapsed / 3600) + ' hour(s) ago';
                    } else {
                        timeElapsedStr = Math.floor(timeElapsed / 86400) + ' day(s) ago';
                    }

                    var acceptButton = `<a href="#" class="btn btn-success w-auto" onclick="accept(${booking.book_id})">Accept</a>`;
                    var declineButton = `<a href="#" class="btn btn-danger w-auto" onclick="cancel(${booking.book_id})">Decline</a>`;
                    var markCompleteButton = `<a href="#" class="btn btn-primary w-auto" onclick="complete(${booking.book_id})">Mark Complete</a>`;
                    var cancelButton = `<a href="#" class="btn btn-danger w-auto" onclick="cancel(${booking.book_id})">Cancel</a>`;

                    var statusButtons = '';
                    switch (booking.status) {
                        case 'pending':
                            statusButtons = acceptButton + ' ' + declineButton;
                            break;
                        case 'accepted':
                            statusButtons = markCompleteButton + ' ' + cancelButton;
                            break;
                        default:
                            // No buttons for other statuses
                            break;
                    }

                    var cardContent = `
                        <div class="col-4 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">${formatTime(timeElapsedStr)}</h5>
                                    <p class="card-text">Name: ${booking.full_name}</p>
                                    <p class="card-text">Email: ${booking.email}</p>
                                    <p class="card-text">Phone: ${booking.phone}</p>
                                    <p class="card-text">From: ${booking.start_loc}</p>
                                    <p class="card-text">To: ${booking.desti_loc}</p>
                                    <p class="card-text">When: ${booking.book_time}</p>
                                    <p class="card-text">Status: <span class="text-${statusColor}">${booking.status}</span></p>
                                    ${statusButtons}
                                </div>
                            </div>
                        </div>`;
                    $('.row').append(cardContent);
                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching bookings:", error);
            }
        });
    }

    // Function to format time as "X seconds ago"
    function formatTime(timestamp) {
        // Logic to format timestamp as desired format
        return timestamp;
    }

    // Call function to fetch and populate cards for bookings
    fetchAndPopulateCards();

    // Logout functionality
    $('#logout-link').click(function (event) {
        event.preventDefault();
        alert('Logged out successfully.')
        window.location.href = 'php/logout.php';
    });
});


// Function to handle accepting a booking
function accept(bookingId) {
    // Perform AJAX request to handle accepting the booking
    $.ajax({
        type: 'POST',
        url: 'php/accept_booking.php', // Adjust the URL to your server endpoint
        data: { booking_id: bookingId },
        dataType: 'json',
        success: function (response) {
            // Check if the booking was accepted successfully
            if (response.success) {
                // Show success message
                alert('Booking accepted successfully.');
                // Refresh the page or update UI as needed
            } else {
                // Show error message
                alert('Error accepting booking: ' + response.message);
            }
            window.location.reload();
        },
        error: function (xhr, status, error) {
            // Show error message
            alert('Error accepting booking: ' + error);
            window.location.reload();
        }
    });
}

// Function to handle marking a booking as complete
function complete(bookingId) {
    // Perform AJAX request to handle marking the booking as complete
    $.ajax({
        type: 'POST',
        url: 'php/complete_booking.php', // Adjust the URL to your server endpoint
        data: { booking_id: bookingId },
        dataType: 'json',
        success: function (response) {
            // Check if the booking was marked as complete successfully
            if (response.success) {
                // Show success message
                alert('Booking marked as complete.');
                // Refresh the page or update UI as needed
            } else {
                // Show error message
                alert('Error marking booking as complete: ' + response.message);
            }
            window.location.reload();
        },
        error: function (xhr, status, error) {
            // Show error message
            alert('Error marking booking as complete: ' + error);
            window.location.reload();
        }
    });
}

// Function to handle canceling a booking
function cancel(bookingId) {
    // Perform AJAX request to handle canceling the booking
    $.ajax({
        type: 'POST',
        url: 'php/cancel_booking.php', // Adjust the URL to your server endpoint
        data: { booking_id: bookingId },
        dataType: 'json',
        success: function (response) {
            // Check if the booking was canceled successfully
            if (response.success) {
                // Show success message
                alert('Booking canceled successfully.');
                // Refresh the page or update UI as needed
            } else {
                // Show error message
                alert('Error canceling booking: ' + response.message);
            }
            window.location.reload();
        },
        error: function (xhr, status, error) {
            // Show error message
            alert('Error canceling booking: ' + error);
            window.location.reload();
        }
    });
}
