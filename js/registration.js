$(document).ready(function(){
    console.log("Hashed password: " + localStorage.getItem("password"));
    var publicKeyE = $("#publicKeyE").val();
    var publicKeyN = $("#publicKeyN").val();
    var rsa = new RSAKey();
    rsa.setPublic(publicKeyN, publicKeyE);
    console.log("N: " + publicKeyN);
    console.log("E: " + publicKeyE);
    $('#submitButton').click(function(e){
        $(".error").remove();
        if(!(validateUsername() && validatePassword()))
            return;
        var passwordHash = Sha256.hash($("username").val() + "spinalcraft" + $("#password").val());
        localStorage.setItem("password", passwordHash);
        console.log("Password: " + passwordHash);
        var encrypted = rsa.encrypt(passwordHash);
        console.log("Encrypted: " + encrypted);
        $("#password").val(encrypted);
//        document.
        $("#registrationForm").submit();
    });
});

function validateUsername(){
   var good = true;
   
   good &= usernameIsFormattedCorrectly();
   
   good &= usernameNotTaken();
   
   return good;
}

function usernameNotTaken(){
    var username = $("#username").val();
    var good = false;
    $.ajax({
        async: false,
        type: "POST",
        url: "index.php",
        data: {
            redirectFilename: "php/scripts/ValidateUsername.php",
            username: username
        },
        success: function(response){
            if(response === "good"){
                good = true;
            }
            else{
                console.log(response);
            }
        }
    });

    if(!good){
        validationError(document.getElementById("username"), "This username is already taken!");
    }
    
    return good;
}

function usernameIsFormattedCorrectly(){
    var username = $("#username").val();
    var pattern = RegExp("^[A-Za-z0-9_]{4,16}$");
    if(pattern.test(username)){
        return true;
    }
    else{
        validationError(document.getElementById("username"), "Username must be 4 to 16 characters and may contain only letters, numbers and underscores.");
        return false;
    }
}

function validatePassword(){
    var good = true;
    
    good &= passwordIsFormattedCorrectly();
    
    good &= passwordsMatch();
    
    return good;
}

function passwordsMatch(){
    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();
    
    if(password === confirmPassword){
        return true;
    }
    else{
        validationError(document.getElementById("confirmPassword"), "Password does not match!");
        return false;
    }
}

function passwordIsFormattedCorrectly(){
    var password = $("#password").val();
    var pattern = new RegExp("^(?=.*[A-Za-z])(?=.*\\d)[A-Za-z\\d]{8,}$");
    if(pattern.test(password)){
        return true;
    }
    else{
        validationError(document.getElementById("password"), "Password must be at least 8 characters long and contain at least one digit.");
        return false;
    }
}

function validationError(input, errorMessage){
    var error = document.createElement("p");
    var form = document.getElementById("registrationForm");
    error.innerHTML = errorMessage;
    error.className = "error";
    
    form.insertBefore(error, input);
}