<?php
date_default_timezone_set('Asia/Manila');
// DB table to use
$table = 'company_info';

$primaryKey = 'comp_id';
 
$columns =  array(
            array( 'db' => 'comp_id', 
                    'dt' => 0 ,
                    'formatter' => function($comp_id) {
                       
                        return '<img src="../files/company/'.$comp_id.'.jpg" style="height:60px;width:60px;">' ;
                    }
                 ),
            array( 'db' => 'comp_name', 'dt' => 1 ),
            array( 'db' => 'address',   'dt' => 2),
            array( 'db' => 'contact_person',   'dt' => 3),
            array( 'db' => 'status',   
                   'dt' => 4,
                   'formatter' => function ($status) {
                        return $status;
                     },
                 ),
            array( 'db' => 'remarks',   
                   'dt' => 5,
                    'formatter' => function($remarks) {

                        return $remarks;
                     }, 
             ),
            array( 'db' => 'date_notary', 
                    'dt' => 6,
                    'formatter' => function ($date_notary) {
                        if($date_notary == '1970-01-01'){
                              $F_date_notary = "N/A";
                        }else{
                             $F_date_notary = date( 'M/d/Y', strtotime($date_notary));
                        }
                        return $F_date_notary;
                     }, 
                 ),
            array( 'db' => 'date_expiry', 
                   'dt' => 7,
                    'formatter' => function($date_expiry) {
                        if($date_expiry == '1970-01-01'){
                              $F_date_expiry = "N/A";
                        }else{
                             $F_date_expiry = date( 'M/d/Y', strtotime($date_expiry));
                        }
                        return $F_date_expiry;
                       
                     },
                 ),
            array( 'db' => 'comp_id',   
                   'dt' => 8,
                   'formatter' => function($comp_id,$row) { 
                        $data_status = $row[4];
                        $data_remarks = $row[5];
                        $up = '<a href="update_comp_cont_info.php?comp_id='.$comp_id.'">
                                  <button type="submit" class=" btn btn-outline btn-primary  btn-sm">
                                  <span class="glyphicon glyphicon-pencil"></span></button>
                                  </a>';
                         if($data_status == "Active"){
                            $offers =  '<a href="add_ojt_offers.php?comp_id='.$comp_id.'">
                                      <button type="submit" class="btn btn-outline btn-success btn-sm">
                                      <span class="glyphicon glyphicon-plus"></span></button>
                                      </a>';
                          }elseif($data_status == "Not Active"){
                            $offers =  '<label data-toggle="tooltip" title="You cannot add a new ojt OJT Offer to this company because it was not active." class=" btn btn-danger btn-outline btn-sm"> <span class="glyphicon glyphicon-lock"  data-placement="right" ></span></label>';
                          }
                          elseif($remarks == "expired MOA")
                          {
                             $offers = '<label data-toggle="tooltip" title="You cannot add a new ojt OJT Offer to this company because the MOA already expired." class=" btn btn-danger btn-outline  btn-sm"> <span class="glyphicon glyphicon-lock"  data-placement="right" ></span></label>';
                          }
                          elseif($remarks == "Banned")
                          {
                            $offers = '<label data-toggle="tooltip" title="You cannot add a new ojt OJT Offer to this company because it was Banned." class=" btn btn-danger btn-outline  btn-block btn-sm"> <span class="glyphicon glyphicon-lock" data-placement="right" ></span></label>';
                          }
                         $program = '<a href="company_manage_program.php?comp_id='.$comp_id.'">
                                  <button type="submit" class="btn btn-outline btn-info btn-sm">
                                  <span class="glyphicon glyphicon-list-alt"></span></button>
                                  </a>'; 
                        $more = '<a href="view_comp_cont_info.php?comp_id='.$comp_id.'">
                                  <button type="submit" class="btn btn-outline btn-warning btn-sm">
                                  <span class="glyphicon glyphicon-info-sign"></span></button>
                                  </a>';
                        
                        return $up.$offers.$program.$more;
                  }
                ),
              array( 'db' => 'comp_desc', 'dt' => 9),
              array( 'db' => 'city', 'dt' => 10),
              array( 'db' => 'tel_no', 'dt' => 11),
              array( 'db' => 'fax_no', 'dt' => 12),
              array( 'db' => 'email', 'dt' => 13),
              array( 'db' => 'position', 'dt' => 14)
            );
            
// SQL server connection information
$sql_details = array(
     'user' => 'sticaloo_e2e2',
    'pass' => 'e2eadmin',
    'db'   => 'sticaloo_ojtassisti',
    'host' => 'Localhost'
);

 
require( 'ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);