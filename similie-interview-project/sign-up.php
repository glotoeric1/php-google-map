<?php

    //starting the session variable and verifying if login time is not expired.
    session_start();
    $timeNow=time();
    if($timeNow >$_SESSION['empire'] ) {
        header('Location:login.php');
        exit();
    }
    //including class file and creating objects of the class.
    require_once 'class/userClass.php';
    $obj3=new UserClass();
    $obj2=new userClass();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['sign-up'])) {

        //collecting input from form or user and verifying.
        $fullname=$obj2->RemoveInvalideInput($_POST['fname']);
        $username=$obj2->RemoveInvalideInput($_POST['username']);
        $password1=$obj2->RemoveInvalideInput($_POST['password1']);
        $password2=$obj2->RemoveInvalideInput($_POST['password2']);

        //checking for empty field(s).
        if (!empty($fullname) && !empty($username) && !empty($password1) && !empty($password2)) {
            if($password1==$password2){
                $verfiy=$obj2->verifyId($username);
                if($verfiy==true){
                    //hashing password and inserting into the database.
                    $password_hash=password_hash($password1, PASSWORD_DEFAULT);
                    $sql=$obj2->InsertAdmin($fullname, $username, $password_hash);
                    if($sql){
                        $error='<div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button><strong>Success: </strong>User has been created successfully!</div></div>';

                    }else{
                        $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Oops unable to save please try again!</div></div>';

                    }
                }else{
                    $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Username is already taken !</div></div>';

                }
            }else{
                $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Error password Mismatch!</div></div>';
            }
        }else{
            $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button><strong>Error: </strong>There are empty field exit!</div></div>';
        }

    }elseif (isset($_POST['edit'])){

        //collecting input from form or user and verifying.
        $fullname=$obj2->RemoveInvalideInput($_POST['fname']);
        $username=$obj2->RemoveInvalideInput($_POST['username']);
        $password1=$obj2->RemoveInvalideInput($_POST['password1']);
        $password2=$obj2->RemoveInvalideInput($_POST['password2']);

        if (!empty($fullname) && !empty($username) && !empty($password1) && !empty($password2)) {
            if($password1==$password2){
                    //hashing password and updating into the database.
                    $password_hash=password_hash($password1, PASSWORD_DEFAULT);
                    $sql=$obj2->UpdateAdmin($fullname, $username, $password_hash);
                    if($sql){
                        $error='<div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button><strong>Success: </strong>User has been Updated successfully!</div></div>';

                    }else{
                        $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Oops unable to update please try again!</div></div>';

                    }
            }else{
                $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Error password Mismatch!</div></div>';
            }
        }else{
            $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button><strong>Error: </strong>There are empty field exit!</div></div>';
        }

    }
    }
        if (isset($_GET['ide'])) {
            //collecting user ID using GET and selecting the user.
            $id = $obj3->RemoveInvalideInput($_GET['ide']);
            $sql = $obj3->SelectOneUsers($id);
            if ($sql) {
                while ($row = $sql->fetch_assoc()) {
                    $id = $row['id'];
                    $fullname = $row['Fullname'];
                    $username = $row['Username'];
                }
            }
        }else if (isset($_GET['idd'])){

        //deleting from db using the delete method.
        $id=$obj3->RemoveInvalideInput($_GET['idd']);
        $sql=$obj3->DeleteUsers($id);
        if($sql){
            $error='<div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button><strong>Success: </strong>User has been deleted successfully!</div></div>';
        }else{
            $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Oops unable to save please try again!</div></div>';
            }
        }

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Similie Project</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="css/style1.css" rel="stylesheet">
</head>

<body id="body">

<!--==========================
  Top Bar
============================-->
<section id="topbar" class="d-none d-lg-block">
    <div class="container clearfix">
        <div class="contact-info float-left">
            <i class="fa fa-envelope-o"></i> <a href="mailto:glotoeric@gmail.com">glotoeric@gmail.com</a>
            <i class="fa fa-phone"></i>+22351871859
        </div>
        <div class="social-links float-right">
            <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
            <a href="http://www.facebook.com/eric.k.gloto" class="facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
            <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
            <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
        </div>
    </div>
</section>

<!--==========================
  Header
============================-->
<header id="header">
    <div class="container">

        <div id="logo" class="pull-left">
            <h1><a href="#body" class="scrollto">Simi<span>lie</span></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="#body"><img src="img/logo.png" alt="" title="" /></a>-->
        </div>

        <nav id="nav-menu-container">
            <ul class="nav-menu">
                <li class="menu-active"><a href="index.php">Home</a></li>
                <li class="menu-has-children"><a href="#">Service</a>
                    <ul>
                        <li><a href="sign-up.php">Create User Account</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
                <li><a href="index.php">Add Species</a></li>
            </ul>
        </nav><!-- #nav-menu-container -->
    </div>
