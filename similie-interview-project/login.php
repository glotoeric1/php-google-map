<?php 
session_start();
include 'head.php';

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once 'class/userClass.php';
    if (isset($_POST['signe-up'])) {
    $obj2=new userClass();
    $fullname=$obj2->RemoveInvalideInput($_POST['fname']);
    $username=$obj2->RemoveInvalideInput($_POST['user']);
    $password1=$obj2->RemoveInvalideInput($_POST['password1']);
    $password2=$obj2->RemoveInvalideInput($_POST['password2']);

    if (!empty($fullname) && !empty($username) && !empty($password1) && !empty($password2)) {
        if($password1==$password2){
            $verfiy=$obj2->verifyId($username);
            if($verfiy==true){
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

    }elseif (isset($_POST['loginUser'])){
        $obj3=new UserClass();

        $user=$obj3->RemoveInvalideInput($_POST['username']);
        $pass=$obj3->RemoveInvalideInput($_POST['password']);

        if(!empty($user) || !empty($pass)){
            $login=$obj3->login($user, $pass);
            if($login==true){
                   $_SESSION['start_time']=time();
                   $_SESSION['empire']=$_SESSION['start_time']+(10 * 60);
                   $_SESSION['username']=$user;
                   header("Location: index.php");
            }else{
                $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Username or Password incorrect!</div></div>';
                }
        }

    }
}
?>
<style type="text/css">
    
    span{
        color: darkred;
    }
    hr {
        height: 10px;
        background-color: red;
    }
    .profile{
        border: 30px dashed black;
        border-top: 30px solid black;
        border-bottom: 30px solid black;
    }
    .custom-btn{
        background: darkred;
          border-radius: 50px 50px 50px 50px;
    }

    .custom-btn:hover{
        background: #45B39D;
    }

</style>
    <div class="bg1 container wrapper justify-content-center align-items-center profile" style="margin-top: 15px;">
       <div style="text-align: center; font-weight: bold; font-size: 36px; color: #ffffff;" >Similie Animals Tracking Application</div>
        <p class="para" style="font-size: 24px;">Please enter your username and password to login</p><hr style="height: 10px; background-color: black;">
        <span style="margin-left: 35%; color: white; font-size: 30px;">User login form</span>
        <form action="login.php" method="POST" style="margin-left: 36%; margin-right: 36%; justify-content: center; align-items: center; align-content: center;"><hr style="background-color: black; height: 2px;">
            <div class="form-group">
                <label style="color: #fff; font-size: 17px; font-weight: bold;">Username:</label>
                <input type="text" name="username" class="form-control" placeholder="Username..." value="">
            </div>    
            <div class="form-group">
                <label style="color: #fff; font-size: 17px; font-weight: bold;">Password:</label>
                <input type="password" name="password" class="form-control" placeholder="Password...">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary custom-btn" value="Login" name="loginUser" style="font-weight: bold; font-size: 20px; width: 290px; height: 45px;">
            </div></form> <?php  include'time.php';  //echo date("l-M-d-Y"); ?> <a href="https://www.facebook.com/erickgloto" style="float: right; color: #fff; margin-top: -8px;" target="_blank">Designed by Eric k. Gloto</a>
            <hr style="background-color: black; height: 2px;">
            <p>
            <form action="login.php" method="POST">
            <button type="button" class="btn btn-secondary custom-btn" data-toggle="modal" data-target=".bd-example-modal-lg" style="color: white; font-size: 14px;">New Account
            </button> <br><br>
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="text-align: center;">
              <div class="modal-dialog modal-lg" style=" border: 4px solid black; background-color: #0B5345;">
                <div class="modal-content" style="background-color: #0B5345;">
                  <h3 class="para font-weight-bold white" style=" margin-top: 13px; border-bottom: 2px solid black;">Create New Account</h3>
                <div class="form-group white">
                <label>Fullname:</label>
                <input type="text" name="fname" class="form-control" placeholder="Ex: John Doe" value=""  style="width: 280px; margin-left: 36%;">
            </div>    
            <div class="form-group white">
                <label>Username:</label>
                <input type="text" name="user" class="form-control" placeholder="Username" style="width: 280px; margin-left: 36%;">
            </div>
            <div class="form-group white">
                <label>Password:</label>
                <input type="password" name="password1" class="form-control" placeholder="Password" style="width: 280px; margin-left: 36%;">
            </div>
            <div class="form-group white">
                <label>Confirm Password:</label>
                <input type="password" name="password2" class="form-control" placeholder="Password again" style="width: 280px; margin-left: 36%;">
            </div>
            <div class="form-group white">
                <input type="submit" class="btn btn-primary custom-btn" value="Create" name="signe-up" style="font-weight: bold; font-size: 17px;">
            </div> 
        </form>
                </div>
              </div>
            </div>

        <?php
        if(isset($error)){
            echo $error;
        }
        ?>
    </div> 
  
</body>
</html>


