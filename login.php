<?php  include('admin/includes/config.php'); ?>
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

    <!-- Custom Css --> 
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/covid.css">
 
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
   
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css">
    <!-- Favicon -->

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      .hide{
        display:none;
      }
    </style>
</head>
<body>
<div class="ugf-covid ugf-contact">
      <div class="pt70 pb70">
        <div class="container">
       
          <div class="row">
            <div class="col-lg-6 offset-lg-3" id='loginContainer' style='display:none'>
              <div class="card bg-light">
                <div class="card-header">Login</div>
                <div class="card-body">
                <div class="contact-form-wrap">
                
                <form id='frmLogin'>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group input-group-lg">
                        <input type="email" class="form-control" placeholder="Email address" id='email' name='email'>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group input-group-lg">
                        <input type="password" class="form-control" placeholder="Password" id='password' name='password'>
                      </div>
                    </div>
                  </div>
                  
                  <button class="btn-info btn-block input-group-lg" type='button' id='btnLogin' ><i class='fa fa-spinner fa-spin hide' id='spinner' ></i> login</button>
                </form>
              </div>
                </div>
              </div>

            </div>

            <div class="col-lg-6 offset-lg-3" id='2StepAuth' style='display:block';>
              <div class="card bg-light">
                <div class="card-header">
                  login
                </div>
                <div class="card-body">
                <div class="contact-form-wrap">
                <form id='frmLogin'>
                  <div class="row">
                    <div class="col-md-12 ">
                      <div class="form-group input-group-lg">
                        <p>Enter login access code</p>
                        <input type="number" class="form-control" placeholder="######" id='authcode' name='authcode' minlength="6">
                      </div>
                    </div>
                    
                  </div>
                  
                  <button class="btn-info btn-block" type='button' id='btnNext' >Next ></button>
                </form>
              </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
</div>

</body>
  <!-- SweetAlert2 -->
  <script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="admin/plugins/toastr/toastr.min.js"></script>
</html>


<script>
  $(document).ready(function(){
    //Toast
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3500
    });
    //Click button login
    $(document).on('click', '#btnLogin', ()=>{
      var email = $('#email').val();
      var password  = $('#password').val();

      if(email == ''){
        Toast.fire({ icon: 'error', title: 'fadlan qor email kaada.'});
      }else if(password == ''){
        Toast.fire({ icon: 'error', title: 'Fadlan qor password ka.'})
      }else{
        $('#spinner').removeClass('hide')
        $('#btnLogin').attr('disabled', true)
        $.ajax({
        url:'data/login.php',
        type:'post',
        data:$('#frmLogin').serialize(),
        success:function(res){
          if(res == 'continue'){
            window.location = 'admin/'
          }else if(res == '2step'){
            $('#loginContainer').css('display','none')
            $('#2StepAuth').css('display','block')
           
          }else if(res == 'failed'){
            Toast.fire({ icon: 'error', title: 'Invalid username or password.'})
            $('#btnLogin').attr('disabled', false)
            $('#spinner').addClass('hide')


          }else{
            console.log(res)

          }
        }
      });
      }

    })


    //Check Authcode
    $(document).on('click', '#btnNext', function(){
      var code = $('#authcode').val()
      if(code == ''){
        Toast.fire({ icon: 'error', title: 'fadlan geli code ka.'})
      }else{
        $.ajax({
          url:'data/login.php',
          type:'post',
          data: {authAccessCode:code},
          success:function(res){
            if(res == 'success'){
              window.location = 'admin/'
            }else{
              Toast.fire({ icon: 'error', title: 'code ka wuu qaldan yahay. fadlan iska hubi.'})
            }
          }
        });
      }
    });
    
  });

</script>