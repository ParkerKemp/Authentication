<?php

echo getHeaders();

if (true || isset($_GET['accessKey'])) {
    handleAccessKey($_GET['accessKey']);
} else {
    displayError();
}

function handleAccessKey($accessKey) {
    echo getForm();
}

function getPublicKey() {
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 1024,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );
    $res = openssl_pkey_new($config);
    $privateKey = '';
    openssl_pkey_export($res, $privateKey);
    $publicKey = openssl_pkey_get_details($res);
    $publicKey = $publicKey["key"];
    $_SESSION['priv'] = $privateKey;
    return $publicKey;
}

function displayError() {
    echo "You need an access key!";
}

function getForm() {
    $div = '<div class="outer"><div class="middle"><div class="inner">';
    $div .= '<form action="" method="POST">';
    $div .= 'Username: <input type="text" name="username"></input><br><br>';
    $div .= 'Password: <input type="password" name="password"></input>';
    
    $div .= '</form></div></div></div>';
    return $div;
}

function getHeaders(){
    $headers = '<link rel="stylesheet" type="text/css" href="css/registration.css"></script>';
    $headers .= '<script src="js/jsbn/jsbn.js"></script>';
    $headers .= '<script src="js/jsbn/prng4.js"></script>';
    $headers .= '<script src="js/jsbn/rng.js"></script>';
    $headers .= '<script src="js/jsbn/rsa.js"></script>';
    $headers .= '<script src="js/jsbn/sha256.js"></script>';
    $headers .= '<script src="js/jquery/jquery.min.js"></script>';
    $headers .= '<script src="js/registration.js"></script>';
    return $headers;
}