<?php
require_once "../config.php";
$id = $_GET['id'];
if (SAVE_DATA === 'JSON'){
    $messages = json_decode(file_get_contents("../storage/message.json"), true);
    foreach ($messages as $key => &$message){
        if ($message['id'] == $id){
            unset($messages[$key]);

            echo 'message with number ' . $id.  ' is deleted';
        }
    }
    $jsonData = json_encode($messages);
    file_put_contents("../storage/message.json", $jsonData);
}

if (SAVE_DATA === 'MYSQL'){
    $db = new PDO('mysql:host=mysql;dbname=chatroom', 'mahdiyar', 123456);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $query = "DELETE FROM messages WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location: dashboard.php");
}
