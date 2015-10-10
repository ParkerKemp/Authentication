<?php

$username = $_POST['username'];

$stmt = Database::getInstance()->prepare("SELECT * FROM actors WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if($result->fetch_assoc()){
    echo "bad";
}
else{
    echo "good";
}