<?php
require_once "../config.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
        src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/391827d54c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../aseet/style/Dstyle.css">
    <title>
        admins
    </title>
</head>
<body>
<div class="container">
    <table class="table-fixed">
        <thead>
        <tr style="padding: 20px">
            <th style="padding: 20px"></th>
            <th style="padding: 20px">select</th>
            <th style="padding: 20px">id</th>
            <th style="padding: 20px">name</th>
            <th style="padding: 20px">username</th>
            <th style="padding: 20px">email</th>
            <th style="padding: 20px">is admin</th>
        </tr>
        </thead>
        <form action="" id="admin_form">

            <tbody>
            <?php

            $users = json_decode(file_get_contents("../storage/users.json"), true);

            foreach ($users as $user) {
                ?>
                <tr>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px">
                        <input type="radio" id="select" name="select" value="<?php echo $user['id']; ?>">
                    </td>
                    <td style="padding: 20px"><?php echo $user['id']; ?></td>
                    <td style="padding: 20px"><?php echo $user['name']; ?></td>
                    <td style="padding: 20px"><?php echo $user['user_name']; ?></td>
                    <td style="padding: 20px"><?php echo $user['email']; ?></td>
                    <td style="padding: 20px"><?php echo $user['admin'] == true ? 'yes' : 'no'; ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </form>
    </table>

    <button style="background-color: #55a1ff;border-radius: 20px" onclick="adminSave()">
        submit
    </button>
    <a href="dashboard.php">Home</a>
</div>
<script src="../aseet/script/script.js">

</script>
</body>
</html>
