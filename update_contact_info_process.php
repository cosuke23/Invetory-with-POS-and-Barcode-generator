<?php
date_default_timezone_set('Asia/Manila');
require 'assets/connection/mysqli_dbconnection.php';
	if(isset($_POST['btn_update_info'])){
	
			$nw_email=$_POST['nw_email'];
			$nw_mobile_no=$_POST['nw_mobile_no'];
			$nw_fb=$_POST['nw_fb'];
			$this_stud_no=$_POST['this_stud_no'];
			$address=mysqli_real_escape_string($dbc, $_POST['nw_address']);
			//update query
			$q_update_info = "update student_info set email='$nw_email', mobile_no='$nw_mobile_no', facebook='$nw_fb', address='$address' where stud_no='$this_stud_no'";
			if($dbc->query($q_update_info) == TRUE){
				header("Location: my_account.php?update_contact=ok");
			}
			
		}

?>