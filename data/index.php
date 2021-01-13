<?php 

include('../admin/includes/config.php');

if(isset($_POST['email'])){
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phoneNum']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $msg = mysqli_real_escape_string($con, $_POST['msg']);
    $date = date('yy-m-d h:i');

    $stmt = "INSERT INTO tbl_contact (fullname, email_address, phone_number, course, message,date)";
    $stmt .= " VALUES ('$fname', '$email', '$phone', '$course', '$msg', '$date')";
    $result = mysqli_query($con, $stmt);
    if($result){
        echo 'success';
    }else{
        echo 'failed';
    }
}


?>