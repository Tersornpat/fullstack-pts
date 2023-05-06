<?php
    session_start();
    include "./connectdb.php";

    if(!isset($_SESSION['login_fail'])) {
        $_SESSION['login_fail'] = 0;
    }
?>
<?php
    $username = $_POST["username"];
    $password = $_POST["password"];

    if(!isset($_SESSION['login_fail'])) {
        $_SESSION['login_fail'] = 0;
    }

    // รับค่า e salt มาจาก db
    $result = $conn->prepare("SELECT 	
                                E_salt
                            FROM pts_employee WHERE E_Username= ?;");
    $result->bind_param("s",$username);
    $result->execute();
    $r = $result->get_result();
    $row = $r->fetch_assoc();
    $salt = $row["E_salt"];


    $password = hash("sha3-512",($salt.$password));
    $result = $conn->prepare("SELECT 	
                                E_ID,	
                                E_Name,	
                                E_Surname,
                                E_Role,
                                E_Address
                            FROM pts_employee WHERE E_Username= ? AND E_Password = ?;");
    $result->bind_param("ss",$username,$password);
    $result->execute();

    $r = $result->get_result();
    $conn->close();
    
    $rowcount = mysqli_num_rows($r);
    $row = $r->fetch_assoc();

    if($rowcount == 1){
        $_SESSION['id']=$row["E_ID"];
        $_SESSION['name']=$row["E_Name"];
        $_SESSION['surname']=$row["E_Surname"];
        $_SESSION['key']=$row["E_Role"];
        $_SESSION['address']=$row["E_Address"];
        
        if($_SESSION['key'] == "admin"){
            header("Location: ./operator/index.php");
        }
        else {
            header("Location: ./user/index.php");
        }
    }
    else {

        $_SESSION['login_fail']++;

        if ($_SESSION['login_fail'] <= 2) {
            header("Location: index.php");
        }
        else {

        //     $_SESSION['captcha'] = '';

        // // สุ่มข้อความ Captcha
        // $length = 6;
        // $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $randomString = '';
        // for ($i = 0; $i < $length; $i++) {
        //     $randomString .= $chars[rand(0, strlen($chars) - 1)];
        // }

        // // เก็บค่า Captcha ไว้ใน Session
        // $_SESSION['captcha'] = $randomString;

        // // สร้างภาพ Captcha
        // function create_image($cap) {
        //     $width = 150;
        //     $height = 40;
        //     $image = imagecreatetruecolor($width, $height);
        //     $background_color = imagecolorallocate($image, 255, 255, 255);
        //     imagefilledrectangle($image, 0, 0, $width, $height, $background_color);
        //     $line_color = imagecolorallocate($image, 64, 64, 64);
        //     for ($i = 0; $i < 10; $i++) {
        //         imageline($image, 0, rand() % $height, $width, rand() % $height, $line_color);
        //     }
        //     $pixel_color = imagecolorallocate($image, 0, 0, 255);
        //     for ($i = 0; $i < 1000; $i++) {
        //         imagesetpixel($image, rand() % $width, rand() % $height, $pixel_color);
        //     }
        //     $text_color = imagecolorallocate($image, 0, 0, 0);
        //     $font = 'VERDANA.TTF'; // กำหนด path ของ font
        //     imagettftext($image, 20, 0, 30, 30, $text_color, $font, $cap);
        //     header('Content-type: image/png');
        //     imagepng($image);
        //     imagedestroy($image);
        // }

        // แสดงภาพ Captcha พร้อมฟอร์มให้กรอกข้อมูล
        echo "
            <form method='post' action='testcaptcha.php'>
                <label for='captcha'>กรอกรหัสที่ปรากฏในภาพ</label>
                <br>
                <br>
                <img src='captcha.php' alt='Captcha'>
                <br>
                <br>
                <input type='text' id='captcha' name='captcha'>
                <br>
                <br>
                <input type='submit' value='ตรวจสอบ'>
            </form>
        ";

        }
            
    }
?>