// $(document).ready(function () {
//     $('#login-submit').click(function () {

//         var username = $('#username1')[0].value;
//         var password = $('#password')[0].value;
//         const usrnamePattern = /^(?=[a-zA-Z0-9._]{8,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/g;
//         const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,32}$/gm;
//         if (!usrnamePattern.test(username)) {
//             validateOk = false;
//             var usernameErrMessage = "Username is required, have beetwen 8 and 32 words character, digit charactor and can be included dot, underscore";
//         }
//         if (!passwordPattern.test(password)) {
//             validateOk = false;
//             var passwordErrMessage = "Password is required, have beetwen 8 and 32 character, least one of word upper case, lowercase and digit "
//         }

//             if(!validateOk){
//                 if(usernameErrMessage && usernameErrMessage.length){
//                     document.getElementById("username-err").innerHTML = usernameErrMessage;
//                 }
//                 if(passwordErrMessage && passwordErrMessage.length){
//                     document.getElementById("password-err").innerHTML = passwordErrMessage;
//                 }
//             }

//     });


//     // console.log(formdata);
//     // $.ajax({
//     //     type: 'POST',
//     //     url: 'login.php',
//     //     cache: false,
//     //     data: formdata ? formdata : form.serialize(),
//     //     contentType: false,
//     //     processData: false,
//     //     dataType: 'json',

//     //     success: function (response) {
//     //         //TARGET THE MESSAGES DIV IN THE MODAL
//     //         if (response.type == 'success') {
//     //             $('#messages').addClass('alert alert-success').text(response.message);
//     //         } else {
//     //             $('#messages').addClass('alert alert-danger').text(response.message);
//     //         }
//     //     }
//     // });
//     // e.preventDefault();
// });
function loginHandling() {
    // alert("ahdaiuhdiu");
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