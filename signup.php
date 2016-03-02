<?php
require_once("dbConnection.php");
$error_bool = false;
$required = array('username','password','confirm-password','email','firstname','lastname','dob');
$error_tabs = array();

foreach ($required as $field) {
	if(empty($_POST[$field])){
		$error_bool = true;
		array_push($error_tabs, $field);
	}
}

if(isset($_POST["username"],$_POST["password"],$_POST["confirm-password"],$_POST["email"],$_POST["dob"],$_POST["firstname"], $_POST["lastname"]) && !$error_bool){
	//Check if passwords match
	if($_POST["confirm-password"] != $_POST["password"]){
		echo "Passwords do not match";
	}else{
		//Check if entry does not exists already
		$resp = $db->prepare('SELECT username,email FROM Users WHERE username = :username AND email = :email');
		$resp->bindParam(':username',$_POST["username"]);
		$resp->bindParam(':email',$_POST["email"]);

		$resp->execute();
		//Other validations


		if($resp->rowCount() == 0){
			try{
				$ins = $db->prepare('INSERT INTO Users VALUES (NULL,:username,:password,:profile_picture,:first_name,:last_name,:email,:dob,DEFAULT,DEFAULT,:role_id)');
				
				$hashedPass = sha1($_POST["password"],false);

				$ins->bindParam(':username',$_POST["username"]);
                $ins->bindParam(':email',$_POST["email"]);
				//Apparently we should change this, bindParam doesn't allow you to pass string.
				$ins->bindParam(':profile_picture',htmlspecialchars("uploads/profile/stock.jpg"));
				$ins->bindParam(':password',$hashedPass);
				$ins->bindParam(':first_name',$_POST["firstname"]);
				$ins->bindParam(':last_name',$_POST["lastname"]);
				$ins->bindParam(':dob',$_POST["dob"]);
                $ins->bindParam(':role_id',$_POST["role"]);

				$ins->execute();
				echo "Registration successful";
				header('Location: index.php');

			}catch (PDOException $e){
				echo $e->getMessage();
			}
		}else{
			echo "Username or email already taken";
		}
	}
}else{
	echo "Invalid - Absent inputs: " . implode(", ", $error_tabs);
}

?>