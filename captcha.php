<?php
session_start();
       // สุ่มข้อความ Captcha
        $length = 6; 
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $chars[rand(0, strlen($chars) - 1)];
        }
        // เก็บค่า Captcha ไว้ใน Session
        $_SESSION['captcha'] = $randomString;

        // สร้างภาพ Captcha
        function create_image($cap) {
            $width = 150;
            $height = 40;
            $image = imagecreatetruecolor($width, $height);
            $background_color = imagecolorallocate($image, 255, 255, 255);
            imagefilledrectangle($image, 0, 0, $width, $height, $background_color);
            $line_color = imagecolorallocate($image, 64, 64, 64);
            for ($i = 0; $i < 10; $i++) {
                imageline($image, 0, rand() % $height, $width, rand() % $height, $line_color);
            }
            $pixel_color = imagecolorallocate($image, 0, 0, 255);
            for ($i = 0; $i < 1000; $i++) {
                imagesetpixel($image, rand() % $width, rand() % $height, $pixel_color);
            }
            $text_color = imagecolorallocate($image, 0, 0, 0);
            $font = 'VERDANA.TTF'; // กำหนด path ของ font
            imagettftext($image, 20, 0, 30, 30, $text_color, $font, $cap);
            header('Content-type: image/png');
            imagepng($image);
            imagedestroy($image);
        }

        // แสดงภาพ Captcha
        create_image($_SESSION['captcha']);

        

?>