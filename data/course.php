<?php 
include('../admin/includes/config.php');

if(isset($_POST['coursename'])){
    $cname = $_POST['coursename'];
    $stmt = "SELECT * FROM tbl_course WHERE course_name = '$cname'";
    $resul = mysqli_query($con, $stmt);
    if(mysqli_num_rows($resul) > 0){
        echo "found";
    }else{
        $stmt = "INSERT INTO tbl_course (course_name) values ('$cname')";
        $result = mysqli_query($con, $stmt);
        if($result){
            echo 'success';
        }
    }
}

if(isset($_POST['getallcourses'])){
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
              <button type='button' class='btn btn-info' data-toggle='modal' data-target='#editCourseModal'   data-toggle='tooltip' data-placement='top' title='Edit Course' id='editCourse' data-id='$id'><i class='fa fa-edit'></i> </button>
              <button type='button' class='btn btn-danger' id='deleteCourse' data-id='$id'  data-toggle='tooltip' data-placement='top' title='Delete course'> <i class='fa fa-trash'></i> </button>
            </div>
          </td>
        </tr>
      
      ";
    }
}

if(isset($_POST['deletecourse'])){
    $id = $_POST['deletecourse'];
    $stmt = "DELETE FROM tbl_course WHERE course_id = $id";
    $result = mysqli_query($con, $stmt);
    if($result){
        echo 'success';
    }else{
        echo 'failed';
    }
}


if(isset($_POST['editCourseDetail'])){
    $id = $_POST['editCourseDetail'];
    $stmt = "SELECT * FROM tbl_course WHERE course_id = $id";
    $result = mysqli_query($con, $stmt);
    if($row = mysqli_fetch_assoc($result)){
        $cname = $row['course_name'];
        echo "
            <div class='form-group col-md-12'>
                <label for=''>Course name</label>
                <input type='text' name='cname_edit' id='cname_edit' value='$cname' class='form-control'>
                <input type='hidden' name='' value='$id' id='course_id'>
            </div>
        ";
    }
}

if(isset($_POST['updateCourse'])){
    $id = $_POST['updateCourse'];
    $cname = $_POST['cname_edit'];

    $stmt = "UPDATE tbl_course SET course_name = '$cname' WHERE course_id = $id";
    $result = mysqli_query($con, $stmt);
    if($result){
        echo 'success';
    }

}

?>