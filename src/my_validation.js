/*
    File name: my_validation.js
    Functionality: implement client-side validation of user inputs
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

/*
    functionality: Check if username is valid.
            Username can only start with a letter which is followed by digits and letters.
    parameters: None
    return value: true if username is valid, false otherwise.
*/
function isValidUserame() {
    var username = $("#username").val();
    var reg = new RegExp("^[A-Za-z][A-Za-z0-9]+$");

    var flag = false;
    if(username.length === 0) {
        $("#validation-username").html("Please enter your username.");
    }
    else if(username.length > 25) {
        $("#validation-username").html("Please enter no more than 25 characters.");
    }
    else if(username.length < 2) {
        $("#validation-username").html("Please enter at least 2 characters.");
    }
    else if(reg.test(username) === false) {
        $("#validation-username").html("Please start with a letter and enter only letters and digits.");
    }
    else {
        $("#validation-username").html("Username is valid.");
        flag = true;
    }

    return flag;
}

/*
    functionality: Check if password is valid.
            Password can only contains letters and digits.
    parameters: None
    return value: true if password is valid, false otherwise.
*/
function isValidPassword() {
    var password = $("#password").val();
    var reg = new RegExp("^[A-Za-z0-9]+$");

    var flag = false;
    if(password.length === 0) {
        $("#validation-password").html("Please enter your password.");
    }
    else if(password.length > 25) {
        $("#validation-password").html("Please enter no more than 25 characters.");
    }
    else if(password.length < 6) {
        $("#validation-password").html("Please enter at least 6 characters.");
    }
    else if(reg.test(password) === false) {
        $("#validation-password").html("Please enter only letters and digits.");
    }
    else {
        $("#validation-password").html("Password is valid.");
        flag = true;
    }

    return flag;
}

/*
    functionality: Check if confirm-password matches password.
    parameters: None
    return value: true if confirm-password matches password, false otherwise.
*/
function isValidConfPassword() {
    var password = $("#password").val();
    var conf_password = $("#confirm-password").val();

    var flag = false;
    var vPassword = isValidPassword();
    if(vPassword === true) {
        if(conf_password.length === 0) {
            $("#validation-conf-password").html("Please confirm your password.");
        }
        else if(conf_password === password) {
            $("#validation-conf-password").html("Password is confirmed.");
            flag = true;
        }
        else {
            $("#validation-conf-password").html("Password does not match.");
        }
    }
    else {
        $("#validation-conf-password").html("");
    }
    
    return flag;
}

/*
    functionality: Check if first name is valid.
            First name can only start with a capital letter which is followed by lower-case letters.
    parameters: None
    return value: true if first name is valid, false otherwise.
*/
function isValidFirstname() {
    var firstname = $("#firstname").val();
    var reg = new RegExp("^[A-Z][a-z]+$");

    var flag = false;
    if(firstname.length === 0) {
        $("#validation-firstname").html("Please enter your first name.");
    }
    else if(firstname.length > 25) {
        $("#validation-firstname").html("Please enter no more than 25 characters.");
    }
    else if(reg.test(firstname) === false) {
        $("#validation-firstname").html("Please start with a capital letter and the following are only lower case letters.");
    }
    else {
        $("#validation-firstname").html("First name is valid.");
        flag = true;
    }

    return flag;
}

/*
    functionality: Check if last name is valid.
            Last name can only start with a capital letter which is followed by lower-case letters.
    parameters: None
    return value: true if last name is valid, false otherwise.
*/
function isValidLastname() {
    var lastname = $("#lastname").val();
    var reg = new RegExp("^[A-Z][a-z]+$");

    var flag = false;
    if(lastname.length === 0) {
        $("#validation-lastname").html("Please enter your last name.");
    }
    else if(lastname.length > 25) {
        $("#validation-lastname").html("Please enter no more than 25 characters.");
    }
    else if(reg.test(lastname) === false) {
        $("#validation-lastname").html("Please start with a capital letter and the following are only lower case letters.");
    }
    else {
        $("#validation-lastname").html("Last name is valid.");
        flag = true;
    }

    return flag;
}

