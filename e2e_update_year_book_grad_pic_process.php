<?php
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_POST['btn_update_alumni_ybgp'])){

	$ybgp_id = $_POST['ybgp_id'];
	$year_book_status = $_POST['year_book_status'];
	$year_book_date = $_POST['year_book_date'];
	$grad_pic_status = $_POST['grad_pic_status'];
	$grad_pic_date = $_POST['grad_pic_date'];

	$stud_no_ybgp = $_POST['stud_no_ybgp'];
	$stud_name_ybgp = $_POST['stud_name_ybgp'];
	if($year_book_status == "Unclaimed"){
		$F_year_book_date = "none";
	}else{
		$year_book_date = $year_book_date;
	}
	if($grad_pic_status == "Unclaimed"){
		$F_grad_pic_date = "none";
	}else{
		$F_grad_pic_date = $grad_pic_date;
	}
	$tbl = "alumni_year_book_grad_pic";
	$col = ["year_book_status"=>$year_book_status,"year_book_date"=>$F_year_book_date,"grad_pic_status"=>$grad_pic_status,"grad_pic_date"=>$F_grad_pic_date];
	$where = ["ybgp_id"=>$ybgp_id];
	$q_update_ybgp = $database->update($tbl,$col,$where);
	header("location: e2e_update_student_records.php?success_ybgp=1&stud_no=$stud_no_ybgp&student_name=$stud_name_ybgp");
	
}

?>