<?php 
include('admin/includes/config.php');

?>

<!doctype html>
<html lang="en">
  
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Contact - Barvo Akademi </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- External Css -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Custom Css --> 
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/covid.css">
 
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css">
    
    <!-- reCapcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Favicon -->
    

  </head>
  <body>
   
    <div class="ugf-covid ugf-contact">
      <div class="pt70 pb70">
        <div class="container">
       
          <div class="row">
            <div class="col-lg-8 offset-lg-2">
              <div class="contact-form-wrap">
                <h2>We’re Here to Help You</h2>
                <p>We always want to hear from you! Let us know how we can best help you and we'll do our very best.</p>
                <br>
                <form id='frmContact'>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group input-group-lg">
                        <input type="text" class="form-control" placeholder="Full name" id='fname' name='fname' >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group  input-group-lg">
                        <input type="email" class="form-control" placeholder="Email address" id='email' name='email'>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group  input-group-lg">
                        <input type="text" class="form-control" placeholder="Phone number" id='phoneNum' name='phoneNum'>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group  input-group-lg">
                        <Select class="form-control" id='course' name='course'>
                          <option value="">Select Course</option>
                          <?= getCourses() ?>
                          <option value="Other">Other</option>
                        </Select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group  input-group-lg">
                    <textarea class="form-control" placeholder="Tell us a few words" id='msg' name='msg'></textarea>
                  </div>
                  <div class="g-recaptcha" data-sitekey="6LfJsCgaAAAAAMlZguFOyoakxvFkABmRLVqpnaLl"></div> <br>
                  <button class="btn-primary btn-block btn-lg" type='button' id='btnSendMsg' >Send Your Message</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>



    
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script data-cfasync="false" src="../../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="../assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script src="js/custom.js"></script>

    <script src="js/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCo_UiZM19FOm6-Vpl42HXNDrpYwGHCzPo"></script>
  </body>
  <!-- SweetAlert2 -->
  <script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="admin/plugins/toastr/toastr.min.js"></script>
</html>

<?php

 function getCourses(){
   global $con;
   $stmt = "SELECT * FROM tbl_course";
   $result = mysqli_query($con, $stmt);
   while($row = mysqli_fetch_assoc($result)){
    $id = $row['course_id'];
    $cname = $row['course_name'];
    echo " 
    <option value='$cname'>$cname</option>
    ";
   }
 }


?>

<script>

$(document).ready(function(){
  
  //Toast
  const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3500
    });
  //Send message
  $(document).on('click', '#btnSendMsg', function(){
    var fname =  $('#fname').val();
    var email = $('#email').val();
    var phone = $('#phoneNum').val();
    var msg  = $('#msg').val()
    var course = $('#course').val()
    var capcha = grecaptcha.getResponse();
    
    if(fname == ''){
      Toast.fire({ icon: 'error', title: 'Fadlan magacaada qor.'})
    }else if(email == ''){
      Toast.fire({ icon: 'error', title: 'Fadlan qor email kaada.'})
    }else if(phone == ''){
      Toast.fire({ icon: 'error', title: 'Fadlan qor numberkaada.'})
    }else if(course === ''){
      Toast.fire({ icon: 'error', title: 'Fadlan dooro course.'})
    }else if (msg == ''){
      Toast.fire({ icon: 'error', title: 'Fadlan qor cabasho.'})
    }else if (capcha.length == 0){
      Toast.fire({ icon: 'error', title: 'please verify you are human!'})

    } else {

      $.ajax({
        url:'data/index.php',
        type:'post',
        data:$('#frmContact').serialize(),
        success:function(res){
          if(res == 'success'){
            Toast.fire({ icon: 'success', title: 'Your message has been sent.'})
            $('#frmContact')[0].reset()
            grecaptcha.reset();
          }else if(res == 'failed'){
            console.log(res)
            Toast.fire({ icon: 'error', title: 'Something is wrong try again.'})
          }else{
            console.log(res)

          }
        }
      });
    }
  });
  
  
})

</script>



