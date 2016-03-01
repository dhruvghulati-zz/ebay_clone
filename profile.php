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
    <?php include('nav.html'); ?>
    <div class="container" style="padding-top:100px">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">


                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">My Profile</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png" class="img-circle img-responsive">                        
                            </div>  
                            <div class=" col-md-9 col-lg-9 ">
                                <table class="table table-user-information">
                                    <?php
                                        session_start();
                                        $user = $_SESSION['user_id'];
                                        require("dbconfig.php");

                                        $resp = $db->prepare('SELECT * FROM users WHERE user_id = :user');
                                        $resp->bindParam(':user',$user);
                                        $resp->execute();

                                        $data = $resp->fetch();
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td>Username</td>
                                            <td><?php echo $data['username']; ?></td>
                                        </tr>
                                          <tr>
                                            <td>First Name</td>
                                            <td><?php echo $data['first_name']; ?></td>
                                        </tr>
                                          <tr>
                                            <td>Last Name</td>
                                            <td><?php echo $data['last_name']; ?></td>
                                        </tr>
                                           <tr>
                                            <td>Date of Birth</td>
                                            <td><?php echo $data['birthdate']; ?></td>
                                        </tr>

                                        <tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>
                                                <a href="mailto:info@support.com"><?php echo $data['email']; ?></a>
                                                </td>
                                            </tr>
                                            <td>Seller Rating</td>
                                            <td>
                                            <?php 
                                                $stars = round($data['rating'],0,PHP_ROUND_HALF_DOWN);
                                                $diff = $data['rating'] - $stars;
                                                $perc = number_format(($data['rating']/5)*100);
                                                do{
                                                    if($stars == 1 && $diff< 0){
                                                        echo '<span class="glyphicon glyphicon-star opacity"></span>';    
                                                    }else{
                                                        echo '<span class="glyphicon glyphicon-star"></span>';
                                                    }  
                                                    $stars = $stars - 1;
                                                }while($stars>0);
                                                echo "<p>  ".$perc."% </p>";
                                             ?>
                                               
                                            </td>

                                        </tr>

                                    </tbody>
                            <?php $resp->closeCursor(); ?>
                            </table>
                                <a href="#" class="btn btn-primary">Upload New Picture</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                        <span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-ok"></i>
                            </a>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>