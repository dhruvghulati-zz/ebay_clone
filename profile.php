<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/profile.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</head>

<body>
    <?php include('nav.html'); 
    require("dbconfig.php");
    $ctrl = true;

    if(isset($_GET["user"])){
        $ctrl = false;
        $user = $_GET["user"];      
    }else{
        $ctrl = true;
        session_start();
        $user = $_SESSION['user_id'];
    }
    $resp = $db->prepare('SELECT * FROM users WHERE user_id = :user');
    $resp->bindParam(':user',$user);
    $resp->execute();
    $data = $resp->fetch();
    $resp->closeCursor(); 

    if(isset($_GET["user"])){
        include('foreign.php');      
    }else{
        include('self.php');
    }
    ?>
  
</body>

</html>