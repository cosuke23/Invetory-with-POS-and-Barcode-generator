<?php
ob_start("ob_gzhandler");
require 'asset/connection/mysqli_dbconnection.php';
$table = 'user_info';
$primaryKey = 'user_id';
$columns = array(
	array( 'db' => 'profileData',
                    'dt' => 0 ,
                    'formatter' => function($profileData) {
                        $decoded = base64_decode($profileData);
                        $x = finfo_open();
                        $type = finfo_buffer($x, $profileData, FILEINFO_MIME_TYPE);
                        return '<img src="data:'.$type.';base64,'.$profileData.'" style="height:40px;width:50px;">' ;
                         }
                 ),
    array( 'db' => 'username',   'dt' => 1 ),
    array( 'db' => 'title',   'dt' => 2 ),
    array( 'db' => 'lname', 'dt' => 3 ),
    array( 'db' => 'fname',   'dt' => 4 ),
    array( 'db' => 'mname',   'dt' => 5 ),
   array( 'db' => 'usertype',  
            'dt' => 6,
            'formatter' => function($usertype){
             if($usertype == 1){
                $position = "Admin";
             }elseif($usertype == 2){
                 $position = "OJT";
             }elseif($usertype == 3){
                 $position = "Student Assistant";
             }
             return $position;   
            }
        ),
    array( 'db' => 'user_id',
           'dt' => 7,
           'formatter' => function($user_id){
             $btn_edit = "<a href ='e2e_update_user_account.php?user_id=".$user_id."' class='btn btn-primary'><span class='fa fa-pencil'></span></a>";
             return $btn_edit;   
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
