$(document).ready(function() {
    $('#register').submit(function (event) {
        errorUser = document.getElementById("errorUser");
        errorMail = document.getElementById("errorMail");
        errorDate = document.getElementById("errorBirthdate");
        errorPassword = document.getElementById("errorPassword");
        errorConfirmPass = document.getElementById("errorValidation");


        errorUser.innerHTML = "";
        errorMail.innerHTML = "";
        errorDate.innerHTML = "";
        errorPassword.innerHTML = "";
        errorConfirmPass.innerHTML = "";

        var data = $(this).serialize();
        var username = document.forms["register"]["username"].value;
        var email = document.forms["register"]["email"].value;
        var birthdate = document.forms["register"]["birthdate"].value;
        var password = document.forms["register"]["password"].value;
        var confirm = document.forms["register"]["confirm"].value;

        var ok = true;
        var errorElement;

        console.log("Username: " + username + " Email: " + email + " birthdate: " + birthdate + " password: " + password + " confirm: " + confirm);
        if (!isAlphaNumeric(username) || username.length > 20 || username == "") {
            ok = false;
            errorUser.innerHTML = "Can only contain alphanumeric characters and a max length of 20 characters.";
            errorUser.style.display = 'block';
        }
        if (!validateEmail(email) || email == "") {
            ok = false;
            errorMail.innerHTML = "It must be a valid email.";
            errorMail.style.display = 'block';

        }

        if (!validateDate(birthdate) || birthdate == "") {
            ok = false;
            errorDate.innerHTML = "It must be a valid date and must be well formatted. (DD-MM-YY).";
            errorDate.style.display = 'block';

        }

        if (!validatePassword(password) || password == "") {
            ok = false;
            errorPassword.innerHTML = "The length of the password must be between 6 and 12 characters and it must contain at least one number and one upper case letter.";
            errorPassword.style.display = 'block';

        }
        if (!revalidatePassword(password, confirm) || confirm == "") {
            ok = false;
            errorConfirmPass.innerHTML = "It must match with the value of the password field.";
            errorConfirmPass.style.display = 'block';

        }

        if (ok) {
            //$(this).submit();
            console.log("All oky, we send the form");
            return true;
        } else {
            // alert("Wrong data introduced");

        }
        $.ajax({
            type: 'POST',
            url: '/',
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

function isAlphaNumeric(name) {
    var code, i, len;

    for (i = 0, len = name.length; i < len; i++) {
        code = name.charCodeAt(i);
        if (!(code > 47 && code < 58) && // numeric (0-9)
            !(code > 64 && code < 91) && // upper alpha (A-Z)
            !(code > 96 && code < 123)) { // lower alpha (a-z)
            return false;
        }
    }
    return true;
}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateDate(birthdate) {

    var pattern = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    return pattern.test(birthdate);

}

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

function revalidatePassword(password1, password2) {
    return password1 === password2;

}