function removeAscent (str) {
    if (str === null || str === undefined) return str;
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    return str;
}
function isValidName (string) {
    var re = /^[\w\s ]{2,}$/g // regex here
    return re.test(removeAscent(string))
  }
function createStaffHandling() {
    var validateOk = true;
    var displayname = document.getElementById("displayname").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var cfPassword = document.getElementById("cf-password").value;

    const usernamePattern = /^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/gm;
    const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}$/gm;

    console.log(password == cfPassword);
    if (!isValidName(displayname)) {
        validateOk = false;
        var nameErrMessage = "displayName is require and have least 2 character";
        document.getElementById("displayname-err").innerHTML = nameErrMessage;
    }
    else {
        document.getElementById("displayname-err").innerHTML = "";
    }
    if ((!usernamePattern.test(username)) || username.length < 5) {
        validateOk = false;
        var usernameErrMessage = "Username is required, have beetwen 5 and 32 words character, digit character and can be included dot, underscore";
        document.getElementById("username-err").innerHTML = usernameErrMessage;
    }
    else {
        document.getElementById("username-err").innerHTML = '';
    }
    if (!passwordPattern.test(password) || password.length < 6) {
        validateOk = false;
        var passwordErrMessage = "Password is required, have beetwen 6 and 32 character, least one of word upper case, lowercase and digit ";
        document.getElementById("password-err").innerHTML = passwordErrMessage;
    }
    else {
        document.getElementById("password-err").innerHTML = '';
    }
    if (password != cfPassword || cfPassword.length < 6) {
        validateOk = false;
        var passwordErrMessage = "Confirm password must be equal password";
        document.getElementById("cf-password-err").innerHTML = passwordErrMessage;
    }
    else {
        document.getElementById("cf-password-err").innerHTML = '';
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
    const usernamePattern = /^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/gm;

    const phonePattern = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/gm;
    const emailPattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/gm;

    if (!isValidName(name)) {
        validateOk = false;
        var nameErrMessage = "name is require and have least 2 character";
        document.getElementById("r-name-err").innerHTML = nameErrMessage;
    }
    else {
        document.getElementById("r-name-err").innerHTML = "";
    }
    if ((!usernamePattern.test(username)) || username.length < 6) {
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
    if (email.length > 0 && !emailPattern.test(email)) {
        validateOk = false;
        var emailErrMessage = "Email is optional which have format \"contact123@example.com \"";
        document.getElementById("email-err").innerHTML = emailErrMessage;
    }
    else {
        document.getElementById("email-err").innerHTML = '';
    }
    if (!isValidName(address)) {
        validateOk = false;
        var addressErrMessage = "Address is required that have least 2 charactor";
        document.getElementById("address-err").innerHTML = addressErrMessage;
    }
    else {
        document.getElementById("address-err").innerHTML = '';
    }
    return validateOk;
}
function updatePasswordBehavior() {
    var validateOk = true;
    var password = document.getElementById("password").value;
    var newPassword = document.getElementById("new-password").value;
    var cfNewPassword = document.getElementById("cf-new-password").value;
    const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}$/gm;
    const newPasswordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}$/gm;
    if ((!passwordPattern.test(password)) || password.length < 6) {
        validateOk = false;
        var passwordErrMessage = "Password is required, have beetwen 6 and 32 character, least one of word upper case, lowercase and digit ";
        document.getElementById("password-err").innerHTML = passwordErrMessage;
    }
    else {
        document.getElementById("password-err").innerHTML = '';
    }
    if ((!newPasswordPattern.test(newPassword)) || newPassword.length < 6) {
        validateOk = false;
        var newPasswordErrMessage = "New Password is required, have beetwen 6 and 32 character, least one of word upper case, lowercase and digit ";
        document.getElementById("new-password-err").innerHTML = newPasswordErrMessage;
    }
    else {
        document.getElementById("new-password-err").innerHTML = '';
    }
    if (newPassword != cfNewPassword || cfNewPassword.length < 6) {
        validateOk = false;
        var cfNewPasswordErrMessage = "Confirm new password must be equal new password";
        document.getElementById("cf-new-password-err").innerHTML = cfNewPasswordErrMessage;
    }
    else {
        document.getElementById("cf-new-password-err").innerHTML = '';
    }
    return validateOk

}

function loginHandling() {
    var validateOk = true;
    var username = document.getElementById("username1").value;
    var password = document.getElementById("password1").value;
    console.log(username);
    const usrnamePattern = /^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/gm;
    const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}$/gm;
    if (!usrnamePattern.test(username)) {
        validateOk = false;
        var usernameErrMessage = "Username is required, have beetwen 8 and 32 words character, digit charactor and can be included dot, underscore";
        document.getElementById("username-err").innerHTML = usernameErrMessage;
    }
    else {
        document.getElementById("username-err").innerHTML = '';
    }
    if (!passwordPattern.test(password)) {
        validateOk = false;
        var passwordErrMessage = "Password is required, have beetwen 8 and 32 character, least one of word upper case, lowercase and digit ";
        document.getElementById("password-err").innerHTML = passwordErrMessage;
    }
    else {
        document.getElementById("password-err").innerHTML = '';
    }
    return validateOk;
}
function cancelOrderConfirm(){
    var reason = window.prompt("Enter the reason:");
    if(reason){
        document.getElementById("change_status_note").value = "Customer cancel because: <br> " + reason ;
        return true;
    }
    else return false;

}
function confirmOrderHandling(){
    var validateOk = true;
    var name = document.getElementById("name").value;
    var phone = document.getElementById("phone").value;
    var address = document.getElementById("address").value;
    var note = document.getElementById("note").value;
    const phonePattern = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/gm;
    if (!isValidName(name)) {
        validateOk = false;
        var nameErrMessage = "name is require and have least 2 character";
        document.getElementById("r-name-err").innerHTML = nameErrMessage;
    }
    else {
        document.getElementById("r-name-err").innerHTML = "";
    }

    if (!phonePattern.test(phone) || phone.length < 3) {
        validateOk = false;
        var phoneErrMessage = "Phone number is required and can be included only digit character, '+,-,(,)'";
        document.getElementById("phone-err").innerHTML = phoneErrMessage;
    }
    else {
        document.getElementById("phone-err").innerHTML = '';
    }

    if (!isValidName(address)) {
        validateOk = false;
        var addressErrMessage = "Address is required that have least 5 charactor";
        document.getElementById("address-err").innerHTML = addressErrMessage;
    }
    else {
        document.getElementById("address-err").innerHTML = '';
    }
    if(note.length > 0 &&!isValidName(note) ){
        validateOk = false;
        var noteErrMessage = "Address is required that have least 5 charactor";
        document.getElementById("note-err").innerHTML = noteErrMessage;
    }
    else {
        document.getElementById("note-err").innerHTML = '';
    }
    if(validateOk){
        return confirm("Are your sure? This action cannot revert.");
    }
    else return false;
}
function decrease(pid){
    var qttForm = document.getElementById(`formQtt-${pid}`);
    qttForm.style.display = "block";
    var qtt = document.getElementById(`qtt-${pid}`);
    if(qtt.value > 0) {
        qtt.value = qtt.value -1;
    } else qtt.value = 0;
}
function increase(pid){
    var qttForm = document.getElementById(`formQtt-${pid}`);
    qttForm.style.display = "block";
    var qtt = document.getElementById(`qtt-${pid}`);

        qtt.value = parseInt(qtt.value) + 1;

}