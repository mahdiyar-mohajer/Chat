<?php

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=chatroom', 'root', '');

// Prepare the statement
$stmt = $db->prepare('INSERT INTO users (user_name, email, name, password, time) VALUES (?, ?, ?, ?, ?)');

// Bind the parameters
$stmt->bindParam(':username', $username);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':time', $time);

// Execute the statement
$stmt->execute();

// Check if the statement was successful
if ($stmt->rowCount() > 0) {
    // The statement was successful, so create a new folder for the user
    mkdir("../storage/users folder/$username", 0777, true);

    // Redirect the user to the login page
    header('Location: /login.php');
} else {
    // The statement was not successful, so display an error message
    echo 'An error occurred while registering the user.';
}

?>