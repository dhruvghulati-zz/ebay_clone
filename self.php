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
                              <form id="prfoile-form" action="updateProfile.php" method="post">
                                <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <td>Username</td>
                                            <td><input type="text" name="username" value= <?php echo $data['username'];?>></td>
                                        </tr>
                                          <tr>
                                            <td>First Name</td>
                                            <td><input type="text" name="firstName" value= <?php echo $data['first_name']; ?>></td>
                                        </tr>
                                          <tr>
                                            <td>Last Name</td>
                                            <td><input type="text" name="lastName" value= <?php echo $data['last_name']; ?>></td>
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
                            </table>
                          </form>
                                <a href="#" class="btn btn-primary">Upload New Picture</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
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

<script>
    
    
</script>