$(document).ready(function() {
    $('#register').submit(function (event) {
        errorName = document.getElementById("errorName");
        errorUser = document.getElementById("errorUser");
        errorUserMail = document.getElementById("errorMail");
        errorDate = document.getElementById("errorBirthdate");
        errorNumber = document.getElementById("errorNumber");
        errorPassword = document.getElementById("errorPassword");
        errorConfirmPassword = document.getElementById("errorConfirm");
        errorImage = document.getElementById("errorImage");

        errorName.innerHTML = "";
        errorUser.innerHTML = "";
        errorUserMail.innerHTML = "";
        errorDate.innerHTML = "";
        errorNumber.innerHTML = "";
        errorPassword.innerHTML = "";
        errorConfirmPassword.innerHTML = "";
        errorImage.innerHTML = "";

        var data = $(this).serialize();
        var name = document.forms["register"]["name"].value;
        var username = document.forms["register"]["username"].value;
        var email = document.forms["register"]["email"].value;
        var birthdate = document.forms["register"]["birthdate"].value;
        var phoneNumber = document.forms["register"]["phoneNumber"].value;
        var password = document.forms["register"]["password"].value;
        var confirm = document.forms["register"]["confirm"].value;
        var image = document.forms["register"]["image"].value;

        var ok = true;
        var errorElement;

        console.log("Name: " + name + "Username: " + username + " Email: " + email + " birthdate: " + birthdate + " password: " + password + " confirm: " + confirm);

        if(!isAlphaNumeric(name) || name == ""){
            ok = false;
            errorName.innerHTML = "This field is required. It can only contain alphanumeric characters";
            errorName.style.display = 'block';
        }


        if (!isAlphaNumeric(username) || username.length > 20 || username == "") {
            ok = false;
            errorUser.innerHTML = "This value is required. It can only contain alphanumeric characters and should never exceed the 20 characters";
            errorUser.style.display = 'block';
        }
        if (!validateEmail(email) || email == "") {
            ok = false;
            errorUserMail.innerHTML = "This field is required. It must be a valid email address";
            errorUserMail.style.display = 'block';

        }
        if (birthdate != ""){
            if (!isValidDate(birthdate) || !isCorrectDate(birthdate)) {
                ok = false;
                errorDate.innerHTML = "It must be a valid date formatted as \"mm/dd/yyyy\"";
                errorDate.style.display = 'block';

            }
        }

        if (phoneNumber.length != 9 || !isNaN(phoneNumber)){
            ok = false;
            errorNumber.innerHTML = "This field is required. Must follow the format nxx xxx xxx"
        }

        if (!(password.length > 5) || password == "") {
            ok = false;
            errorPassword.innerHTML = "It must contain at least 6 characters";
            errorPassword.style.display = 'block';

        }
        if (!revalidatePassword(password, confirm) || confirm == "") {
            ok = false;
            errorConfirmPassword.innerHTML = "It must match with the value of the password field.";
            errorConfirmPassword.style.display = 'block';

        }
        //Això s'ha de validar en PHP (al Servidor)
        /*
        if (!validateFile(image)){
            ok = false;
            errorImage.innerHTML = "Bad extension";
            errorImage.style.display = 'block';
        }*/

        //Això s'ha de validar en PHP (al Servidor)
        /*if (!isValidSize(image)){
            ok = false;
            errorImage.innerHTML = "File can't exeed from 500Kb";
            errorImage.style.display = 'block';
        }*/

        if (ok) {
            //$(this).submit();
            console.log("Data summited is correct");
            return true;
        } else {
            console.log("Wrong data summited");

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



function revalidatePassword(password1, password2) {
    return password1 === password2;

}

function isCorrectDate(birthdate) {

    // First check for the pattern
    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(birthdate))
        return false;

    // Parse the date parts to integers
    var parts = birthdate.split("/");
    var day = parseInt(parts[1], 10);
    var month = parseInt(parts[0], 10);
    var year = parseInt(parts[2], 10);


    var date = new Date();
    date.setFullYear(year, month - 1, day);
    // month - 1 since the month index is 0-based (0 = January)

    if ( (date.getFullYear() == year) && (date.getMonth() == month + 1) && (date.getDate() == day) )
        return true;

    return false;
}

// Validates that the input string is a valid date formatted as "mm/dd/yyyy"
function isValidDate(birthdate)
{
    // First check for the pattern
    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(birthdate))
        return false;

    // Parse the date parts to integers
    var parts = birthdate.split("/");
    var day = parseInt(parts[1], 10);
    var month = parseInt(parts[0], 10);
    var year = parseInt(parts[2], 10);



    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];


}


function validateFile(image)
{
    var allowedExtension = ['jpg', 'png'];
    var fileExtension = image.value.split('.').pop().toLowerCase();
    var isValidFile = false;

    for(var index in allowedExtension) {

        if(fileExtension === allowedExtension[index]) {
            isValidFile = true;
            break;
        }
    }

    return isValidFile;
}

function isValidSize(image) {
    var FileSize = image.files[0].size / 1024; // in KB
    if (FileSize > 500) {
        return false;
    }
    return true;
}