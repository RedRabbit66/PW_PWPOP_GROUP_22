function comprovaUpload_Name() {
    console.log("Entrando en Validation.js - Comprova Upload_Name");
    var textError = '';
    var product_name = document.getElementById('uploadProduct_Name').value;
    //Name not empty
    if (product_name.length == 0) {
        textError = document.createTextNode("*This field is required");
        document.getElementById('errorUpload_Name').textContent = '';
        document.getElementById('errorUpload_Name').appendChild(textError);
        document.getElementById('uploadProduct_Name').style.borderColor = "red";
    } else {
        document.getElementById('errorUpload_Name').textContent = '';
        document.getElementById('uploadProduct_Name').style.borderColor = "green";
    }
}

function comprovaUpload_Description(){
    console.log("Entrando en Validation.js - Comprova Upload_Description");
    var textError = '';
    var product_description = document.getElementById('uploadProduct_Description').value;
    //Description min length = 20
    if (product_description.length == 0) {
        document.getElementById('errorUpload_Description').textContent = '';
        document.getElementById('uploadProduct_Description').style.borderColor = "white";
    } else if (product_description.length < 20) {
        textError = document.createTextNode("*This field must be at least 20 characters long.");
        document.getElementById('errorUpload_Description').textContent = '';
        document.getElementById('errorUpload_Description').appendChild(textError);
        document.getElementById('uploadProduct_Description').style.borderColor = "red";
    } else {
        document.getElementById('errorUpload_Description').textContent = '';
        document.getElementById('uploadProduct_Description').style.borderColor = "green";
    }
}

function comprovaUpload_Category(){
    console.log("Entrando en Validation.js - Comprova Upload_Category");
    console.log(document.getElementById('uploadProduct_Category').selectedIndex);
    var textError = '';
    var product_category = document.getElementById('uploadProduct_Category').selectedIndex;
    //Category must be chosen
    if (product_category == 0){
        textError = document.createTextNode("*Please select a category");
        document.getElementById('errorUpload_Category').textContent = '';
        document.getElementById('errorUpload_Category').appendChild(textError);
        document.getElementById('uploadProduct_Category').style.borderColor = "red";
    } else{
        document.getElementById('errorUpload_Category').textContent = '';
        document.getElementById('uploadProduct_Category').style.borderColor = "green";
    }
}

function comprovaUpload_Price(){
    var priceRegex = /^[0-9]+$/;
    console.log("Entrando en Validation.js - Comprova Upload_Price");
    var textError = '';
    var product_price = document.getElementById('uploadProduct_Price').value;
    //Price must be a valid number
    if (product_price < 0 || !priceRegex.test(product_price)){
        textError = document.createTextNode("*Please enter a valid integer positive price value");
        document.getElementById('errorUpload_Price').textContent = '';
        document.getElementById('errorUpload_Price').appendChild(textError);
        document.getElementById('uploadProduct_Price').style.borderColor = "red";
    }else{
        document.getElementById('errorUpload_Price').textContent = '';
        document.getElementById('uploadProduct_Price').style.borderColor = "green";
    }
}

