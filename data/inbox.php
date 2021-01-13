<?php 

include('../admin/includes/config.php');

if(isset($_POST['msgDetailDisp'])){
    $id = $_POST['msgDetailDisp'];
    $stmt = "SELECT * FROM tbl_contact WHERE cont_id  = $id";
    $result = mysqli_query($con, $stmt);
    if($row = mysqli_fetch_assoc($result)){
        $id =$row['cont_id'];
        $fname  = $row['fullname'];
        $course  = $row['course'];
        $email = $row['email_address'];
        $phone = $row['phone_number'];
        $message = $row['message'];

        echo "
        <div class='row'>
        <table class='table table-sm '>
          <thead>
              <th >
                <label for=''>Sender</label>
                <input type='text' name='' id='' class='form-control' value='$fname' readonly disabled>
              </th>
              <th >
                <label for=''>Email address</label>
                <input type='text' name='' id='emailaddr' class='form-control' value='$email' readonly disabled>
              </th>
              <th >
                <label for=''>Phone number</label>
                <input type='text' name='' id='' class='form-control' value='$phone' readonly disabled>
              </th>
            </tr>    
          </thead>
          <tbody>
            <tr>
              <td colspan='3'>
                <div class='card'>
                  <div class='card-body'>
                    <p>
                   $message
                    </p>
                  </div> <br>
                  <div class='card-footer'>
                    <div class='form-group col-md-12'>
                      <button type='button' class='btn btn-info btn-block' id='btnAnswer' style='border-radius:0;'> Answer</button>
                    </div>
                    <div id='reply' style='display:none'>
                      <div class='form-group col-md-12'>
                        <textarea name='' id='addRepMsg' class='form-control' placeholder='Add your reply here ....'></textarea>
                      </div>
                      <div class='form-group col-md-12'>
                      <button class='btn btn-primary btn-block' id='btnSendMessage' style='border-radius:0;'> <i class='fa fa-spinner fa-spin hide' id='spinner' ></i>Send </button>
                      </div>
                    </div>
                  </div>

                </div>
              </td>
            </tr>
          </tbody>

        </table>
        
      </div>
        
        ";
    }

}

if(isset($_POST['send_rep_msg'])){
    $msg = $_POST['send_rep_msg'];
    $email = $_POST['emailadr'];
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
    $mail->addAddress($email, ' b');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('yaaqa91@gmail.com', 'Yakub ahmed');


    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML
    
    $mail->Subject = 'Baravo Akademi';
    $mail->Body    = "
       <h1>
        Baravo akademi
        <hr>
       </h1>
       <p>
       $msg
       </p>
    ";

    if(!$mail->send()) {
       
    } else {
        echo 'success';                
    }
}

?>