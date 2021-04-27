<?php
require 'asset/connection/mysqli_dbconnection.php';

if(isset($_POST['btn_filter'])){

		$semester = $_POST['semester'];
		$program_id = $_POST['program_id'];
		$acad_year_start = $_POST['acad_year_start'];

		

	if($program_id != 0){
		 $q_grad = $database->count("alumni_grad_info","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"status"=>'Graduate',"program_id"=>$program_id]]);

	  $q_notgrad = $database->count("alumni_grad_info","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"status"=>'Not Graduate',"program_id"=>$program_id]]);

	  $q_Employed = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Employed',"program_id"=>$program_id]]);

	  $q_Unemployed = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Unemployed',"program_id"=>$program_id]]);

	  $q_Continuing_Study = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Continuing Study',"program_id"=>$program_id]]);

	  $q_Abroad = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Abroad',"program_id"=>$program_id]]);

	  $q_Self_Employed = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Self Employed',"program_id"=>$program_id]]);

	  $q_Under_Graduate = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Under Graduate',"program_id"=>$program_id]]);

	  $q_program_code = $database->query("SELECT program_code FROM program_list WHERE program_id = '$program_id'")->fetchAll();
		foreach($q_program_code AS $qData_pc){
				$program_code = $qData_pc['program_code'];
		}
	}else{

	  $q_grad = $database->count("alumni_grad_info","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"status"=>'Graduate']]);

	  $q_notgrad = $database->count("alumni_grad_info","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"status"=>'Not Graduate']]);

	  $q_Employed = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Employed']]);

	  $q_Unemployed = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Unemployed']]);

	  $q_Continuing_Study = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Continuing Study']]);

	  $q_Abroad = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Abroad']]);

	  $q_Self_Employed = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Self Employed']]);

	  $q_Under_Graduate = $database->count("alumni_info_view","*",
                                ["AND"=>["semester"=>$semester,"acad_year_start"=>$acad_year_start,"work_status"=>'Under Graduate']]);
	  $program_code = "All";
	}

	header("location:e2e_admin_home.php?grad_no=$q_grad&notgrad_no=$q_notgrad&q_Employed=$q_Employed&q_Unemployed=$q_Unemployed&q_Continuing_Study=$q_Continuing_Study&q_Abroad=$q_Abroad&q_Self_Employed=$q_Self_Employed&q_Under_Graduate=$q_Under_Graduate&semester=$semester&acad_year_start=$acad_year_start&program_code=$program_code&program_id=$program_id");
}
?>