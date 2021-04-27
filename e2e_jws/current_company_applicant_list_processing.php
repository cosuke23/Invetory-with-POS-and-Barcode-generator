<?php
// DB table to use
$table = 'applicant_list_jf';
//cookie
$comp_id = $_COOKIE["cid"];
// Table's primary key
$primaryKey = 'aljf_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
   array( 'db' => '`a`.`stud_dp`', 
                    'dt' => 0 ,
                    'field' => 'stud_dp',
                    'formatter' => function($stud_dp) {
                        return '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;">' ;
                    }
                 ),
    array( 'db' => '`a`.`stud_no`', 'dt' => 1, 'field' =>'stud_no' ),
    array( 'db' => '`a`.`lname`', 
            'dt' => 2, 
            'field' => 'lname', 
            'formatter' => function($lname,$row) {
                        $mname = $row[8];
                        $fname = $row[9];
                        return  $lname.", ".$fname." ".$mname;
                    } 
           ),
    array( 'db' => '`b`.`program_code`', 'dt' => 3, 'field' => 'program_code' ),
    array( 'db' => '`a`.`contact_no`', 'dt' => 4, 'field' => 'contact_no' ),
    array( 'db' => '`c`.`remarks`', 'dt' => 5, 'field' => 'remarks' ),
    array( 'db' => '`c`.`others`', 'dt' => 6, 'field' => 'others' ),
    array( 'db' => '`a`.`stud_no`',   
           'dt' => 7, 'field'=> 'stud_no',
           'formatter' => function($stud_no,$row){
				$course = $row[3];
				$lname = $row[2];
				$mname = $row[8];
                $fname = $row[9];
				$fullname = $lname .", ". $fname ." ". $mname;
				$newfilename = $course. " - ". $fullname;
                $aljf_id = $row[10];
				 $job_fair_id = $row[11];
				$file_name = $row[12];
                $btn_update_applicant = '<a href="e2e_company_update_applicant_student.php?stud_no='.$stud_no.'&aljf_id='.$aljf_id.'" class=" btn btn-outline btn-info" data-toggle="tooltip" data-placement="top" title="Update Applicant"><span class="fa fa-pencil">
                  </span></a>';
				  $btn_download_applicant = '<a href="asset/resume_data/'.$file_name.'" download="'.$newfilename.'.pdf" target="_blank" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Download Resume"><span class="fa fa-download">
                  </span></a>';
                $btn_remove_applicant = '<a href="e2e_company_remove_applicant_student.php?aljf_id='.$aljf_id.'&job_fair_id='.$job_fair_id.'" class=" btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" title="Remove Applicant"><span class="fa fa-remove">
                  </span></a>';
				  
                return $btn_update_applicant." ".$btn_download_applicant." ".$btn_remove_applicant;
           }
          ),
   array( 'db' => '`a`.`mname`', 'dt' => 8, 'field' => 'mname' ),
   array( 'db' => '`a`.`fname`', 'dt' => 9, 'field' => 'fname' ),
   array( 'db' => '`c`.`aljf_id`', 'dt' => 10, 'field' =>'aljf_id' ),
   array( 'db' => '`e`.`job_fair_id`', 'dt' => 11, 'field' =>'job_fair_id' ),
     array( 'db' => '`f`.`file_name`', 'dt' => 12, 'field' =>'file_name' ),
);


// SQL server connection information
//require('asset/connection/mysqli_dbconnection.php');
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_JWS',
    'host' => '127.0.0.1'
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `student_info` AS `a` JOIN `program_list` AS `b` JOIN  `applicant_list_jf` AS `c` JOIN `event_manager` AS `d` JOIN `nop_job_fair` AS `e` JOIN `resume_data` AS `f` ON (`a`.`program_id` = `b`.`program_id` AND `a`.`stud_no` = `c`.`stud_no` AND `d`.`event_id` = `c`.`event_id` AND `c`.`comp_id` = `e`.`comp_id` AND `a`.`stud_no` = `f`.`stud_no` AND `c`.`stud_no` = `f`.`stud_no` )";
$extraWhere = "`d`.`status` = 'Active' AND `c`.`comp_id` = '".$comp_id."' ";        

echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);