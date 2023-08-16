<?php
session_start();
ob_start();
require_once "../config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="../aseet/style/style.css"/>
</head>
<body>

<?php
if (SAVE_DATA === 'JSON') {
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $users = json_decode(file_get_contents('../storage/users.json'), true);

        foreach ($users as $user) {
            if ($user['user_name'] == $username and $user['password'] == $password) {
                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
            } else {
                echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
            }
        }
    } else {
        ?>
        <form class="form" method="post" name="login">
            <h1 class="login-title">Login</h1>
            <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
            <input type="password" class="login-input" name="password" placeholder="Password"/>
            <input type="submit" value="Login" name="submit" class="login-button"/>
            <p class="link"><a href="registration.php">New Registration</a></p>
        </form>
        <?php
    }
}
if (SAVE_DATA === 'MYSQL') {
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = new PDO('mysql:host=mysql;dbname=chatroom', 'mahdiyar', 123456);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $query = "SELECT * FROM users";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll();
        function checkUser(): bool
        {
            global $users;
            global $username;
            foreach ($users as $user) {
                if ($user['user_name'] == $username) {
                    return true;
                }
            }
            return false;
        }
        if(checkUser()) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
        }
    }
    ?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link"><a href="registration.php">New Registration</a></p>
    </form>
    <?php
}
?>
</body>
</html>