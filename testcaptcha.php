<?php
    session_start();
    include "./connectdb.php";
?>

<?php

    if (isset($_POST['captcha'])) {
        $user_captcha = $_POST['captcha'];
        $captcha_from_session = $_SESSION['captcha'];
        if (strlen($user_captcha) === strlen($captcha_from_session) && $user_captcha === $captcha_from_session) {
            // correct
            header("Location: index.php");
        } 
        else {
            echo "กรุณากรอกข้อมูล Captcha ให้ถูกต้อง";

            echo "
            <br>
            <br>
            user_captcha : $user_captcha
            <br>
            captcha_from_session : $captcha_from_session
            ";

            // header("Location: incorrect.php");
        }
    }
    
?>