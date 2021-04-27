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
                    'formatter' => function($stud_dp) {
                        return '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;">' ;
                    }
                 ),
    array( 'db' => '`a`.`stud_no`', 'dt' => 1, 'field' =>'stud_no' ),
    array( 'db' => '`a`.`lname`', 'dt' => 2, 'field' => 'lname' ),
    array( 'db' => '`a`.`fname`', 'dt' => 3, 'field' => 'fname' ),
    array( 'db' => '`a`.`mname`', 'dt' => 4, 'field' => 'mname' ),
    array( 'db' => '`b`.`program_code`', 'dt' => 5, 'field' => 'program_code' ),
    array( 'db' => '`a`.`semester`',
			'dt' => 6, 
			'field' => 'semester' ,
			'formatter' => function($semester){
				if($semester == "2nd Semester"){
					$F_sem = "2nd Sem";
				}elseif($semester == "1st Semester"){
					$F_sem = "1st Sem";
				}elseif($semester == "Summer"){
          $F_sem = "Summer";
        }
				return $F_sem;
			}
		),
    array( 'db' => '`a`.`acad_year_start`', 'dt' => 7, 'field' => 'acad_year_start' ),
    array( 'db' => '`a`.`acad_year_end`', 'dt' => 8, 'field' => 'acad_year_end' ),
    array( 'db' => '`a`.`count_id`',   
           'dt' => 9, 
           'field' => 'count_id',
           'formatter' => function($count_id,$row){
            $stud_dp = $row[0];
            
                if($count_id > 1){
                  $F_count_id = "<label class='text-danger'> ".$count_id." ID(s)</label>";
                }
                elseif($count_id == 1){
                  $F_count_id = "<label style='color:orange;'>".$count_id." ID.
                    </label>";
                }elseif($stud_dp == 'DEFAULT.jpg'){
                  $F_count_id = "<label>- - -</label>";
                }
                else{
                  $F_count_id = "<label>- - -</label>";
                }
                return $F_count_id;
           }
        ),
  array( 'db' => '`a`.`claim_status`',   
           'dt' => 10,
           'field' => 'claim_status',
           'formatter' => function($claim_status,$row){
            $count_id = $row[9];
            $stud_dp = $row[0];
                if($claim_status == 0 && $count_id > 0){
                  $F_claim_status = "<label class='text-primary'>Ready to claim ID</label>";
                }elseif($count_id == 0 && $stud_dp == "DEFAULT.jpg"){
                   $F_claim_status = "<label>No Picture</label>";
                }elseif($count_id == 0 && $stud_dp != "DEFAULT.jpg"){
                   $F_claim_status = "<label>Ready to print ID</label>";
                }
                else{
                  $F_claim_status = "<label class='text-success'>Claimed</label>";
                }
                return $F_claim_status;
           }
        ),
    array( 'db' => '`a`.`claim_status`',   
           'dt' => 11,
           'field' => 'claim_status',
           'formatter' => function($claim_status,$row){
            $stud_no = $row[1];
            $stud_dp = $row[0];
            $count_id = $row[9];
                if($claim_status == 0 && $stud_dp != "DEFAULT.jpg" && $count_id > 0){
                  $btn_cs = "<a href='approved_grad_id_process.php?stud_no=".$stud_no."' class='btn btn-primary'><span class='fa fa-check'></span></a>";
                }else{
                  $btn_cs = "- - -";
                }
                return $btn_cs;
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