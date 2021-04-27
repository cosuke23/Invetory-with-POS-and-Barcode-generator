<?php
session_start();
require 'asset/connection/mysqli_dbconnection.php';

$table2 = "nop_ojt";
$columns2 = "ojt_id";
$ojt_id = $database->max($table2,$columns2) + 1;

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_add_ojt']))
{
	$comp_id			   =	$_POST['add_comp_id'];
	$comp_name			   =	$_POST['comp_name'];
	$status  			   =	$_POST['add_ojt_status'];
	$remarks			   =	$_POST['add_remarks'];
	$date_notary		   =	$_POST['add_date_notary'];
	$date_expiry		   =	$_POST['add_date_expiry'];
	$note			   	   =	$_POST['add_note'];
	$date_submit		   =	$_POST['add_date_submit'];

	if(!empty($remarks=='With MOA'))
    {
            $data = $database->insert("nop_ojt",[
            "status"               =>  $status,
            "ojt_id"               =>  $ojt_id,
            "comp_id"              =>  $comp_id,
            "remarks"              =>  $remarks,
            "date_notary"          =>  $date_notary,
            "date_expiry"          =>  $date_expiry,
            "note"                 =>  'None',
            "date_submit"          =>  '',
            ]);
            header("location: e2e_company_records.php?addojt=$comp_name");
    }
	elseif(!empty($remarks=='HTE Training Agreement/MOA'))
    {
            $data = $database->insert("nop_ojt",[
            "status"               =>  $status,
            "ojt_id"               =>  $ojt_id,
            "comp_id"              =>  $comp_id,
            "remarks"              =>  $remarks,
            "date_notary"          =>  $date_notary,
            "date_expiry"          =>  $date_expiry,
            "note"                 =>  'None',
            "date_submit"          =>  '',
            ]);
            header("location: e2e_company_records.php?addojt=$comp_name");
    }
	elseif(!empty($remarks=='For follow up'))
    {
            $data = $database->insert("nop_ojt",[
            "status"               =>  $status,
            "ojt_id"               =>  $ojt_id,
            "comp_id"              =>  $comp_id,
            "remarks"              =>  $remarks,
            "date_notary"          =>  '',
            "date_expiry"          =>  '',
            "note"                 =>  $note,
            "date_submit"          =>  $date_submit,
            ]);
            header("location: e2e_company_records.php?addojt=$comp_name");
    }
	elseif(!empty($remarks=='For Notary'))
    {
            $data = $database->insert("nop_ojt",[
            "status"               =>  $status,
            "ojt_id"               =>  $ojt_id,
            "comp_id"              =>  $comp_id,
            "remarks"              =>  $remarks,
            "date_notary"          =>  '',
            "date_expiry"          =>  '',
            "note"                 =>  $note,
            "date_submit"          =>  $date_submit,
            ]);
            header("location: e2e_company_records.php?addojt=$comp_name");
    }
	elseif(!empty($remarks=='Without MOA'))
    {
            $data = $database->insert("nop_ojt",[
            "status"               =>  $status,
            "ojt_id"               =>  $ojt_id,
            "comp_id"              =>  $comp_id,
            "remarks"              =>  $remarks,
            "date_notary"          =>  '',
            "date_expiry"          =>  '',
            "note"                 =>  'None',
            "date_submit"          =>  '',
            ]);
            header("location: e2e_company_records.php?addojt=$comp_name");
    }
	elseif(!empty($remarks=='Expired MOA'))
    {
            $data = $database->insert("nop_ojt",[
            "status"               =>  $status,
            "ojt_id"               =>  $ojt_id,
            "comp_id"              =>  $comp_id,
            "remarks"              =>  $remarks,
            "date_notary"          =>  '',
            "date_expiry"          =>  '',
            "note"                 =>  'None',
            "date_submit"          =>  '',
            ]);
            header("location: e2e_company_records.php?addojt=$comp_name");
    }
	elseif(!empty($remarks=='Banned'))
    {
            $data = $database->insert("nop_ojt",[
            "status"               =>  $status,
            "ojt_id"               =>  $ojt_id,
            "comp_id"              =>  $comp_id,
            "remarks"              =>  $remarks,
            "date_notary"          =>  '',
            "date_expiry"          =>  '',
            "note"                 =>  'None',
            "date_submit"          =>  '',
            ]);
            header("location: e2e_company_records.php?addojt=$comp_name");
    }
	elseif(!empty($remarks=='Others'))
    {
            $data = $database->insert("nop_ojt",[
            "status"               =>  $status,
            "ojt_id"               =>  $ojt_id,
            "comp_id"              =>  $comp_id,
            "remarks"              =>  $remarks,
            "date_notary"          =>  '',
            "date_expiry"          =>  '',
            "note"                 =>  'None',
            "date_submit"          =>  '',
            ]);
            header("location: e2e_company_records.php?addojt=$comp_name");
    }
}
?>
