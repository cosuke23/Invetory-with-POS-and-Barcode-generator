<?php


// DB table to use
$table = 'company_info';

// Table's primary key
$primaryKey = 'comp_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
  array( 'db' => 'comp_logo',
  'dt' => 0 ,
  'formatter' => function($comp_logo) {
    $decoded = base64_decode($comp_logo);
    $x = finfo_open();
    $type = finfo_buffer($x, $decoded, FILEINFO_MIME_TYPE);
    return '<img src="data:'.$type.';base64,'.$comp_logo.'" style="height:50px;width:60px;">';
  }
),
array( 'db' => 'comp_name', 'dt' => 1),
array( 'db' => 'comp_address', 'dt' => 2),
array( 'db' => 'status', 'dt' => 3),
array( 'db' => 'comp_dept', 'dt' => 4),
array( 'db' => 'username', 'dt' => 5),
array( 'db' => 'password', 'dt' => 6),
array( 'db' => 'comp_id',
'dt' => 7 ,
'formatter' => function($comp_id) {
  $btn = '<a href="e2e_update_company_records.php?comp_id='.$comp_id.'" class="btn btn-outline btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Update Company Info">
  <span class="glyphicon glyphicon-pencil"></span>
  </a>';
  $btn2 = '<a href="e2e_mock_interview_records.php?comp_id='.$comp_id.'" class="btn btn-outline btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Mock Interview Records">
  <span class="icon icon-people"></span>
  </a>';
  return $btn.$btn2;
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
require('ssp.class.php' );

echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
);