/*
    functionality: Check if passport id is valid.
            Passport id can only contain capital letters and digits.
    parameters: None
    return value: true if passport id is valid, false otherwise.
*/
function isValidPassportId() {
    var passport_id = $("#passport-id").val();
    var reg = new RegExp("^[A-Z0-9]+$");

    var flag = false;
    if(passport_id.length === 0) {
        $("#validation-passport-id").html("Please enter your passport ID.");
    }
    else if(passport_id.length > 25) {
        $("#validation-passport-id").html("Please enter no more than 25 characters.");
    }
    else if(reg.test(passport_id) === false) {
        $("#validation-passport-id").html("Please enter only capital letters and digits.");
    }
    else {
        $("#validation-passport-id").html("Passport ID is valid.");
        flag = true;
    }

    return flag;
}

/*
    functionality: Check if telephone number is valid.
            Telephone number can only contain digits.
    parameters: None
    return value: true if telephone number is valid, false otherwise.
*/
function isValidTel() {
    var tel = $("#tel").val();
    var reg = new RegExp("^[0-9]+$");

    var flag = false;
    if(tel.length === 0) {
        $("#validation-tel").html("Please enter your telephone number.");
    }
    else if(tel.length > 25) {
        $("#validation-tel").html("Please enter no more than 25 characters.");
    }
    else if(reg.test(tel) === false) {
        $("#validation-tel").html("Please enter only digits.");
    }
    else {
        $("#validation-tel").html("Telephone number is valid.");
        flag = true;
    }

    return flag;
}

/*
    functionality: Check if email is valid.
            Email can only be in format "XXX@XXX.XXX.XXX".
    parameters: None
    return value: true if email is valid, false otherwise.
*/
function isValidEmail() {
    var email = $("#email").val();
    var reg = new RegExp("^[A-Za-z0-9]+([-_.][A-Za-z0-9]+)*@([A-Za-z0-9]+[-.])+[A-Za-z0-9]{2,4}$");

    var flag = false;
    if(email.length === 0) {
        $("#validation-email").html("Please enter your email.");
    }
    else if(email.length > 50) {
        $("#validation-email").html("Please enter no more than 50 characters.");
    }
    else if(reg.test(email) === false) {
        $("#validation-email").html("Please enter correct email.");
    }
    else {
        $("#validation-email").html("Email is valid.");
        flag = true;
    }

    return flag;
}

/*
    functionality: Check if quota is valid.
            Quota can only be a positive integer.
    parameters: None
    return value: true if quota is valid, false otherwise.
*/
function isValidQuota() {
    var quota = $("#salesrep-quota").val();
    var reg = new RegExp("^[0-9]+$");

    var flag = false;
    if (quota.length === 0) {
        $("#validation-quota").html("Please enter quota for salesrep.");
    }
    else if (reg.test(quota) === false) {
        $("#validation-quota").html("Please enter only positive integer.");
    }
    else {
        $("#validation-quota").html("Quota is valid.");
        flag = true;
    }

    return flag;
}

/*
    functionality: Check if employee id is valid.
            Employee id can only be a positive integer.
    parameters: None
    return value: true if employee id is valid, false otherwise.
*/
function isValidEmployeeid() {
    var employee_id = $("#employee-id").val();
    var reg = new RegExp("^[0-9]+$");

    var flag = false;
    if (employee_id.length === 0) {
        $("#validation-employee-id").html("Please enter an employee id of salesrep.");
    }
    else if (reg.test(employee_id) === false) {
        $("#validation-employee-id").html("Please enter only valid employee id of salesrep.");
    }
    else {
        $("#validation-employee-id").html("Employee id is valid.");
        flag = true;
    }

    return flag;
}