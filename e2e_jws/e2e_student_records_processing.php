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
  array( 'db' => '`a`.`stud_dp`', 
                    'dt' => 0 ,
                    'field' => 'stud_dp',
                    'formatter' => function($stud_dp,$row) {
                        $stud_no = $row[1];
                        return '<a href="e2e_update_student_records.php?stud_no='.$stud_no.'"><img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;"></a>' ;
                    }
                 ),
    array( 'db' => '`a`.`stud_no`', 'dt' => 1, 'field' =>'stud_no' ),
    array( 'db' => '`a`.`lname`', 'dt' => 2, 'field' => 'lname' ),
    array( 'db' => '`a`.`fname`', 'dt' => 3, 'field' => 'fname' ),
    array( 'db' => '`a`.`mname`', 'dt' => 4, 'field' => 'mname' ),
    array( 'db' => '`b`.`program_code`', 'dt' => 5, 'field' => 'program_code' ),
    array( 'db' => '`a`.`stud_no`',   
           'dt' => 6, 'field'=> 'stud_no',
           'formatter' => function($stud_no){
                $update_btn = '<a href="e2e_update_student_records.php?stud_no='.$stud_no.'" class=" btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" title="Update Info"><span class="glyphicon glyphicon-pencil">
                  </span></a>';
                $TIME_IN = '<a href="time_in.php?stud_no='.$stud_no.'" class="btn btn-outline btn-info" data-toggle="tooltip" data-placement="top" title="Session 1 Time in"><span class="glyphicon glyphicon-time"></span>T1</a>';
                $TIME_IN2 =  '<a href="time_in2.php?stud_no='.$stud_no.'" class="btn btn-outline btn-info" data-toggle="tooltip" data-placement="top" title="Session 2 Time in"><span class="glyphicon glyphicon-time"></span>T2</a>';
                return $update_btn.$TIME_IN.$TIME_IN2;
           }
          ),
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

$joinQuery = "FROM `student_info` AS `a` JOIN `program_list` AS `b` ON (`a`.`program_id` = `b`.`program_id`)";

$extraWhere = "";        

echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);