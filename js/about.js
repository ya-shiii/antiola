$(document).ready(function () {
    $('#return-link').click(function (event) {
        event.preventDefault(); // Prevent default link behavior
        var previousPage = document.referrer; // Get the URL of the previous page
        window.location.href = previousPage; // Redirect to the previous page

    });
});