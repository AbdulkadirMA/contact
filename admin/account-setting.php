<?php include('includes/header.php'); include('includes/config.php'); ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php include('includes/nav.php');?>

  <?php include('includes/sidebar.php'); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
        <div class="form-group col-md-12">
            <h3 class='my-2'>Account setting</h3>
        </div>
        
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info"> General <small>setting</small></div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Fullname</label>
                            <input type="text" name="fname" id="fname1" class="form-control" value='<?= $_SESSION['fname'] ?>'>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Email address</label>
                            <input type="text" name="" id="" class="form-control" value='<?= $_SESSION['email'] ?>'>
                        </div>
                        <div class="form-group col-md-6">
                            <button class="btn btn-secondary" id='btnSaveGeneral'>Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-info"> Security <small>setting</small></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">Change password</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">Current password</label>
                                            <input type="password" name="" id="curr_pass" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">New password</label>
                                            <input type="password" name="" id="new_pass" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Confirm password</label>
                                            <input type="password" name="" id="conf_pass" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button class="btn btn-info btn-block" type='button' id='btnChangePass'>Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-secondary">2Step Authentication</div>
                                <div class="card-body">
                                    <div class="form-group col-md-12">
                                        <label for="">Enable 2Step authentication</label>
                                        <select name="" id="auth" class='form-control'>
                                            <?php  
                                                $id = $_SESSION['user_id'];
                                                $stmt = "SELECT * FROM tbl_user WHERE user_id = '$id'";
                                                $result = mysqli_query($con, $stmt);
                                                if($row = mysqli_fetch_assoc($result)){
                                                    $auth = $row['2StepAuhentication'];
                                                    if($auth == 0){
                                                        echo "
                                                            <option value='0'>No</option>
                                                            <option value='1'>Yes</option>
                                                        ";
                                                       
                                                    }else if($auth == 1){
                                                        echo "
                                                            <option value='1'>Yes</option>
                                                            <option value='0'>No</option>
                                                        ";
                                                    }
                                                }
                                            
                                            ?>
                                           
                                        </select>
                                    
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button class='btn btn-info' type='button' id='btnAuth'>Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        </div>

         
          
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <?php include('includes/footer.php'); ?>

  <script>
    $(document).ready(()=>{
      //Toastr
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500
        });

        //General setting
        $(document).on('click', '#btnSaveGeneral', function(){
            
            $fname = $('#fname1').val();
            if($fname == ''){
                Toast.fire({ icon: 'error', title: 'Full name can not be empty.'});

            }else{
                $.ajax({
                    url:'../data/account-setting.php',
                    type:'post',
                    data:{fullname:$fname},
                    success:(res)=>{
                    if (res == 'success'){
                        window.location = '../login.php'
                        
                    }else{

                    }
                    }
                });
            }
            
        })

        //Change Password
        $(document).on('click', '#btnChangePass', ()=>{
            var curr_pass = $('#curr_pass').val()
            var new_pass = $('#new_pass').val()
            var conf_pass = $('#conf_pass').val()

            if(curr_pass == ''){
                Toast.fire({ icon: 'error', title: 'PLease type your current password.'});
            }else if(new_pass == ''){
                Toast.fire({ icon: 'error', title: 'PLease type your new password.'});
            }else if (curr_pass == ''){
                Toast.fire({ icon: 'error', title: 'Please confirm your password.'});
            }else{
                $.ajax({
                    url:'../data/account-setting.php',
                    type:'post',
                    data:{checkCurrPass:curr_pass},
                    success:(res)=>{
                    if (res == 'success'){
                        if( new_pass != conf_pass ){
                            Toast.fire({ icon: 'error', title: 'Password and confirm password does not match.'});
                        }else{
                            $.ajax({
                                url:'../data/account-setting.php',
                                type:'post',
                                data:{change_password:new_pass},
                                success:(res)=>{
                                if (res == 'success'){
                                    window.location = '../login.php'
                                    
                                }else{

                                }
                                }
                            });
                        }

                        
                    }else{
                        Toast.fire({ icon: 'error', title: 'Invalid password.'});

                    }
                    }
                });
            }
        })

        //Auth

        $(document).on('click', '#btnAuth', ()=>{
            $auth = $('#auth').val();
            $.ajax({
                url:'../data/account-setting.php',
                type:'post',
                data:{change_auth:$auth},
                success:(res)=>{
                if (res == 'success'){
                    window.location = '../login.php'
                    
                }else{

                }
                }
            });
        });

    });

  </script>

