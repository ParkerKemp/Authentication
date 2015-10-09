$(document).ready(function(){
    console.log("Hashed password: " + localStorage.getItem("password"));
    var publicKeyE = $("#publicKeyE").val();
    var publicKeyN = $("#publicKeyN").val();
    var rsa = new RSAKey();
    rsa.setPublic(publicKeyN, publicKeyE);
    console.log("N: " + publicKeyN);
    console.log("E: " + publicKeyE);
    $('#submitButton').click(function(e){
        var passwordHash = Sha256.hash($("#password").val());
        localStorage.setItem("password", passwordHash);
        console.log("Password: " + passwordHash);
        var encrypted = rsa.encrypt(passwordHash);
        console.log("Encrypted: " + encrypted);
        $("#password").val(encrypted);
//        document.
        $("#registrationForm").submit();
    });
});