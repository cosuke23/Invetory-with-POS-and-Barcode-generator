<?php
date_default_timezone_set('Asia/Manila');
// DB table to use
$table = 'company_info_other_contact_person';

$primaryKey = 'id';
 
$columns =  array(
            array( 'db' => 'contact_person', 	'dt' => 0),
			array( 'db' => 'position',   	'dt' => 1),
            array( 'db' => 'tel_no',   		'dt' => 2),
			array( 'db' => 'email',         'dt' => 3),
			array( 'db' => 'status',         'dt' => 4),
			array( 'db' => 'remarks',         'dt' => 5),
			array( 'db' => 'date_notary',         'dt' => 6,
				   'formatter' => function($id,$row) {
					   $datenotary = $row[6];
					   $dateexpiry = $row[8];
					   
					   $datenotary2 = date('F d, Y', strtotime(str_replace('-', '/', $datenotary)));
					   $dateexpiry2 = date('F d, Y', strtotime(str_replace('-', '/', $dateexpiry)));
					   
					   $display ='<center>'.$datenotary2.' / '.$dateexpiry2.'</center>';
					   return $display;
				   }),
			
            array( 'db' => 'id',   
                   'dt' => 7,
                   'formatter' => function($id,$row) { 
                        $cp = $row[0];
                        $id = $row[7];
						$comp_id = $row[9];
                        $up = '<center>
								<a href="update_comp_contact_person.php?comp_id='.$comp_id.'&ocp_id='.$id.'">
                                  <div class="btn btn-outline btn-primary  btn-sm">
                                  <span class="glyphicon glyphicon-pencil"></span></div>
                               </a>';
                         
                        $del = '<a href="delete_company_info_other_contact_person.php?comp_id='.$comp_id.'&ocp_id='.$id.'&cp='.$cp.'">
                                  <div class="btn btn-outline btn-danger btn-sm">
                                  <span class="glyphicon glyphicon-trash"></span></div>
                                  </a></center>
								  ';

                        return $up.$del;						
                  }
                ),
			array( 'db' => 'date_expiry',         'dt' => 8),
			array( 'db' => 'comp_id', 	'dt' => 9)     
            );
			
            
// SQL server connection information
$sql_details = array(
     'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_ojtassisti',
    'host' => 'Localhost'
);


  


 
require( 'ssp.class.php' );

if(isset($_GET['comp_id']) ){
  $comp_id = $_GET['comp_id'];
 
  $where = "comp_id = $comp_id";
}

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$where)
);