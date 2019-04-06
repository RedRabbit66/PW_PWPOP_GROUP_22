
//Javascript file to comprove a valid login
$(document).ready(function() {
    $('#login').submit(function (event) {
        errorMail = document.getElementById("errorMail");
        errorPassword = document.getElementById("errorPassword");


        errorMail.innerHTML = "";
        errorPassword.innerHTML = "";

        var data = $(this).serialize();
        var email = document.forms["login"]["email"].value;
        var password = document.forms["login"]["password"].value;

        var ok = true;
        var errorElement;

        if (email == "") {
            ok = false;
            errorMail.innerHTML = "It cannot be empty.";
            errorMail.style.display = 'block';

        }

        if (!validatePassword(password) || password == "") {
            ok = false;
            errorPassword.innerHTML = "The length of the password must be between 6 and 12 characters and it must contain at least one number and one upper case letter.";
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

function validatePassword(password) {
    var ok = false;
    if (password.length >= 6 && password.length <= 20 && hasNumbers(password) && hasUpperCase(password)) {
        ok = true;
    }
    return ok;
}

function hasNumbers(t)
{
    return /\d/.test(t);
}

function hasUpperCase(str) {
    return (/[A-Z]/.test(str));
}