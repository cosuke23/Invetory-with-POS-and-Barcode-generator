<?php


// DB table to use
$table = 'ojt_offers';

// Table's primary key
$primaryKey = 'ojt_offers_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
   array( 'db' => '`a`.`comp_id`', 
                    'dt' => 0 ,
                    'field' => 'comp_id',
                    'formatter' => function($comp_id) {        
                        return '<img src="../files/company/'.$comp_id.'.jpg" style="height:50px;width:60px;">' ;
                    }
                 ),
    array( 'db' => '`b`.`comp_name`', 'dt' => 1, 'field' =>'comp_name' ),
    array( 'db' => '`a`.`ojt_title`', 'dt' => 2, 'field' => 'ojt_title' ),
    array( 'db' => '`a`.`ojt_desc`', 'dt' => 3, 'field' => 'ojt_desc' ),
    array( 'db' => '`b`.`status`', 'dt' => 4, 'field' => 'status' ),
    array( 'db' => '`c`.`program_code`', 'dt' => 5, 'field' => 'program_code' ),
    array( 'db' => '`a`.`ojt_offers_id`', 
                    'dt' => 6, 
                    'field' => 'ojt_offers_id',
                    'formatter' => function($ojt_offers_id,$row){
                      $status = $row[4];
                      $comp_id = $row[0];
                      $btn_view = '<a href="update_OJT_offers.php?comp_id='.$comp_id.'&ojt_offers_id='.$ojt_offers_id.'">
                                  <button type="submit" class="btn btn-outline btn-primary" data-toggle="tooltip" title= "View Offer">
                                  <span class="glyphicon glyphicon-eye-open"></span></button>
                                  </a>';

                      if($status == "Active"){
                        $btn_update = '<a href="update_OJT_offers.php?comp_id='.$comp_id.'&ojt_offers_id='.$ojt_offers_id.'">
                                  <button type="submit" class=" btn btn-outline btn-primary" data-toggle="tooltip" title= "Update Offer"><span class="glyphicon glyphicon-pencil"></span></button>
                                  </a>';
                      }else{
                         $btn_update =  '<td><label data-toggle="tooltip" title="You cannot update this offer because the company status not active." class=" btn btn-danger btn-outline "> <span class="glyphicon glyphicon-lock"  data-placement="right"></span></label> 
                        </td>';
                      }
                      return $btn_view.$btn_update;
                    }                    
                  ),
);


// SQL server connection information
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_ojtassisti',
    'host' => 'localhost'
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `ojt_offers` AS `a` JOIN `company_info` AS `b` JOIN `program_list` AS `c` ON (`a`.`comp_id` =  `b`.`comp_id` AND `a`.`program_id` = `c`.`program_id`)";     
$extraWhere = "";
echo json_encode(
  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);