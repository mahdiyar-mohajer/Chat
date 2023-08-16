<?php
require_once "../config.php";
$id = $_GET['id'];
if (SAVE_DATA === 'JSON'){
    $users = json_decode(file_get_contents("../storage/users.json"), true);
    foreach ($users as &$user){
        if ($user['id'] == $id){
            $user['admin'] = true;

            echo $user['name'] . ' is admin now';
        }
    }
    $jsonData = json_encode($users);
    file_put_contents("../storage/users.json", $jsonData);
}

if (SAVE_DATA === 'MYSQL'){
    $db = new PDO('mysql:host=mysql;dbname=chatroom', 'mahdiyar', 123456);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $query = "UPDATE users SET admin = 1 WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}
