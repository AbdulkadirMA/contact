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

        <div class="col-md-12 my-4">
          <div class="card bg-light">
            <div class="card-header">Add new course</div>
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="">Course name</label>
                  <input type="text" name="cname" id="cname" class="form-control" >
                </div>
                <div class="form-group col-md-6">
                  <button type='button' class='btn btn-info' id='btnSaveCourse'>Submit</button>
                </div>
              </div>
            </div>
          </div>
        </div>
       
        <div class="col-md-12"  id='producst_disp'  >
            <div class="card my-2 bg-light">
              <div class="card-header">
                <h3 class="card-title">Messages</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <table id="example1" class="table table-bordered table-striped ">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Course name</th>
                    
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $rowCount = 0;
                      $stmt = "SELECT * FROM tbl_course ORDER by course_name ASC";
                      $result =  mysqli_query($con, $stmt);
                      while($row = mysqli_fetch_assoc($result)){
                        $rowCount++;
                        $id = $row['course_id'];
                        $cname = $row['course_name'];
                        echo "
                          <tr>
                            <td>$rowCount</td>
                            <td>$cname</td>
                            <td>
                              <div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>
                                <button type='button' class='btn btn-info' data-toggle='modal' data-target='#editCourseModal'    data-toggle='tooltip' data-placement='top' title='Edit Course' id='editCourse' data-id='$id'><i class='fa fa-edit'></i> </button>
                                <button type='button' class='btn btn-danger' id='deleteCourse' data-id='$id'  data-toggle='tooltip' data-placement='top' title='Delete course'> <i class='fa fa-trash'></i> </button>
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



<!-- Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id='ediCourseDetail'>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id='btnEditCourseSave'>Save changes</button>
      </div>
    </div>
  </div>
</div>

 
  <?php include('includes/footer.php'); ?>

  <script>
    $(document).ready(function(){
      //Toastr
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500
      });
      //Save Course
      $(document).on('click', '#btnSaveCourse', function(){
        var cname = $('#cname').val();
        if (cname == ''){
          Toast.fire({ icon: 'error', title: 'Fadlan qor coursada magaceda.'});
        }else{
          $.ajax({
            url:'../data/course.php',
            type:'post',
            data:'coursename='+cname,
            success:(res)=>{
              if(res == 'found'){
                Toast.fire({ icon: 'error', title: 'SORREy this course is allready registered.'});
              }else if(res == 'success'){
                $('#cname').val('');
                Toast.fire({ icon: 'success', title: 'Course created successfully.'});
                getallcourses()
              }else{
                console.log(res)
                Toast.fire({ icon: 'error', title: 'Something is wrong. try again.'});
              }
            }
          });
        }
      });

      //Delete course
      $(document).on('click', '#deleteCourse', function(){
        var id = $(this).data('id')
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
          if (result.value) {
            $.ajax({
            url:'../data/course.php',
            type:'post',
            data:'deletecourse='+id,
            success:(res)=>{
               if(res == 'success'){
                Toast.fire({ icon: 'success', title: 'Course deleted successfully.'});
                getallcourses()
               }else{
                 console.log(res);
               }
            }
          });

          }
        })

      })

      //Edit course 
      $(document).on('click', '#editCourse', function(){
        $id = $(this).data('id');
        $.ajax({
            url:'../data/course.php',
            type:'post',
            data:'editCourseDetail='+$id,
            success:(res)=>{
              $('#ediCourseDetail').html(res)
            }
        });
      });

      $(document).on('click', '#btnEditCourseSave', function(){
        $id = $('#course_id').val();
        $cname = $("#cname_edit").val();
        $.ajax({
            url:'../data/course.php',
            type:'post',
            data:{updateCourse:$id, cname_edit:$cname},
            success:(res)=>{
              if(res == 'success'){
                Toast.fire({ icon: 'success', title: 'Course updated successfully.'});
                $('#editCourseModal').modal('hide');
                
                getallcourses()
              }else{
                Toast.fire({ icon: 'error', title: 'Something is wrong please try again.'});
              }
            }
        });
      });

      function getallcourses(){
        $.ajax({
            url:'../data/course.php',
            type:'post',
            data:'getallcourses='+2020,
            success:(res)=>{
              $('tbody').html(res)
            }
          });
      }
    })
  </script>

