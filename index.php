<?php

if(isset($_GET['accessKey'])){
    handleAccessKey($_GET['accessKey']);
}
else{
    displayError();
}

function handleAccessKey($accessKey){
    echo "You have an access key!";
}

function displayError(){
    echo "You need an access key!";
}