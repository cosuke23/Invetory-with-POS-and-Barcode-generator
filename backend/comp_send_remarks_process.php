<html>

<body>

<?php 

	require 'asset/connection/mysqli_dbconnection.php';

if(isset($_POST['btn_comp_remarks']))

		{

				$comp_id= $_GET['comp_id'];

				$studno = $_GET['stud_no'];

				$comp_remarks=$_POST['comp_remarks'];

				//$remarks_date="2016-08-31";

				

					

				date_default_timezone_set("Asia/Manila");

				$date_today = date("n/j/Y");

				$remarks_date = date('Y-m-d', strtotime(str_replace('-','/',$date_today)));		

				

				$q_nwcomp_remarks = "insert into company_remarks (comp_id,stud_no,remarks,remarks_date,status) values ('$comp_id','$studno','$comp_remarks','$remarks_date','unread')";

				$q_nwcomp_remarks_res= $dbc->query($q_nwcomp_remarks);

				header("Location: comp_company_remarks.php?comp_id=$comp_id&send=1");

		}

		

?>