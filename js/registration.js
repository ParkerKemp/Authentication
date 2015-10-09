
$(document).ready(function(){
    var publicKeyE = $("#publicKeyE").val();
    var publicKeyN = $("#publicKeyN").val();
    var rsa = new RSAKey();
    rsa.setPublic(publicKeyN, publicKeyE);
    console.log("N: " + publicKeyN);
    console.log("E: " + publicKeyE);
    $('#submit').click(function(e){
        var password = Sha256.hash($("#password").val());
        console.log("Password: " + password);
        var encrypted = rsa.encrypt(password);
        console.log("Encrypted: " + encrypted);
        $("#password").val(encrypted);
        $("#registrationForm").submit();
    });
});