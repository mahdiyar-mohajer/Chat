<?php
require_once "../config.php";
$id = $_GET['id'];
if (SAVE_DATA === 'JSON'){
    $users = json_decode(file_get_contents("../storage/users.json"), true);
}
if (SAVE_DATA === 'MYSQL'){
    //todo database connection
}
foreach ($users as &$user){
    if ($user['id'] == $id){
        $user['block'] = true;

        echo $user['name'] . ' is block now';
    }
}
if (SAVE_DATA === 'JSON'){
    $jsonData = json_encode($users);
    file_put_contents("../storage/users.json", $jsonData);
}
if (SAVE_DATA === 'MYSQL'){
    //todo database connection
}
