<?php
try {
    require 'dbConnection.php';

//    if(!empty($_POST["username"]))
//    {
//        $username = $_POST["username"];
//    }
//    if(!empty($_POST["password"]))
//    {
//        $password = $_POST["username"];
//    }
//    if(!empty($_POST["firstname"]))
//    {
//        //Do my PHP code
//    }
//    if(!empty($_POST["lastname"]))
//    {
//        //Do my PHP code
//    }
//    if(!empty($_POST["dob"]))
//    {
//        //Do my PHP code
//    }
//    if(!empty($_POST["userfile"]))
//    {
//        //Do my PHP code
//    }
//    if(!empty($_POST["email"]))
//    {
//        //Do my PHP code
//    }

//    Can to multiple update statemeents with where the values are only changed if different via where
//    http://stackoverflow.com/questions/6677517/update-if-different-changed

    $sql = "UPDATE Users SET
    username = COALESCE(:username,username),
    first_name =COALESCE(:first_name,first_name),
    email =COALESCE(:email,email),
    last_name =COALESCE(:last_name,last_name),
    birthdate =COALESCE(:dob,birthdate),
    passwd =COALESCE(:password,passwd),
    profile_picture = COALESCE(:userfile,profile_picture)
    WHERE user_id =:userID";
    $ins = $db->prepare($sql);

    $hashedPass = sha1($_POST["password"],false);

    $ins->bindParam(':username', $_POST["username"] ?: null);
    $ins->bindParam(':email', $_POST["email"] ?: null);
    $ins->bindParam(':password', $hashedPass ?: null);
    $ins->bindParam(':first_name', $_POST["firstname"] ?: null);
    $ins->bindParam(':last_name', $_POST["lastname"]?: null);
    $ins->bindParam(':dob', $_POST["dob"]?: null);
    $ins->bindParam(':userfile', $_POST["userfile"]?: null);
    $ins->bindParam(':userID', $_POST["userID"])?: null;
//    Store the user id

    $ins->execute();
    header('Location: profile.php');

} catch (PDOException $e) {
    echo $e->getMessage();
}