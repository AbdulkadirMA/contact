<?php 
session_start();
include('../admin/includes/config.php');

if(isset($_POST['email'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    
    $stmt = "SELECT * FROM tbl_user WHERE email_address='$email' AND password = '$password'";
    $result = mysqli_query($con, $stmt);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $fname = $row['fullname'];
        $id =  $row['user_id'];
        $profile = $row['profile_photo'];
        $auth = $row['2StepAuhentication'];

        if($auth == 0){
            echo 'continue';
            $_SESSION['user_id'] = $id;
            $_SESSION['fname'] = $fname;
            $_SESSION['profile'] = $profile;
            $_SESSION['email'] = $email;
            
            
        }else if($auth == 1){
            echo '2step';
            $authCode = rand(102030, 999999);
            $stmt = "UPDATE tbl_user SET token = '$authCode' WHERE email_address='$email'";
            $result = mysqli_query($con, $stmt);
            if($result){
                require '../PHPMailerAutoload.php';
                
                $mail = new PHPMailer;

                //$mail->SMTPDebug = 4;                               // Enable verbose debug output
    
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'yaaqa33@gmail.com';                 // SMTP username
                $mail->Password = 'Me.Yakub@2019';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
    
 
                $mail->setFrom('yaaqa33@gmail.com', 'Bravo Akademi');
                $mail->addAddress($email, $fname);     // Add a recipient
                //$mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('yaaqa91@gmail.com', 'Yakub ahmed');


                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
    
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML
                
                $mail->Subject = 'Baravo Login';
                $mail->Body    = "
                   <h1>
                    Baravo akademi
                    <hr>
                   </h1>
                   <h3>
                    Code ka aad ku geli karto system ka waa: <strong>$authCode</strong>
                   </h3>
                ";

                if(!$mail->send()) {
                   
                } else {
                                       
                }
                $_SESSION['user_id'] = $id;
                $_SESSION['fname'] = $fname;
                $_SESSION['profile'] = $profile;
                $_SESSION['email'] = $email;

                
            }
           
        }
    }else{
        echo 'failed';
    }

}

if(isset($_POST['authAccessCode'])){
    $code = $_POST['authAccessCode'];

    $stmt = "SELECT * FROM tbl_user WHERE token = '$code'";
    $result = mysqli_query($con, $stmt);
    if(mysqli_num_rows($result) > 0){
        echo 'success';
    }else{
        echo 'not found';
    }

}

?>