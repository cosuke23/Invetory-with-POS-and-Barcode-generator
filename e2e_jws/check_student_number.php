<?php  
 require 'asset/connection/mysqli_dbconnection.php';

//Show all possible problems..
error_reporting(E_ALL | E_STRICT);
if(isset($_GET["inputValue"]))  

 { 
 	$inputValue = $_GET["inputValue"]; 
 	//$inputValue= "00820131642";
 	$table = "student_info";
 	$columns = ["stud_no"];
 	$where = ["stud_no"=>$inputValue];

 	$sql_student_no = $database->select($table,$columns,$where);

 	foreach($sql_student_no AS $stud_data){
 		$stud_no = $stud_data["stud_no"];

 		
 	}
 	if($sql_student_no){
 		echo "ok";
 		//exit;
 		}else{
 		//echo $inputValue;
 			echo "error";
 		} 
 }
 ?>