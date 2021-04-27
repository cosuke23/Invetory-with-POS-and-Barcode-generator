<?php


// DB table to use
$table = 'student_info';

// Table's primary key
$primaryKey = 'stud_no';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
   array( 'db' => '`a`.`stud_no`', 
                    'dt' => 0 ,
                    'field' => 'stud_no',
                    'formatter' => function($stud_no) {
                       
                        return '<img src="../files/student_pics/'.$stud_no.'.jpg" style="height:50px;width:60px;">' ;
                    }
                 ),
    array( 'db' => '`a`.`stud_no`', 'dt' => 1, 'field' =>'stud_no' ),
    array( 'db' => '`a`.`lname`', 'dt' => 2, 'field' => 'lname' ),
    array( 'db' => '`a`.`fname`', 'dt' => 3, 'field' => 'fname' ),
    array( 'db' => '`a`.`mname`', 'dt' => 4, 'field' => 'mname' ),
    array( 'db' => '`b`.`program_code`', 'dt' => 5, 'field' => 'program_code' ),
    array( 'db' => '`c`.`resume_status`', 
                    'dt' => 6, 
                    'field' => 'resume_status',
                    'formatter' => function($resume_status){
                      if($resume_status == 0){
                        $F_resume_status="No resume";
                      }
                      elseif($resume_status == 1){
                        $F_resume_status="Pending";
                      }
                      elseif($resume_status == 2){
                        $F_resume_status="Approved";
                      }
                      elseif($resume_status == 3){
                        $F_resume_status="Rejected"; 
                      }
                      return $F_resume_status;
                    }                    
                  ),
        array( 'db' => '`a`.`stud_no`', 
                    'dt' => 7, 
                    'field' => 'stud_no',
                    'formatter' => function($stud_no){
                      
                      $btn_view = '<a href="update_student_resume_status.php?stud_no='.$stud_no.'">
                                  <button type="submit" class="btn btn-outline btn-primary btn-block btn-sm">
                                  <span class="glyphicon glyphicon-eye-open"></span> &nbsp;View &nbsp;</button>
                                  </a>';
                  
                      return $btn_view;
                    }                    
                  ),
);


// SQL server connection information
//require('asset/connection/mysqli_dbconnection.php');
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_ojtassisti',
    'host' => 'localhost'
);
if(isset($_GET['resume_status'])){
  $resume_status = $_GET['resume_status'];
}

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `student_info` AS `a` JOIN `student_resume_data` AS `c` JOIN `program_list` AS `b` ON (`a`.`stud_no` =  `c`.`stud_no` AND `a`.`program_id` = `b`.`program_id`)";     
$extraWhere = "`c`.resume_status = '".$resume_status."'";
echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);