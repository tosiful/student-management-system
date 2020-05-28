<?php

require_once './db/dbcon.php';
session_start();




//jodi session theke take taile index.php page a patiye dibe
if(isset($_POST['register'])){

    $name=$_POST['name'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $confirmpassword=$_POST['confirmpassword'];


    $photo=explode('.',$_FILES['photo']['name']);
    $photo=end($photo);
    $photo_name=$username.'.'.$photo;



    $input_error=array();




    if(empty($name)){

        $input_error['name']="The Name field is required";

    }

    if(empty($email)){

        $input_error['email']="The Email field is required";

    }


    if(empty($username)){

        $input_error['username']="The Username field is required";

    }


    if(empty($password)){

        $input_error['password']="The Password field is required";

    }

    if(empty($confirmpassword)){

        $input_error['confirmpassword']="The Confirm Password field is required";

    }



    if(count($input_error)==0){


        $email_check=mysqli_query($link,"SELECT COUNT(*) FROM `user` WHERE `email`='$email';");
        $email_check_rows =mysqli_num_rows($email_check);



        if ($email_check_rows['COUNT(*)'] == 0) {
            $username_check=mysqli_query($link,"SELECT * FROM `user` WHERE `username`='$username';");
            if(mysqli_num_rows($username_check)==0){

                if(strlen($username)>7){
                    if(strlen($password)>7){
                        if($password==$confirmpassword){
                            $password=md5($password);


                            $result=mysqli_query($link,"INSERT INTO `user`(`name`, `email`, `username`, `password`, `photo`, `status`) VALUES ('$name','$email','$username','$password','$photo_name','inactive')");

                            if($result){
                                $_SESSION['data_insert_success']="data insert success";

                                move_uploaded_file($_FILES['photo']['tmp_name'],'Resources/images/'.$photo_name);
                                header('registration.php');


                            }else{


                                $_SESSION['data_insert_error']="data insert error";

                            }



                        }else{

                            $password_not_match="Confirm password not match";

                        }


                    }else{

                        $password_l="password more than 8 characters";

                    }


                }else{
                    $username_l="Username more than 8 characters";

                }

            }
            else{

                $username_error="the username  already exists";
            }


        }else {


            $email_error="the email address already exists";

        }


    }


}









//value="<?=isset($fname)?$fname:'' - eita diye submit korar por input value gola form a reke dei


?>











<!doctype html>
<html lang="en" class="fixed accounts sign-in">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>student-registation</title>
    <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
    <link rel="icon" type="image/png" sizes="192x192" href="favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <!--BASIC css-->
    <!-- ========================================================= -->
    <link rel="stylesheet" href="../asset/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../asset/vendor/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../asset/vendor/animate.css/animate.css">
    <!--SECTION css-->
    <!-- ========================================================= -->
    <!--TEMPLATE css-->
    <!-- ========================================================= -->
    <link rel="stylesheet" href="../asset/stylesheets/css/style.css">
</head>

<body>
<div class="wrap">
    <!-- page BODY -->
    <!-- ========================================================= -->
    <div class="page-body animated slideInDown">
        <!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= -->
        <!--LOGO-->
        <div class="logo">
            <h1 class="text-center">LMS</h1>



            <?php

            //alert msg show


            if(isset($success)){
                ?>



                <div class="alert alert-success" role="alert">
                    <?=$success?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>


                    </button>


                </div>


                <?php


            }




            ?>





            <?php

            if(isset($error)){
                ?>



                <div class="alert alert-danger" role="alert">
                    <?=$error?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>


                    </button>


                </div>


                <?php


            }




            ?>


            <?php

            //alert msg show


            if(isset($emil_exists)){
                ?>



                <div class="alert alert-danger" role="alert">
                    <?=$emil_exists?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>


                    </button>


                </div>


                <?php


            }




            ?>




            <?php

            //alert msg show


            if(isset($username_exists)){
                ?>



                <div class="alert alert-danger" role="alert">
                    <?=$username_exists?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>


                    </button>


                </div>


                <?php


            }




            ?>











            <?php

            //alert msg show


            if(isset($password_error)){
                ?>



                <div class="alert alert-danger" role="alert">
                    <?=$password_error?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>


                    </button>


                </div>


                <?php


            }




            ?>














        </div>





        <div class="box">
            <!--SIGN IN FORM-->
            <div class="panel mb-none">
                <div class="panel-content bg-scale-0">
                    <form method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
                        <div class="form-group mt-md">
                            <span class="input-with-icon">


                                <input type="text" class="form-control" name="fname" placeholder="First Name" value="<?=isset($fname)?$fname:'' ?>" >
                                <i class="fa fa-user"></i>
                            </span>

                            <?php
                            if(isset($input_errors['fname'])){

                                echo '<span class="input_errors">'.$input_errors['fname'] .'</span>';
                            }
                            ?>


                        </div>

                        <form>
                            <div class="form-group mt-md">
                            <span class="input-with-icon">
                                <input type="text" class="form-control" name="lname" placeholder="Last Name"  value="<?=isset($lname)?$lname:'' ?>">
                                <i class="fa fa-user"></i>
                            </span>

                                <?php
                                if(isset($input_errors['lname'])){

                                    echo '<span class="input_errors">'.$input_errors['lname'] .'</span>';
                                }
                                ?>

                            </div>


                            <div class="form-group mt-md">
                            <span class="input-with-icon">
                                <input type="email" class="form-control" name="email" placeholder="Email"   value="<?=isset($email)?$email:'' ?>">
                                <i class="fa fa-envelope"></i>
                            </span>
                                <?php
                                if(isset($input_errors['email'])){

                                    echo '<span class="input_errors">'.$input_errors['email'] .'</span>';
                                }
                                ?>

                            </div>

                            <div class="form-group mt-md">
                            <span class="input-with-icon">
                                <input type="text" class="form-control" name="roll" placeholder="Roll" pattern="[0-9]{6}"  value="<?=isset($roll)?$roll:'' ?>">
                                <i class="fa fa-envelope"></i>
                            </span>
                                <?php
                                if(isset($input_errors['roll'])){

                                    echo '<span class="input_errors">'.$input_errors['roll'] .'</span>';
                                }
                                ?>

                            </div>
                            <div class="form-group mt-md">
                            <span class="input-with-icon">
                                <input type="text" class="form-control" name="reg" placeholder="Reg No" pattern="[0-9]{6}"  value="<?=isset($reg)?$reg:'' ?>">
                                <i class="fa fa-envelope"></i>
                            </span>
                                <?php
                                if(isset($input_errors['reg'])){

                                    echo '<span class="input_errors">'.$input_errors['reg'] .'</span>';
                                }
                                ?>

                            </div>
                            <div class="form-group mt-md">
                            <span class="input-with-icon">
                                <input type="text" class="form-control" name="phone" placeholder="01*********" pattern="01[1|5|6|7|8|9][0-9]{8}"  value="<?=isset($phone)?$phone:'' ?>">
                                <i class="fa fa-envelope"></i>
                            </span>
                                <?php
                                if(isset($input_errors['phone'])){

                                    echo '<span class="input_errors">'.$input_errors['phone'] .'</span>';
                                }
                                ?>

                            </div>
                            <div class="form-group mt-md">
                            <span class="input-with-icon">
                                <input type="text" class="form-control" name="username" placeholder="User Name" value="<?=isset($username)?$username:'' ?>" >
                                <i class="fa fa-envelope"></i>
                            </span>

                                <?php
                                if(isset($input_errors['username'])){

                                    echo '<span class="input_errors">'.$input_errors['username'] .'</span>';
                                }
                                ?>


                            </div>




                            <div class="form-group">
                            <span class="input-with-icon">
                                <input type="password" class="form-control" name="password" placeholder="Password" value="<?=isset($password)?$password:'' ?>" >
                                <i class="fa fa-key"></i>
                            </span>
                                <?php
                                if(isset($input_errors['password'])){

                                    echo '<span class="input_errors">'.$input_errors['password'] .'</span>';
                                }
                                ?>

                            </div>

                            <div  class="form-group">
                                <input class="btn btn-primary btn-block" type="submit" name="std_reg" value="Register">
                            </div>
                            <div class="form-group text-center">
                                Have an account?, <a href="sign-in.php">Sign In</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= -->
    </div>
</div>
<!--BASIC scripts-->
<!-- ========================================================= -->
<script src="../asset/vendor/jquery/jquery-1.12.3.min.js"></script>
<script src="../asset/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../asset/vendor/nano-scroller/nano-scroller.js"></script>
<!--TEMPLATE scripts-->
<!-- ========================================================= -->
<script src="../asset/javascripts/template-script.min.js"></script>
<script src="../asset/javascripts/template-init.min.js"></script>
<!-- SECTION script and examples-->
<!-- ========================================================= -->
</body>

</html>
