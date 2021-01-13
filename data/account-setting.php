<?php 
session_start();
include('../admin/includes/config.php');

if(isset($_POST['fullname'])){
    $id = $_SESSION['user_id'];
    $fname = $_POST['fullname'];
    $stmt = "UPDATE tbl_user SET fullname = '$fname' WHERE user_id = '$id'";
    $result = mysqli_query($con, $stmt);
    if($result){
        echo 'success';
    }else{
        echo 'failed';
    }
}

if(isset($_POST['checkCurrPass'])){
    $id = $_SESSION['user_id'];
    $password = $_POST['checkCurrPass'];
    $stmt = "SELECT * FROM tbl_user WHERE password = '$password' AND user_id = '$id'";
    $result = mysqli_query($con, $stmt);
    if(mysqli_num_rows($result) > 0){
        echo 'success';
    }else{
        echo 'failed';
    }
}

if(isset($_POST['change_password'])){
    $id = $_SESSION['user_id'];
    $password = $_POST['change_password'];
    $stmt  = "UPDATE tbl_user SET password = '$password' WHERE user_id='$id'";
    $result = mysqli_query($con, $stmt);
    if($result){
        echo 'success';
    }else{
        echo 'failed';
    }
}

if(isset($_POST['change_auth'])){
    $id = $_SESSION['user_id'];
    $auth  =  $_POST['change_auth'];
    if($auth == 0){
        $stmt = "UPDATE tbl_user SET 2StepAuhentication = '0' WHERE user_id = '$id' ";
        $result = mysqli_query($con, $stmt);
        if($result){
            echo 'success';
        }
    }else{
        $stmt = "UPDATE tbl_user SET 2StepAuhentication = '1' WHERE user_id = '$id' ";
        $result = mysqli_query($con, $stmt); 
        if($result){
            echo 'success';
        }
    }
}


?>