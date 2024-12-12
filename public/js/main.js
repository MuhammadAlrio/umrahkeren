$(document).ready(function() {
    $('#login-form').on('submit', function(e) {
        const username = $('#username').val();
        const password = $('#password').val();
        
        if (!username || !password) {
            e.preventDefault();
            alert('Please fill all fields bestie!');
        }
    });
});