<div class="container" style="padding-top:50px">
    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Your Profile</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form id="profile_form" action="updateProfile.php" method="post">
                            <input hidden name="userID" value="<?php echo $user; ?>"/>
                            <div class="col-md-9 col-lg-9 " align="center"><img alt="User Pic"
                                                                                src="<?php echo $data['profile_picture']; ?>"
                                                                                class="img-circle img-responsive"
                                style="max-width:30%;max-height:30%;">
                                <p>
                                    <label for="file">Select a file:</label> <input type="file" disabled name="userfile"
                                                                                    id="file"> <br/>
                            </div>
                            <?php
                            if (isset($_POST['userfile'])){
                                // Configuration - Your Options
                                $allowed_filetypes = array('.jpg','.gif','.bmp','.png'); // These will be the types of file that will pass the validation.
                                $max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
                                $upload_path = './uploads/profile/'; // The place the files will be uploaded to (currently a 'files' directory).

                                $filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).
                                $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.

                                // Check if the filetype is allowed, if not DIE and inform the user.
                                if(!in_array($ext,$allowed_filetypes))
                                    die('The file you attempted to upload is not allowed.');

                                // Now check the filesize, if it is too large then DIE and inform the user.
                                if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
                                    die('The file you attempted to upload is too large.');

                                // Check if we can upload to the specified path, if not DIE and inform the user.
                                if(!is_writable($upload_path))
                                    die('You cannot upload to the specified directory, please CHMOD it to 777.');

                                // Upload the file to your specified path.
                                if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $filename))
                                    echo 'Your file upload was successful, view the file <a href="' . $upload_path . $filename . '" title="Your File">here</a>'; // It worked.
                                else
                                    echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
                            }
                            ?>
                            <div class=" col-md-9 col-lg-9 ">
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>Username</td>
                                        <td><input type="text" disabled name="username"
                                                   value= <?php echo $data['username']; ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>First Name</td>
                                        <td><input type="text" disabled name="firstName"
                                                   value= <?php echo $data['first_name']; ?>></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td><input type="text" disabled name="lastName"
                                                   value= <?php echo $data['last_name']; ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth</td>
                                        <td><input type="text" disabled name="dob"
                                                   value= <?php echo $data['birthdate']; ?>>
                                        </td>
                                    </tr>

                                    <tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><input type="text" disabled name="email"
                                                   value= <?php echo $data['email']; ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Password</td>
                                        <td><input type="text" disabled name="password">
                                        </td>
                                    </tr>
                                    <!--                                    Conditional label based on who you are -->
                                    <?php
                                    if ($data['role_id'] == 2) {
                                        echo "<td>Seller Rating</td>";
                                    } else {
                                        echo "<td>Buyer Rating</td>";
                                    }
                                    ?>
                                    <td>
                                        <?php
                                        $stars = round($data['rating'], 0, PHP_ROUND_HALF_DOWN);
                                        $diff = $data['rating'] - $stars;
                                        $perc = number_format(($data['rating'] / 5) * 100);
                                        do {
                                            if ($stars == 1 && $diff < 0) {
                                                echo '<span class="glyphicon glyphicon-star opacity"></span>';
                                            } else {
                                                echo '<span class="glyphicon glyphicon-star"></span>';
                                            }
                                            $stars = $stars - 1;
                                        } while ($stars > 0);
                                        echo "<p>  " . $perc . "% </p>";
                                        ?>
                                    </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input class="btn btn-sm btn-warning" id="edit" type="button" value="Edit">
                                    <input class="btn btn-sm btn-success" disabled type="submit" value="Submit">
                                </a>
                            </div>
                        </form>
                        <!--                                Need to get this to work and only available when in edit mode-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    var el = document.getElementById('edit');
    var frm = document.getElementById('profile_form');
    el.addEventListener('click', function () {
        for (var i = 0; i < frm.length; i++) {
            frm.elements[i].disabled = false;

        }
        frm.elements[0].focus();
    });
</script>