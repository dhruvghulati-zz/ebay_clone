<?php
require("dbconfig.php");

if(isset($_POST["username"],$_POST["password"])){

    $resp = $db->prepare('SELECT user_id, first_name FROM users WHERE username = :username AND password = :password');

    $hashedPass = sha1($_POST["password"],false);

    $resp->bindParam(':username',$_POST["username"]);
    $resp->bindParam(':password',$hashedPass);

    $resp->execute();

    if($resp->rowCount() == 0){
        echo "Invalid - credentials";
        header("Location: index.html");
    }else{
        $data = $resp->fetch();
        session_start();
        $y = $data["user_id"];
        $_SESSION["user_id"] = $y;
        $_SESSION["first_name"] = $data["first_name"];
        header("Location: profile.html");
    }
}else{
    echo "Invalid";
    header("Location: index.html");
}
?>