<?php
ob_start("ob_gzhandler");
require 'asset/connection/mysqli_dbconnection.php';
$table = 'student_info';
$primaryKey = 'stud_no';
$columns = array(
	array( 'db' => 'stud_dp',
                    'dt' => 0 ,
                    'formatter' => function($stud_dp) {
                        $decoded = base64_decode($stud_dp);
                        $x = finfo_open();
                        $type = finfo_buffer($x, $decoded, FILEINFO_MIME_TYPE);
                        // return '<img src="data:'.$type.';base64,'.$stud_dp.'" style="height:40px;width:50px;">' ;
												return '<img src="grad_id/grad_data/student_image/'.$stud_dp.'" style="height:40px;width:50px;">' ;
                    }
                 ),
    array( 'db' => 'stud_no',   'dt' => 1 ),
    array( 'db' => 'lname', 'dt' => 2 ),
    array( 'db' => 'fname',   'dt' => 3 ),
    array( 'db' => 'mname',   'dt' => 4 ),
    array( 'db' => 'count_b_card',
           'dt' => 5,
           'formatter' => function($count_b_card){
                if($count_b_card > 1){
                  $F_count_b_card = "<label style='color:red;'>This student has already been issued business cards ".$count_b_card." time(s).</label>";
                }
                elseif($count_b_card == 1){
                  $F_count_b_card = "<label style='color:orange;'>This student has already been issued business cards ".$count_b_card." time(s).
                    </label>";
                }else{
                  $F_count_b_card = "<label style='color:green;'>Ready to print business cards.</label>";
                }
                return $F_count_b_card;
           }
        ),
    array( 'db' => 'stud_no',
           'dt' => 6,
           'formatter' => function($stud_no,$row){
            $count_b_card = $row[5];
            if($count_b_card > 1){
             $btn_download = "<a href ='grad_id/grad_data/generate_b_card_download.php?stud_no=".$stud_no."' class='btn btn-primary'><span class=
             'fa fa-download'></span></a>";   
            }else{
              $btn_download ="- - -";
            }
           
              return $btn_download;
           }
        ),
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
