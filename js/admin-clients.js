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
    
    // Function to fetch and populate cards for users
    function fetchAndPopulateCards() {
        $.ajax({
            type: 'GET',
            url: 'php/fetch_users.php',
            dataType: 'json',
            success: function (data) {
                // Loop through each user and populate cards
                data.forEach(function (user) {
                    var card = `
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-success">${user.full_name}</h5>
                                    <p class="card-text">Address: ${user.address}</p>
                                    <p class="card-text">Email: ${user.email}</p>
                                    <p class="card-text">Phone number: ${user.phone}</p>
                                    <p class="card-text">Number of bookings: ${user.num_bookings}</p>
                                    <a href="#" class="btn btn-danger w-auto" onclick="deactivateUser(${user.u_id})">Deactivate</a>
                                </div>
                            </div>
                        </div>`;
                    var deact_card = `
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-danger">${user.full_name}</h5>
                                    <p class="card-text">Address: ${user.address}</p>
                                    <p class="card-text">Email: ${user.email}</p>
                                    <p class="card-text">Phone number: ${user.phone}</p>
                                    <p class="card-text">Number of bookings: ${user.num_bookings}</p>
                                    <a href="#" class="btn btn-success w-auto" onclick="activateUser(${user.u_id})">Activate</a>
                                </div>
                            </div>
                        </div>`;
                    if (user.status === 'active') {
                        $('.row').append(card);
                    }else{
                        $('.row').append(deact_card);
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

// Function to deactivate user
function deactivateUser(u_id) {
    // Perform action to deactivate user with given u_id
    console.log(`Deactivating user with ID: ${u_id}`);
    $.ajax({
        type: 'POST',
        url: 'php/deactivate_user.php', // Assuming this is the endpoint to handle deactivation
        data: { u_id: u_id },
        dataType: 'json',
        success: function (response) {
            // Handle success response
            console.log(response.message);
            alert(response.message);
            window.location.href = 'admin-clients.html';
        },
        error: function (xhr, status, error) {
            // Handle error
            console.error(error);
        }
    });
}

// Function to deactivate user
function activateUser(u_id) {
    // Perform action to deactivate user with given u_id
    console.log(`Activating user with ID: ${u_id}`);
    $.ajax({
        type: 'POST',
        url: 'php/activate_user.php', // Assuming this is the endpoint to handle deactivation
        data: { u_id: u_id },
        dataType: 'json',
        success: function (response) {
            // Handle success response
            console.log(response.message);
            alert(response.message);
            window.location.href = 'admin-clients.html';
        },
        error: function (xhr, status, error) {
            // Handle error
            console.error(error);
        }
    });
}
