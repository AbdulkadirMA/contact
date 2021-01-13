<?php include('includes/header.php'); include('includes/config.php'); ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php include('includes/nav.php');?>

  <?php include('includes/sidebar.php'); ?>

<style>
  .hide{
    display:none;
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
       
        <div class="col-md-12"  id='producst_disp'  >
            <div class="card my-4 bg-light">
              <div class="card-header">
                <h3 class="card-title">Messages</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <table id="example1" class="table table-bordered table-striped ">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Sender</th>
                    <th>Course</th>
                    <th>Message</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $rowCount = 0;
                      $stmt = "SELECT * FROM tbl_contact ORDER by cont_id DESC ";
                      $result = mysqli_query($con, $stmt);
                      while($row = mysqli_fetch_assoc($result)){
                        $rowCount++;
                        $id  = $row['cont_id'];
                        $fname  = $row['fullname'];
                        $course  = $row['course'];
                        
                        $message =  limit_text($row['message'],10);

                        echo "
                          <tr>
                            <td>$rowCount</td>
                            <td>$fname</td>
                            <td>$course</td>
                            <td>$message</td>
                            <td>
                              <div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>
                                <button type='button' class='btn btn-info' id='btnviewMsg'  data-toggle='modal' data-target='#viewDetailModal'   data-toggle='tooltip' data-placement='top' title='View detail'  data-id='$id'><i class='fa fa-list'></i> </button>
                                <button type='button' class='btn btn-danger' id='deleteMsg' data-id='$id'  data-toggle='tooltip' data-placement='top' title='Delete message'> <i class='fa fa-trash'></i> </button>
                              </div>
                            </td>
                          </tr>
                        ";
                      }

                    
                    ?>
                    
                  </tbody>
              
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>  


        </div>

         
          
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


 <!-- View Message detail Modal -->
 <!-- Modal -->
<div class="modal fade" id="viewDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-light"  style='width:700px; min-width:400px;'>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Message detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class='modal-body' id='MessageDetail'>

      </div>
    
    </div>
  </div>
</div>
 
  <?php include('includes/footer.php'); ?>
  <?php
    function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

  ?>

<script>

    $(document).ready(()=>{
      //Toastr
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500
      });

      $(document).on('click', '#btnAnswer', function(){
        $('#reply').css('display','block')
      })
      
      //View details of message
      $(document).on('click', '#btnviewMsg', function(){
        var id = $(this).data('id');
        $.ajax({
            url:'../data/inbox.php',
            type:'post',
            data:'msgDetailDisp='+id,
            success:(res)=>{
              $('#MessageDetail').html(res)
            }
          });
      })

      //Send reply
      $(document).on('click','#btnSendMessage', function(){
        var replmsg = $('#addRepMsg').val()
        var email = $('#emailaddr').val();
        if(replmsg == ''){
          Toast.fire({ icon: 'error', title: 'Please type reply message.'});
        }else{
          $('#spinner').removeClass('hide')
          $('#btnSendMessage').attr('disabled', true)

          $.ajax({
            url:'../data/inbox.php',
            type:'post',
            data:{send_rep_msg:replmsg, emailadr:email},
            success:(res)=>{
              if (res == 'success'){
                Toast.fire({ icon: 'success', title: 'Message send successfully.'});
                $('#viewDetailModal').modal('hide');
                
              }else{

              }
            }
          });
        }
      });
    })






</script>