function comprovaInput(update) {
    console.log("Enrando en Validation.js - Comprova input");
    var usernameRegex = /^[A-Za-z0-9]+$/i;
    var emailRegex = /^\S+@\S+\.\S+$/;
    var telephoneRegex = /^[0-9]+$/;
    var passwordRegex = /^(?=(?:.*\d){1})(?=(?:.*[A-Z]){1})\S+$/;
    var textError = '';

    //CAMPOS A COMPROBAR SOLO SI ES REGISTER O UPDATE
    if (update == 'login') {
        //USERNAME-MAIL LOGIN VALIDATION
        var usernameLogin = document.getElementById('usernameLogin').value;

        if (usernameLogin.length == 0) {
            document.getElementById('error1').textContent = '';
            document.getElementById('usernameLogin').style.borderColor = "white";
        } else {
            if (!usernameLogin.includes('@')) {
                if (usernameRegex.test(usernameLogin)) {
                    document.getElementById('error1').textContent = '';
                    document.getElementById('error1_1').textContent = '';
                    document.getElementById('usernameLogin').style.borderColor = "green";

                } else {
                    textError = document.createTextNode("*Only alphanumeric characters");
                    document.getElementById('error1').textContent = '';
                    document.getElementById('error1').appendChild(textError);
                    document.getElementById('usernameLogin').style.borderColor = "red";
                }

                if (usernameLogin.length > 20) {
                    textError = document.createTextNode("*Maximum 20 characters");
                    document.getElementById('error1_1').textContent = '';
                    document.getElementById('error1_1').appendChild(textError);
                    document.getElementById('usernameLogin').style.borderColor = "red";
                }
            } else {
                if (emailRegex.test(usernameLogin)) {
                    document.getElementById('error1').textContent = '';
                    document.getElementById('usernameLogin').style.borderColor = "green";
                } else {
                    textError = document.createTextNode("*Must input a valid email address");
                    document.getElementById('error1').textContent = '';
                    document.getElementById('error1').appendChild(textError);
                    document.getElementById('usernameLogin').style.borderColor = "red";
                }
            }
        }
        //comprovar si el username existe ya en la app
    }

    if (update != 'login') {
        var name = document.getElementById('name').value;
        var username = document.getElementById('username').value;
        var email = document.getElementById('email').value;
        var birthday = document.getElementById('birthday').value;
        var phoneNumber = document.getElementById('phoneNumber').value;
        var confirmPassword = document.getElementById('confirmPassword').value;
        //hacer el get de la prifile image

        //COMPROBACION NAME
        if (name.length == 0) {
            document.getElementById('error0').textContent = '';
            document.getElementById('name').style.borderColor = "white";
        } else {
            document.getElementById('error0').textContent = '';
            document.getElementById('name').style.borderColor = "green";
        }

        //COMPROBACION USERNAME
        if (username.length == 0) {
            document.getElementById('error1').textContent = '';
            document.getElementById('username').style.borderColor = "white";
        } else {
            if (usernameRegex.test(username)) {
                document.getElementById('error1').textContent = '';
                document.getElementById('username').style.borderColor = "green";
            } else {
                textError = document.createTextNode("*Only alphanumeric characters");
                document.getElementById('error1').textContent = '';
                document.getElementById('error1').appendChild(textError);
                document.getElementById('username').style.borderColor = "red";
            }
            if (username.length > 20) {
                textError = document.createTextNode("*Maximum 20 characters");
                document.getElementById('error1_1').textContent = '';
                document.getElementById('error1_1').appendChild(textError);
                document.getElementById('username').style.borderColor = "red";
            }
        }


        //COMPROBACION MAIL
        if (email.length == 0) {
            document.getElementById('error2').textContent = '';
            document.getElementById('email').style.borderColor = "white";
        } else {
            if (emailRegex.test(email)) {
                document.getElementById('error2').textContent = '';
                document.getElementById('email').style.borderColor = "green";
            } else {
                textError = document.createTextNode("*Must input a valid email address");
                document.getElementById('error2').textContent = '';
                document.getElementById('error2').appendChild(textError);
            }
        }


        //COMPROBACIÓN BIRTHDAy
        if (birthday.length == 0) {
            document.getElementById('error3').textContent = '';
            document.getElementById('birthday').style.borderColor = "white";
        } else {
            if (!isValidDate(birthday)) {
                textError = document.createTextNode("*Input a valid date");
                document.getElementById('error3').textContent = '';
                document.getElementById('error3').appendChild(textError);
                document.getElementById('birthday').style.borderColor = "red";
            } else {
                document.getElementById('error3').textContent = '';
                document.getElementById('birthday').style.borderColor = "green";
            }
        }


        //COMPROBACIÓN PHONE NUMBER
        console.log(phoneNumber.length);
        console.log(phoneNumber.value);
        if (phoneNumber.length < 9) {
            document.getElementById('error6').textContent = '';
            document.getElementById('phoneNumber').style.borderColor = "white";
            if (!telephoneRegex.test(phoneNumber) && phoneNumber.length >= 1){
                textError = document.createTextNode("*Phone number should only contain digits");
                document.getElementById('error6').textContent = '';
                document.getElementById('error6').appendChild(textError);
                document.getElementById('phoneNumber').style.borderColor = "red";
            }
        }else if (!telephoneRegex.test(phoneNumber)) {
            textError = document.createTextNode("*Phone number should only contain digits");
            document.getElementById('error6').textContent = '';
            document.getElementById('error6').appendChild(textError);
            document.getElementById('phoneNumber').style.borderColor = "red";
        } else if(phoneNumber.length>9) {
            textError = document.createTextNode("*Field must follow XXXXXXXXX format");
            document.getElementById('error6').textContent = '';
            document.getElementById('error6').appendChild(textError);
            document.getElementById('phoneNumber').style.borderColor = "red";
        }else{
            document.getElementById('error6').textContent = '';
            document.getElementById('phoneNumber').style.borderColor = "green";
        }
    }

    //PASSWORD VALIDATION
    var password = document.getElementById('password').value;

    if (password.length == 0) {
        document.getElementById('error4').textContent = '';
        document.getElementById('password').style.borderColor = "white";
    } else {
        if (password.length < 6 || password.length > 12) {
            textError = document.createTextNode("*Password must be 6 to 12 characters long");
            document.getElementById('error4').textContent = '';
            document.getElementById('error4').appendChild(textError);
        } else if (!passwordRegex.test(password)) {
            textError = document.createTextNode("*Password must at least contain one number and a capital letter.");
            document.getElementById('error4').textContent = '';
            document.getElementById('error4').appendChild(textError);
            document.getElementById('password').style.borderColor = "red";
        } else {
            document.getElementById('error4').textContent = '';
            document.getElementById('password').style.borderColor = "green";
        }
    }

    if (update != 'login'){
        //COMPROBACIÓN CONFIRMPASS
        if (password.length == 0) {
            document.getElementById('error5').textContent = '';
            document.getElementById('confirmPassword').style.borderColor = "white";
        }else{
            if (confirmPassword.length == 0){
                document.getElementById('error5').textContent = '';
                document.getElementById('confirmPassword').style.borderColor = "white";
            }else{
                if (confirmPassword != password) {
                    textError = document.createTextNode("*Password mismatch");
                    document.getElementById('error5').textContent = '';
                    document.getElementById('error5').appendChild(textError);
                    document.getElementById('password').style.borderColor = "red";
                    document.getElementById('confirmPassword').style.borderColor = "red";
                } else{
                    document.getElementById('confirmPassword').style.borderColor = "green";
                    document.getElementById('password').style.borderColor = "green";
                    document.getElementById('error5').textContent = '';
                }
            }

        }
    }
}
function sendForm(form, delete_user) {
    var id = document.getElementById(form.id).id;
    document.getElementById(id).submit();
}

function isValidDate(birthdate) {
    if (!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(birthdate))
        return false;

    var parts = birthdate.split("/");
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);

    if (year < 1900 || year > 2020 || month == 0 || month > 12) {
        return false;
    }
    if (month < 0 || month > 12){
        return false;
    }
    var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0)){
        monthLength[1] = 29;
    }
    return ((day > 0) && (day <= monthLength[month - 1]));
}