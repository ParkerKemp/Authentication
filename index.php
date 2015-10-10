<?php

session_start();

require_once 'AutoLoad.php';

if(isset($_POST['redirectFilename'])){
    require_once $_POST['redirectFilename'];
    die();
}

?>

<html>
    <body background="resources/background.png">

<?php
echo getHeaders();

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['accessKey'])){
    $request = new RegistrationRequest($_POST['username'], $_POST['password'], $_POST['accessKey']);
    $request->process();
}

if (isset($_GET['accessKey'])) {
    handleAccessKey($_GET['accessKey']);
} else {
    displayError();
}

function handleAccessKey($accessKey) {
    echo getForm(getPublicKey(), $accessKey);
}

function getPublicKey() {
    if(!isset($_SESSION['priv'])){
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 1024,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $res = openssl_pkey_new($config);
        $privateKey = '';
        openssl_pkey_export($res, $privateKey);
        $_SESSION['priv'] = $privateKey;
    }
    else{
        $res = openssl_pkey_get_private($_SESSION['priv']);
    }
    $publicKey = openssl_pkey_get_details($res);
//    $publicKey = $publicKey["key"];
    return $publicKey;
}

function displayError() {
    echo "You are not authorized to view this page!";
}

function getForm($publicKey, $accessKey) {
    $div = '<div class="outer"><div class="middle"><div class="inner">';
    $div .= '<form id="registrationForm" action="" method="POST">';
    
    $div .= '<input id="publicKeyN" type="hidden" value="' . Utils::toHex($publicKey['rsa']['n']) . '"></input>';
    $div .= '<input id="publicKeyE" type="hidden" value="' . Utils::toHex($publicKey['rsa']['e']) . '"></input>';
    $div .= '<input id="accessKey" name="accessKey" type="hidden" value="' . $accessKey . '"></input>';
    
    $div .= 'Username: <input id="username" type="text" name="username"></input><br><br>';
    $div .= 'Password: <input id="password" type="password" name="password"></input><br><br>';
    $div .= 'Confirm password: <input id="confirmPassword" type="password" name="confirmPassword"></input><br><br>';
    
    $div .= '<input id="submitButton" type="button" value="Submit"></input>';
    
    $div .= '</form></div></div></div>';
    return $div;
}

function getHeaders(){
    $headers = Utils::cssTag("css/registration.css");
    $headers .= Utils::jsTag("js/jsbn/jsbn.js");
    $headers .= Utils::jsTag("js/jsbn/prng4.js");
    $headers .= Utils::jsTag("js/jsbn/rng.js");
    $headers .= Utils::jsTag("js/jsbn/rsa.js");
    $headers .= Utils::jsTag("js/jsbn/sha256.js");
    $headers .= Utils::jsTag("js/jquery/jquery.min.js");
    $headers .= Utils::jsTag("js/registration.js");
    return $headers;
}

?>
        
    </body>
</html>