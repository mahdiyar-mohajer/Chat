<?php
require_once "../config.php";
$id = $_GET['id'];
if (SAVE_DATA === 'JSON'){
    $messages = json_decode(file_get_contents("../storage/message.json"), true);
}
if (SAVE_DATA === 'MYSQL'){
    //todo database connection
}

foreach ($messages as $key => &$message){
    if ($message['id'] == $id){
        unset($messages[$key]);

        echo 'message with number ' . $id.  ' is deleted';
    }
}
if (SAVE_DATA === 'JSON'){
    $jsonData = json_encode($messages);
    file_put_contents("../storage/message.json", $jsonData);
}
if (SAVE_DATA === 'MYSQL'){
    //todo database connection
}
