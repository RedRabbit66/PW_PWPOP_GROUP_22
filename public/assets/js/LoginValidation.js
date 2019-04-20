
//Javascript file to comprove a valid login
$(document).ready(function() {
    $('#login').submit(function (event) {
        errorUserMail = document.getElementById("errorUserMail");
        errorPassword = document.getElementById("errorPassword");


        errorUserMail.innerHTML = "";
        errorPassword.innerHTML = "";

        var data = $(this).serialize();
        var userEmail = document.forms["login-form"]["userEmail"].value;
        var password = document.forms["login-form"]["password"].value;

        var ok = true;
        var errorElement;

        if (userEmail == "") {
            ok = false;
            errorUserMail.innerHTML = "It cannot be empty.";
            errorUserMail.style.display = 'block';

        }

        if (!(password.length > 5) || password == "") {
            ok = false;
            errorPassword.innerHTML = "It must contain at least 6 characters";
            errorPassword.style.display = 'block';

        }

        if (ok) {
            return true;
        } else {
            event.preventDefault();

        }
        $.ajax({
            type: 'POST',
            url: '/login',
            data: data,
            dataType: 'json',
            encode: true
        }).done(function (response) {
            console.log(response);
        });
        event.preventDefault();

        return false;
    });
});

