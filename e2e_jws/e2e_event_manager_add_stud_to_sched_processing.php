<?php
ob_start("ob_gzhandler");
require 'asset/connection/mysqli_dbconnection.php';
// $mi_sched_id = $_GET['mi_sched_id'];

$table = 'vw_stud_plus_course_and_resume';
$primaryKey = 'stud_no';
$columns = array(
	array( 'db' => 'stud_dp',
                    'dt' => 0 ,
                    'formatter' => function($stud_dp) {
                        $decoded = base64_decode($stud_dp);
                        $x = finfo_open();
                        $type = finfo_buffer($x, $decoded, FILEINFO_MIME_TYPE);
                        // return '<img src="data:'.$type.';base64,'.$stud_dp.'" style="height:40px;width:50px;">' ;
												// return '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;">' ;
                        return '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;">' ;
                    }
                 ),
    array( 'db' => 'stud_no',   'dt' => 1 ),
    array( 'db' => 'lname', 'dt' => 2 ),
    array( 'db' => 'fname',   'dt' => 3 ),
    array( 'db' => 'program_code',   'dt' => 4 ),  
    array( 'db' => 'file_name',   'dt' => 5 ),      
    array( 'db' => 'stud_no',              
           'dt' => 6,           
           'formatter' => function($stud_no,$row){
                $file_n = $row[5];  
                //disabled resume restriction
            //  if($file_n == "NO_RESUME.pdf"){
            //     $btn_add ='<button class="btn btn-outline btn-danger" disabled="disabled"><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Invalid Resume"></span></button>'; 
        
            // } else{
                $btn_add = "<a href='e2e_event_manager_add_stud_to_sched_process.php?mi_sched_id=".$_GET['mi_sched_id']."&event_id=".$_GET['event_id']."&event_name=".$_GET['event_name']."&stud_no=".$stud_no."' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Add To Schedule'><span class='fa fa-plus'></span></a>";
            // }
                
                return $btn_add;
           }
        )

   
);

// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_JWS',
    'host' => '127.0.0.1'
);
require( 'ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
