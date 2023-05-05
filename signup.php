<?php
    session_start();
    include "./connectdb.php";
?>
<?php
    $username = $_POST["username"];
    $password = $_POST["password"];

    $name = $username;
    $surname = "admin";
    $role = "admin";
    $address = $username."'s house";
    $salt = base64_encode(random_bytes(6));

    $password = hash("sha3-512",($salt.$password));
    
    $result = $conn->prepare("INSERT INTO pts_employee (E_Username, E_Password, E_Name, E_Surname, E_Role, E_Address, E_salt) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $result->bind_param("sssssss", $username, $password, $name, $surname, $role, $address, $salt);
    $result->execute();
    $conn->close();


    $message = "Sign UP Succeed";
    header("Location: index.php");
?>