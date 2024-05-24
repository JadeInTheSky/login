function toggleView() {
    const mainView = document.getElementById('mainView');
    const alternateView = document.getElementById('alternateView');

    if (mainView.classList.contains('active')) {
        mainView.classList.remove('active');
        alternateView.classList.add('active');
    } else {
        mainView.classList.add('active');
        alternateView.classList.remove('active');
    }
}

$(document).ready(function() {
    $('#button-login').click(function() {
        var login_username = $('#login-txtbox-username').val();
        var login_password = $('#login-txtbox-password').val();
        $.ajax({
            url: 'operations.php',
            type: 'POST',
            data: {
                username: login_username,
                password: login_password,
                action: 'button-login'
            },
            success: function(response) {
                $('#result').html(response);
            }
        });
    });

    $('#button-register').click(function() {
        var register_username = $('#register-txtbox-username').val();
        var register_email = $('#register-txtbox-email').val();
        var register_password = $('#register-txtbox-password').val();
        $.ajax({
            url: 'operations.php',
            type: 'POST',
            data: {
                username: register_username,
                email: register_email,
                password: register_password,
                action: 'button-register'
            },
            success: function(response) {
                $('#result').html(response);
                toggleView();
            }
        });
    });

    $('#button-register-toggle').click(function() {
        toggleView();
    });

    $('#button-register-back').click(function() {
        toggleView();
    });
});