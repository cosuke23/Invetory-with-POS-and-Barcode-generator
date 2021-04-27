<?php
include('db.php');
 session_start(); 
 
 error_reporting(0);
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '')) { ?>
<script>
window.location = "index.php";
</script>
<?php
}
$session_id=$_SESSION['user_id'];

$user_query = mysqli_query($conn,"SELECT * from user where user_id = '$session_id'")or die(mysqli_error());
$user_row = mysqli_fetch_array($user_query);
$studname= $user_row['username']. ' ' .$user_row['usr_name'];
//get student course
$stud_no = $user_row['user_id'];
$title = "student";
//$stud_id = $user_row['stu_id'];
//$full=$title. ' ' .$user_row['fname']. ' ' .$user_row['lname'];
//$stud_program_id = $user_row['usertype'];
?>