<?php
session_start();
date_default_timezone_set('asia/tehran');
$time = date('H:i:s');
if (isset($_POST['submit'])) {

    $users = json_decode(file_get_contents("../storage/users.json"), true);
    $username = $_SESSION['username'];
    $loginUser = [];
    foreach ($users as $user) {
        if ($user['user_name'] == $username) {
            $loginUser = $user;
        }
    }
    if ($loginUser['block'] == false) {
        $username = $_SESSION['username'];
        $message = $_POST['message'];
        $time = date('H:i:s');
        $jsonMessage = json_decode(file_get_contents("../storage/message.json"), true);
        if (empty($jsonMessage)) {
            $id = 1;
        } else {
            $end = end($jsonMessage);
            $id = $end['id'] + 1;
        }
        $messageUser = [
            'id' => $id,
            'user_name' => $username,
            'message' => $message,
            'time' => $time
        ];
        array_push($jsonMessage, $messageUser);
        file_put_contents('../storage/message.json', json_encode($jsonMessage));
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
        src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/391827d54c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../aseet/style/Dstyle.css">
    <title>Chat Room</title>
</head>
<body>
<div class="background-green"></div>
<div class="main-container">
    <div class="left-container">

        <?php
        $jsonMessage = json_decode(file_get_contents("../storage/message.json"), true);
        $users = json_decode(file_get_contents("../storage/users.json"), true);
        $username = $_SESSION['username'];
        $loginUser = [];
        foreach ($users as $user) {
            if ($user['user_name'] == $username) {
                $loginUser = $user;
            }
        }
        ?>
        <!--header -->
        <div class="header">
            <div class="user-img">
                <!--                <img class="dp" src="" alt="">-->
            </div>
            <div class="nav-icons">
                <li><a class="fa-solid fa-arrow-right-from-bracket" href="logout.php"></a></li>
                <?php
                if ($loginUser['admin'] == true) {
                    ?>
                    <li><a class="fa-solid fa-unlock-keyhole" href="admins.php"></a></li>
                    <li><a class="fa-solid fa-ban" href="block_user.php"></a></li>
                    <?php
                }
                ?>

            </div>
        </div>

        <!--search-container -->
        <div class="search-container">
            <div class="input">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search or start new chat   "></div>
            <i class="fa-sharp fa-solid fa-bars-filter"></i>
        </div>

        <!--chats -->
        <div class="chat-list">
            <div class="chat-box">
                <div class="img-box">
                    <img class="img-cover" src="" alt="">
                </div>
                <div class="chat-details">
                    <div class="text-head">
                        <h4><?php echo $_SESSION['username']; ?></h4>
                        <p class="time unread"><?php echo $time; ?></p>
                    </div>
                    <div class="text-message">
                        <p>“How are you?”</p>
                        <b>1</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-container">
        <!--header -->
        <div class="header">
            <div class="img-text">
                <div class="user-img">
                    <img class="dp" src="" alt="">
                </div>
                <h4><?php echo $_SESSION['username']; ?><br><span>Online</span></h4>
            </div>
            <div class="nav-icons">
                <li><i class="fa-solid fa-magnifying-glass"></i></li>
                <li><i class="fa-solid fa-ellipsis-vertical"></i></li>
            </div>
        </div>
        <div class='chat-container'>
            <!--chat-container -->
            <?php
            //            $jsonMessage = json_decode(file_get_contents("../storage/message.json"), true);
            //            $users = json_decode(file_get_contents("../storage/users.json"), true);
            //            $username = $_SESSION['username'];
            //            $loginUser = [];
            //            foreach ($users as $user){
            //                if ($user['user_name'] == $username){
            //                    $loginUser = $user;
            //                }
            //            }

            foreach ($jsonMessage as $key => $value) {
                $user = $value['user_name'];
                $msg = $value['message'];
                $id = $value['id'];
                $tm = $value['time'];
                if ($_SESSION['username'] == $user) {
                    if (!array_key_exists('type', $value)) {
                        ?>
                        <form action="" method="POST" class='message-box my-message'>
                            <p><span><?php echo $user; ?></span><?php echo $msg; ?>
                                <br><span><?php echo $tm; ?></span>
                                <button class="fa-solid fa-trash" onclick="deleteMsg(<?php echo $id ?>)">

                                </button>
                            </p>

                        </form>

                        <?php
                    } else {
                        ?>

                        <img src="<?php echo $msg; ?>" alt="" width="150px">

                        <?php
                    }
                } else {
                    ?>
                    <div class='message-box friend-message'>
                        <p><span><?php echo $user; ?></span><?php echo $msg; ?><br><span><?php echo $tm; ?></span>

                        </p>
                    </div>
                    <?php
                    if ($loginUser['admin'] == true) { ?>
                        <button class="fa-solid fa-trash" onclick="deleteMsg(<?php echo $id ?>)">

                        </button>
                    <?php } ?>

                    <?php
                }
            }
            ?>
            <div id="image-holder"></div>
        </div>

        <!--input-bottom -->

        <form action="" method="POST">

            <h3 id="text-count" class="mx-2 text-green-600"></h3>
            <div class="chatbox-input">
                <i class="fa-regular fa-face-grin"></i>
                <i class="fa-sharp fa-solid fa-paperclip"></i>
                <input type="text" placeholder="Type a message" name="message" id="message">
                <button class="fa-solid fa-paper-plane-top" type="submit" name="submit" id="submit">send</button>
            </div>
        </form>
        <form action="./upload.php" method="POST" enctype="multipart/form-data">
            <div id="wrapper">
                <input id="fileUpload" type="file" name="file">
                <input type="submit" name="submit" value="submit">
            </div>
        </form>
    </div>
</div>
<script src="../aseet/script/script.js"></script>
<script src="../aseet/script/wordcount.js"></script>
<script src="../aseet/script/upload.js"></script>
</body>
</html>
