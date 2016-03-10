<?php
try {
    require 'dbConnection.php';

    $sql = "UPDATE Users SET ";

    $username = "";
    $firstName = "";
    $lastName = "";
    $dob = "";
    $userfile = "";
    $email = "";
    $hashedPass = "";

    if (!empty($_POST["username"])) {
        $username = $_POST["username"];
    }
    if (!empty($_POST["password"])) {
        $hashedPass = sha1($_POST["password"], false);
    }
    if (!empty($_POST["firstName"])) {
        $firstName = $_POST["firstName"];
    }
    if (!empty($_POST["lastName"])) {
        $lastName = $_POST["lastName"];
    }
    if (!empty($_POST["dob"])) {
        $dob = $_POST["dob"];
    }
    if (!empty($_POST["userfile"])) {
        $userfile = $_POST["userfile"];
    }
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
    }
    $userID = $_POST['userID'];

    $updates = array();

    if ($username != "") {
        $updates[] = "username='$username'";
    }
    if ($firstName != "") {
        $updates[] = "first_name='$firstName'";
    }
    if ($lastName != "") {
        $updates[] = "last_name='$lastName'";
    }
    if ($email != "") {
        $updates[] = "email='$email'";
    }
    if ($dob != "") {
        $updates[] = "birthdate='$dob'";
    }
    if ($userfile != "") {

        $updates[] = "profile_picture='$userfile'";
    }
    if ($hashedPass != "") {
        $updates[] = "passwd='$hashedPass'";
    }

    if (count($updates) > 0) {
        $sql .= implode(', ', $updates) . " WHERE user_id='$userID'";
    }
//    Prepare query
    $updatequery = $db->prepare($sql);

    // execute the query
    $updatequery->execute();

    header('Location: profile.php');

} catch (PDOException $e) {
    echo $e->getMessage();
}