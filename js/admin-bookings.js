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

    // Function to fetch and populate cards for bookings
    function fetchAndPopulateCards() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_booking.php',
            dataType: 'json',
            success: function (data) {
                // Loop through each booking and populate cards
                data.forEach(function (booking) {
                    var statusClass = booking.status === 'pending' ? 'text-warning' :
                        (booking.status === 'accepted' ? 'text-primary' :
                            (booking.status === 'completed' ? 'text-success' : 'text-danger'));
                    var statusText = booking.status.charAt(0).toUpperCase() + booking.status.slice(1);
                    var timeDifference = getTimeDifference(booking.booked_at);
                    var category = booking.vehicle === 'car' ? '4 Wheel - Car' : '2 Wheel - Motorcycle';

                    var card = `
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title fw-bolder">${timeDifference} ago</h5>
                                    <p class="card-text">Booked by: ${booking.passenger_name}</p>
                                    <p class="card-text">From: ${booking.start_loc}</p>
                                    <p class="card-text">To: ${booking.desti_loc}</p>
                                    <p class="card-text">When: ${booking.book_time}</p>
                                    <p class="card-text">Driver: ${booking.driver_name}</p>
                                    <p class="card-text">Category: ${category}</p>
                                    <p class="card-text">Plate Number: ${booking.plate_num}</p>
                                    <p class="card-text">Status: <span class="${statusClass}">${statusText}</span></p>
                                </div>
                            </div>
                        </div>`;
                    $('.row').append(card);
                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching bookings:", error);
            }
        });
    }

    // Call function to fetch and populate cards for bookings
    fetchAndPopulateCards();

    // Logout functionality
    $('#logout-link').click(function (event) {
        event.preventDefault();
        alert('Logged out successfully.')
        window.location.href = 'php/logout.php';
    });

    // Function to calculate time difference from booking time
    function getTimeDifference(bookedAt) {
        var now = new Date();
        var bookingTime = new Date(bookedAt);
        var differenceInMillis = now.getTime() - bookingTime.getTime();
        var differenceInSeconds = Math.floor(differenceInMillis / 1000);
        var differenceInMinutes = Math.floor(differenceInSeconds / 60);
        var differenceInHours = Math.floor(differenceInMinutes / 60);
        var differenceInDays = Math.floor(differenceInHours / 24);

        if (differenceInDays > 0) {
            return differenceInDays + " days";
        } else if (differenceInHours > 0) {
            return differenceInHours + " hours";
        } else if (differenceInMinutes > 0) {
            return differenceInMinutes + " minutes";
        } else {
            return "Just now";
        }
    }
});
