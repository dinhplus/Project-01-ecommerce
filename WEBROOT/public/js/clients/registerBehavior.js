function registerHandling() {
    var validateOk = true;
    var name = document.getElementById("name").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var cfPassword = document.getElementById("cf-password").value;
    var phone = document.getElementById("phone").value;
    var email = document.getElementById("email").value;
    var address = document.getElementById("address").value;
    var birth_date = document.getElementById("birth_date").value;
    console.log(birth_date);
    const namePattern = /^[a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/gm;
    const usernamePattern = /^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/gm;
    const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}$/gm;
    const phonePattern = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/gm;
    const emailPattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/gm;
        console.log(password==cfPassword);
    if(!namePattern.test(name) || name.length < 5){
        validateOk = false;
        var nameErrMessage = "name is require and have least 5 character";
        document.getElementById("r-name-err").innerHTML = nameErrMessage;
    }
    else{
        document.getElementById("r-name-err").innerHTML = "";
    }
    if ( (!usernamePattern.test(username)) || username.length < 6) {
        validateOk = false;
        var usernameErrMessage = "Username is required, have beetwen 8 and 32 words character, digit character and can be included dot, underscore";
        document.getElementById("r-username-err").innerHTML = usernameErrMessage;
    }
    else {
        document.getElementById("r-username-err").innerHTML = '';
    }
    if (!passwordPattern.test(password) || password.length < 6) {
        validateOk = false;
        var passwordErrMessage = "Password is required, have beetwen 8 and 32 character, least one of word upper case, lowercase and digit ";
        document.getElementById("r-password-err").innerHTML = passwordErrMessage;
    }
    else {
        document.getElementById("r-password-err").innerHTML = '';
    }
    if (password != cfPassword || cfPassword.length < 6) {
        validateOk = false;
        var passwordErrMessage = "Confirm password must be equal password";
        document.getElementById("cf-password-err").innerHTML = passwordErrMessage;
    }
    else {
        document.getElementById("cf-password-err").innerHTML = '';
    }
    if (!phonePattern.test(phone) || phone.length < 3) {
        validateOk = false;
        var phoneErrMessage = "Password is required and can be included only digit character, '+,-,(,)'";
        document.getElementById("phone-err").innerHTML = phoneErrMessage;
    }
    else {
        document.getElementById("phone-err").innerHTML = '';
    }
    if (email.length>0 && !emailPattern.test(email)) {
        validateOk = false;
        var emailErrMessage = "Email is optional which have format \"contact123@example.com \"";
        document.getElementById("email-err").innerHTML = emailErrMessage;
    }
    else {
        document.getElementById("email-err").innerHTML = '';
    }
    if(address.length < 5){
        validateOk = false;
        var addressErrMessage = "Address is required that have least 5 charactor";
        document.getElementById("address-err").innerHTML = addressErrMessage;
    }
    else{
        document.getElementById("address-err").innerHTML = '';
    }
    return validateOk;
}


function editUserProfileBehavior() {
    var validateOk = true;
    var name = document.getElementById("name").value;
    var username = document.getElementById("username").value;

    var phone = document.getElementById("phone").value;
    var email = document.getElementById("email").value;
    var address = document.getElementById("address").value;
    var birth_date = document.getElementById("birth_date").value;

    const namePattern = /^[a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/gm;
    const usernamePattern = /^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/gm;

    const phonePattern = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/gm;
    const emailPattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/gm;

    if(!namePattern.test(name) || name.length < 5){
        validateOk = false;
        var nameErrMessage = "name is require and have least 5 character";
        document.getElementById("r-name-err").innerHTML = nameErrMessage;
    }
    else{
        document.getElementById("r-name-err").innerHTML = "";
    }
    if ( (!usernamePattern.test(username)) || username.length < 6) {
        validateOk = false;
        var usernameErrMessage = "Username is required, have beetwen 6 and 32 words character, digit character and can be included dot, underscore";
        document.getElementById("r-username-err").innerHTML = usernameErrMessage;
    }
    else {
        document.getElementById("r-username-err").innerHTML = '';
    }

    if (!phonePattern.test(phone) || phone.length < 3) {
        validateOk = false;
        var phoneErrMessage = "Password is required and can be included only digit character, '+,-,(,)'";
        document.getElementById("phone-err").innerHTML = phoneErrMessage;
    }
    else {
        document.getElementById("phone-err").innerHTML = '';
    }
    if (email.length>0 && !emailPattern.test(email)) {
        validateOk = false;
        var emailErrMessage = "Email is optional which have format \"contact123@example.com \"";
        document.getElementById("email-err").innerHTML = emailErrMessage;
    }
    else {
        document.getElementById("email-err").innerHTML = '';
    }
    if(address.length < 5){
        validateOk = false;
        var addressErrMessage = "Address is required that have least 5 charactor";
        document.getElementById("address-err").innerHTML = addressErrMessage;
    }
    else{
        document.getElementById("address-err").innerHTML = '';
    }
    return validateOk;
}