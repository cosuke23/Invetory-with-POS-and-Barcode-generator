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
                    'formatter' => function($stud_dp) {
                        $decoded = base64_decode($stud_dp);
                        $x = finfo_open();
                        $type = finfo_buffer($x, $decoded, FILEINFO_MIME_TYPE);
                        // return '<img src="data:'.$type.';base64,'.$stud_dp.'" style="height:40px;width:50px;">' ;
                        // return '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;">' ;
                        return '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;">' ;
                    }, 'field' => 'stud_dp'
                 ),
     array( 'db' => '`a`.`stud_no`', 'dt' => 1, 'field' =>'stud_no' ),
    array( 'db' => '`a`.`lname`', 'dt' => 2, 'field' => 'lname' ),
    array( 'db' => '`a`.`fname`', 'dt' => 3, 'field' => 'fname' ),    
    array( 'db' => '`b`.`program_code`', 'dt' => 4, 'field' => 'program_code' ),
    array( 'db' => '`c`.`file_name`',   'dt' => 5, 'field' => 'file_name' ),      
    // array( 'db' => '`c`.`file_name`',   'dt' => 6, 'field' => 'file_name' ),      
    
    array( 'db' => '`a`.`stud_no`',              
           'dt' => 6,           
           'formatter' => function($stud_no,$row){
                $file_n = $row[5];  
            //disabled resume restriction
            //  if($file_n == "NO_RESUME.pdf"){
            //     $btn_add ='<button class="btn btn-outline btn-danger" disabled="disabled"><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Invalid Resume"></span></button>'; 
        
            // } 
            // else{
                $btn_add = "<a href='e2e_event_manager_add_stud_to_sched_process.php?mi_sched_id=".$_GET['mi_sched_id']."&event_id=".$_GET['event_id']."&event_name=".$_GET['event_name']."&stud_no=".$stud_no."&nop_comp=".$_GET['nop_comp']."' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Add To Schedule'><span class='fa fa-plus'></span></a>";
            // }
                
                return $btn_add;
           }, 'field' => 'stud_no' 
        )

   
);


// SQL server connection information
//require('asset/connection/mysqli_dbconnection.php');
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_jws',
    'host' => '127.0.0.1'
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

if(isset($_GET['semester']) && isset($_GET['acad_year_start']) && isset($_GET['program_id']) ){

  $semester = $_GET['semester'];
  $acad_year_start = $_GET['acad_year_start'];
  $program_id = $_GET['program_id'];
  
  $joinQuery = "FROM `student_info` AS `a` JOIN `program_list` AS `b` JOIN `resume_data` AS `c` ON (`a`.`program_id` = `b`.`program_id` AND `a`.`stud_no` = `c`.`stud_no`) ";  

  
  $extraWhere = "";

if($program_id == 0){
    $extraWhere = "`a`.`acad_year_start` = '".$acad_year_start."' AND `a`.`semester` = '".$semester."'";
}else{
    $extraWhere = "`a`.`acad_year_start` = '".$acad_year_start."' AND `a`.`program_id` = '".$program_id."' AND `a`.`semester` = '".$semester."'";
  }
} 
echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);