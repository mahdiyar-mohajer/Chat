<?php
require_once "../config.php";
$id = $_GET['id'];

$messages = json_decode(file_get_contents("../storage/message.json"), true);

foreach ($messages as $key => &$message){
    if ($message['id'] == $id){
        unset($messages[$key]);

        echo 'message with number ' . $id.  ' is deleted';
    }
}
$jsonData = json_encode($messages);
file_put_contents("../storage/message.json", $jsonData);