</header><!-- #header -->

<main id="main">
    <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="wow fadeInUp">
        <div class="container">
            <div class="section-header">
                <h2>Create user Account </h2>
                <hr style="height: 4px; background-color: #50d8af;">
                <h4 style="font-family: cursive; color: #50d8af;">Below is a form provided to enter User Data</h4>
            </div>
            <div class="container">
                <div class="form">
                    <div id="sendmessage">User entrance form!</div>
                    <div id="errormessage"></div>
                    <div class="col-sm-12 section-t8">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="contactForm" action="sign-up.php" method="POST" role="form" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <span class="color-text-a">Fullname:</span>
                                                <input type="text" name="fname" value="<?php if(isset($fullname)) echo $fullname;?>" class="form-control form-control-lg form-control-a" placeholder="Fullname...." data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <span class="color-text-a">Username:</span>
                                                <input name="username" type="text" value="<?php if(isset($username)) echo $username;?>" class="form-control form-control-lg form-control-a" placeholder="Username....." data-rule="email" data-msg="Ex: 12.675689" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <span class="color-text-a">Password:</span>
                                                <input name="password1"  type="password" step="any"  class="form-control form-control-lg form-control-a" placeholder="Password..." data-rule="email" data-msg="Ex: 12.675689" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <span class="color-text-a">Conform Password:</span>
                                                <input name="password2"  type="password" step="any"  class="form-control form-control-lg form-control-a" placeholder="Password..." data-rule="email" data-msg="Ex: 12.675689" required>
                                            </div>
                                        </div>
                                        <div class="text-center"><button type="submit" name="sign-up">Save Data</button></div>
                                        <div class="text-center"><button type="submit" name="edit">Edit Data</button></div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    //printing out error message if any.
                    if(isset($error)){
                        echo $error;
                    }
                    ?>
                </div>
            </div>
            <!---- beginner --->

            <div class="row">
                <div class="col-md-12">
                    <hr style="height: 1px; background-color: #50d8af;">
                    <h4  style="font-family: cursive; color: #50d8af;">
                        List of User:</h4>
                    <form class="form-inline justify-content-center">
                        <input type="text" id="recherche" name="search" placeholder="Enter search item......" class="form-control" size="32">
                    </form><br>
                    <table id="tableId" width="100%" border="" class="table table-striped table-condensed  table-hover text-center">
                        <thead style=""><tr>
                            <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">ID#:</th>
                            <th style="width: 280px;background-color: #50d8af;"  scope="col" class="table-dark">Fullame:</th>
                            <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Username:</th>
                            <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Edit:</th>
                            <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Delete:</th>
                        </tr>
                        </thead>
                        <body>
                        <tr>
                        <?php
                        //selecting all users from to show in html table.
                        require_once 'class/userClass.php';
                        $obj2=new UserClass();
                        $select=$obj2->SelectUsers();
                        if($select){
                        while ($data=$select->fetch_assoc()) {
                            echo '<td>'.$data['id'].'</td>';
                            echo '<td>'.$data['Fullname'].'</td>';
                            echo '<td>'.$data['Username'].'</td>';
                            echo'<td> 
			<button class="btn btn-warning" name="edit"> <a style="color: #ffffff;" href="sign-up.php?ide='.$data['id'].'">Edit</button></a>
			</td>';
                            echo'<td>
			<button class="btn btn-danger" name="delete"> <a style="color: #ffffff;" href="sign-up.php?idd='.$data['id'].'">Delete</button></a>
			</td>';
                            echo '</tr>';}

                        }?>
                        </body>
                    </table>
                </div><hr>
            </div><hr>




        </div>
        </div>
        </div>
    </section>
    <!--/ Contact End /-->


    <!--- end --->




    </section><!-- #contact -->

</main>

<!--==========================
  Footer
============================-->
<footer id="footer">
    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong>Eric</strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://facebook.com/eric.gloto">Eric Enterprise</a>
        </div>
    </div>
</footer><!-- #footer -->

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- JavaScript Libraries -->
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/jquery/jquery-migrate.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/superfish/hoverIntent.js"></script>
<script src="lib/superfish/superfish.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/magnific-popup/magnific-popup.min.js"></script>
<script src="lib/sticky/sticky.js"></script>

<!-- Contact Form JavaScript File -->
<script src="contactform/contactforms.js"></script>

<!-- Template Main Javascript File -->
<script src="js/main.js"></script>
<script src="js/search_table.js"></script>

</body>
</html>
