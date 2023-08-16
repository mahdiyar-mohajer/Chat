<?php
require_once "../config.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="../aseet/style/style.css"/>
</head>
<body>
<?php
require_once "../app/function.php";
if (SAVE_DATA === 'JSON') {
    date_default_timezone_set('asia/tehran');
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $userNameValidate = validate($username, "username");
        $emailValidate = validate($email, "email");
        $nameValidate = validate($name, "name");
        $passwordValidate = validate($password, "password");
        $time = date("Y-m-d H:i:s");
        if ($userNameValidate && $emailValidate && $nameValidate && $passwordValidate) {
            $content = file_get_contents('../storage/users.json');
            $users = json_decode($content, true);
            foreach ($users as $user) {
                if ($user['user_name'] != $username && $user['email'] != $email) {
                    if (empty($content)) {
                        $id = 1;
                    } else {
                        $end = end($users);
                        $id = $end['id'] + 1;
                    }
                    $user = [
                        'id' => $id,
                        'user_name' => $username,
                        'email' => $email,
                        'name' => $name,
                        'password' => $password,
                        'time' => $time,
                        'admin' => false,
                        'block' => false,
                    ];
                    $users[] = $user;
                    $result = file_put_contents('../storage/users.json', json_encode($users));
                    mkdir("../storage/users folder/$username", 0777, true);
                    if ($result !== false) {
                        echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
                        return;
                    } else {
                        echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
                    }
                } else {
                    echo "<div class='form'>
                  <h3>Error. Enter Unique User Name and Email.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
                    exit();
                }
            }
        } else {
            echo "<div class='form'>
                  <h3>Validation Error.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    } else {
        ?>
        <form class="form" action="" method="post">
            <h1 class="login-title">Registration</h1>
            <input type="text" class="login-input" name="username" placeholder="Username" required/>
            <input type="text" class="login-input" name="email" placeholder="Email Adress">
            <input type="text" class="login-input" name="name" placeholder="Name" required/>
            <input type="password" class="login-input" name="password" placeholder="Password">
            <input type="submit" name="submit" value="Register" class="login-button">
            <p class="link"><a href="login.php">Click to Login</a></p>
        </form>
        <?php
    }
}
?>
<?php
if (SAVE_DATA === 'MYSQL') {
    date_default_timezone_set('asia/tehran');
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $userNameValidate = validate($username, "username");
        $emailValidate = validate($email, "email");
        $nameValidate = validate($name, "name");
        $passwordValidate = validate($password, "password");
        $time = date("Y-m-d H:i:s");
        if ($userNameValidate && $emailValidate && $nameValidate && $passwordValidate) {
            $db = new PDO('mysql:host=mysql;dbname=chatroom', 'mahdiyar', 123456);

            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $query = "SELECT * FROM users";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $users = $stmt->fetchAll();
            function checkUser() : bool
            {
                global $users;
                global $username;
                global $email;
                foreach ($users as $user) {
                    if ($user['user_name'] == $username or $user['email'] == $email) {
                        return false;
                    }
                }
                return true;
            }
            if (checkUser()) {
                $db = new PDO('mysql:host=mysql;dbname=chatroom', 'mahdiyar', 123456);
                $query2 = "INSERT INTO users (user_name, email, name, password) VALUES (:user_name, :email, :name, :password)";
                $stmt2 = $db->prepare($query2);
                $stmt2->bindParam(':user_name', $username);
                $stmt2->bindParam(':email', $email);
                $stmt2->bindParam(':name', $name);
                $stmt2->bindParam(':password', $password);
                $stmt2->execute();
            }
        }
    }
}
?>
<form class="form" action="" method="post">
    <h1 class="login-title">Registration</h1>
    <input type="text" class="login-input" name="username" placeholder="Username" required/>
    <input type="text" class="login-input" name="email" placeholder="Email Adress">
    <input type="text" class="login-input" name="name" placeholder="Name" required/>
    <input type="password" class="login-input" name="password" placeholder="Password">
    <input type="submit" name="submit" value="Register" class="login-button">
    <p class="link"><a href="login.php">Click to Login</a></p>
</form>
</body>
</html>


