<?php
session_start();
require_once "../config.php";
function getUploadDirectory()
{
    if (SAVE_DATA === 'JSON'){
        $users = json_decode(file_get_contents("../storage/users.json"), true);
    }
    if (SAVE_DATA === 'MYSQL'){
        //todo database connection
    }
    $username = $_SESSION['username'];
    $loginUser = [];
    foreach ($users as $user) {
        if ($user['user_name'] == $username) {
            $loginUser = $user;
        }
    }

    return realpath('../storage/users folder/' . $loginUser['user_name']) . '/' . time();
}
$targetFile = '';
if (isset($_FILES['file'])) {
    $targetDir = getUploadDirectory();

    $fileToUpload = $_FILES["file"];
    $targetFile = $targetDir . basename($fileToUpload["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($fileToUpload["size"] > 1024 * 1024 * 2) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";

    } else {
        if (move_uploaded_file($fileToUpload["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($fileToUpload["name"])) . " has been uploaded.";
            header('Location:dashboard.php');
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$time = date('H:i:s');
$username = $_SESSION['username'];
$message = $targetFile;
$time = date('H:i:s');
if (SAVE_DATA === 'JSON'){
    $jsonMessage = json_decode(file_get_contents("../storage/message.json"), true);
}
if (SAVE_DATA === 'MYSQL'){
    //todo database connection
}
if (empty($jsonMessage)) {
    $id = 1;
} else {
    $end = end($jsonMessage);
    $id = $end['id'] + 1;
}
$messageUser = ['id' => $id, 'user_name' => $username, 'message' => $message, 'time' => $time , 'type' => 'pic'];
if (SAVE_DATA === 'JSON'){
    array_push($jsonMessage, $messageUser);
    file_put_contents('../storage/message.json', json_encode($jsonMessage));
}
if (SAVE_DATA === 'MYSQL'){
    //todo database connection
}
