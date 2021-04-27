<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_update_ojt']))
{
	$ojt_id				=   $_POST['ojt_id'];
    $remarks		   	=   $_POST['remarks'];
    $date_notary		=   $_POST['date_notary'];
    $date_expiry		=   $_POST['date_expiry'];
    $note				=   $_POST['note'];
    $date_submit		=   $_POST['date_submit'];
    $ojt_status        	=   $_POST['ojt_status'];
		$comp_name        	=   $_POST['comp_name'];

    if($remarks=='With MOA'){
		$table 	 = "nop_ojt";
		$columns = ["status"	=>  $ojt_status,
            		"remarks"   	=>  $remarks,
            		"date_notary"   =>  $date_notary,
            		"date_expiry"   =>  $date_expiry,
            		"note"          =>  'None',
            		"date_submit"   =>  '',
		];
		$where = ["ojt_id" => $ojt_id];
		$q_data = $database->update($table,$columns,$where);
		header("Location: e2e_company_records.php?update=$comp_name");
	}
	elseif($remarks=='Without MOA'){
		$table 	 = "nop_ojt";
		$columns = ["status"    =>  $ojt_status,
            		"remarks"       =>  $remarks,
            		"date_notary"   =>  '',
            		"date_expiry"   =>  '',
            		"note"          =>  'None',
            		"date_submit"   =>  '',
		];
		$where = ["ojt_id" => $ojt_id];
		$q_data = $database->update($table,$columns,$where);
		header("Location: e2e_company_records.php?update=$comp_name");
	}
	elseif($remarks=='For follow up'){
		$table 	 = "nop_ojt";
		$columns = ["status"    =>  $ojt_status,
            		"remarks"       =>  $remarks,
            		"date_notary"   =>  '',
            		"date_expiry"   =>  '',
            		"note"          =>  $note,
            		"date_submit"   =>  $date_submit,
		];
		$where = ["ojt_id" => $ojt_id];
		$q_data = $database->update($table,$columns,$where);
		header("Location: e2e_company_records.php?update=$comp_name");
	}
	elseif($remarks=='Expired MOA'){
		$table 	 = "nop_ojt";
		$columns = ["status"    =>  $ojt_status,
            		"remarks"       =>  $remarks,
            		"date_notary"   =>  '',
            		"date_expiry"   =>  '',
            		"note"          =>  'None',
            		"date_submit"   =>  '',
		];
		$where = ["ojt_id" => $ojt_id];
		$q_data = $database->update($table,$columns,$where);
		header("Location: e2e_company_records.php?update=$comp_name");
	}
	elseif($remarks=='HTE Training Agreement/MOA'){
		$table 	 = "nop_ojt";
		$columns = ["status"		=>  $ojt_status,
            		"remarks"   	=>  $remarks,
            		"date_notary"   =>  $date_notary,
            		"date_expiry"   =>  $date_expiry,
            		"note"          =>  'None',
            		"date_submit"   =>  '',
		];
		$where = ["ojt_id" => $ojt_id];
		$q_data = $database->update($table,$columns,$where);
		header("Location: e2e_company_records.php?update=$comp_name");
	}
	elseif($remarks=='Banned'){
		$table 	 = "nop_ojt";
		$columns = ["status"	    =>  $ojt_status,
            		"remarks"       =>  $remarks,
            		"date_notary"   =>  '',
            		"date_expiry"   =>  '',
            		"note"          =>  'None',
            		"date_submit"   =>  '',
		];
		$where = ["ojt_id" => $ojt_id];
		$q_data = $database->update($table,$columns,$where);
		header("Location: e2e_company_records.php?update=$comp_name");
	}
	elseif($remarks=='For Notary'){
		$table 	 = "nop_ojt";
		$columns = ["status"	    =>  $ojt_status,
            		"remarks"       =>  $remarks,
            		"date_notary"   =>  '',
            		"date_expiry"   =>  '',
            		"note"          =>  $note,
            		"date_submit"   =>  $date_submit,
		];
		$where = ["ojt_id" => $ojt_id];
		$q_data = $database->update($table,$columns,$where);
		header("Location: e2e_company_records.php?update=$comp_name");
	}
}

?>
