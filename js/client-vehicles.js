$(document).ready(function () {
    // Function to fetch full name from session and display it
    function fetchFullName() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_session.php', // You need to create this file to fetch full name from session
            dataType: 'json',
            success: function (data) {
                if (data.success && data.role === 'user') {
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

    // Function to fetch and populate cards for users
    function fetchAndPopulateCards() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_client_vehicles.php',
            dataType: 'json',
            success: function (data) {
                // Loop through each user and populate cards
                data.forEach(function (user) {
                    var car_card = `
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">4 Wheels - Car</h5>
                                    <p class="card-text">Oprator: ${user.full_name}</p>
                                    <p class="card-text">Plate Number: ${user.plate_num}</p>
                                    <p class="card-text">Phone number: ${user.phone}</p>
                                    <a href="#" class="btn btn-primary w-auto" onclick="bookDriver(${user.u_id})">Book now</a>
                                </div>
                            </div>
                        </div>`;
                    var motor_card = `
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">2 Wheels - Motorcycle</h5>
                                    <p class="card-text">Oprator: ${user.full_name}</p>
                                    <p class="card-text">Plate Number: ${user.plate_num}</p>
                                    <p class="card-text">Phone number: ${user.phone}</p>
                                    <a href="#" class="btn btn-primary w-auto" onclick="bookDriver(${user.u_id})">Book now</a>
                                </div>
                            </div>
                        </div>`; 
                    if ((user.vehicle === 'car') && (user.status === 'standby')) {
                        $('.row').append(car_card);
                    } else {
                        $('.row').append(motor_card);
                    }

                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching users:", error);
            }
        });
    }

    // Call function to fetch and populate cards for users
    fetchAndPopulateCards();


    // Logout functionality
    $('#logout-link').click(function (event) {
        event.preventDefault();
        alert('Logged out successfully.')
        window.location.href = 'php/logout.php';
    });
});

function bookDriver(userId) {
    // Set the user ID in a hidden input field within the modal
    $('#driverUserId').val(userId);

    // Show the modal
    $('#bookDriverModal').modal('show');
}
