<?php
if(isset($_POST["ojt_offers_id"]) && !empty($_POST["ojt_offers_id"])){
date_default_timezone_set('Asia/Manila');
//include database configuration file
require 'assets/connection/mysqli_dbconnection.php';
$program_id=$_POST['program_id'];
$ojt_search=$_POST['ojt_search'];
//count all rows except already displayed
$queryAll = mysqli_query($dbc,"SELECT COUNT(*) as num_rows FROM ojt_offers WHERE ojt_offers_id < ".$_POST['ojt_offers_id']." and status='Available' and program_id='$program_id' ORDER BY ojt_offers_id DESC");
$row = mysqli_fetch_assoc($queryAll);
$allRows = $row['num_rows'];

$showLimit = 10;

//
//get rows query
if($ojt_search === ""){
$query = mysqli_query($dbc, "SELECT * FROM ojt_offers WHERE ojt_offers_id < ".$_POST['ojt_offers_id']." and status='Available' and program_id='$program_id' ORDER BY ojt_offers_id DESC LIMIT ".$showLimit);
}else{
$query = mysqli_query($dbc, "SELECT * FROM ojt_offers WHERE ojt_offers_id < ".$_POST['ojt_offers_id']." and status='Available' and program_id='$program_id' and (ojt_title LIKE '%$ojt_search%' OR ojt_desc LIKE '%$ojt_search%') ORDER BY ojt_offers_id DESC LIMIT ".$showLimit);
}



//number of rows
$rowCount = mysqli_num_rows($query);

if($rowCount > 0){ 
    while($row = mysqli_fetch_assoc($query)){ 
        $ojt_offers_id = $row['ojt_offers_id'];
		$comp_id = $row['comp_id'];
		//get company
		$q_compny = "select * from company_info where comp_id = '$comp_id'";
		$q_compny_res= $dbc->query($q_compny);
		$cmpny = $q_compny_res->fetch_assoc();
		?>
       
		<a href="view_offer.php?ojt_offers_id=<?php echo $ojt_offers_id; ?>">
			<div style="padding-left:20px;padding-top:10px"  class="list_item pn-offer">
			<img src="assets/img/ojt_offer_icon.png" style="padding-bottom:7px;float:right;margin-right:30px" width="50">
				<span style="font-size:17px;"><?php echo $row['ojt_title']; ?></span><br>
				<span style="font-size:10px;"><?php echo $cmpny['comp_name']; ?></span>
				
			</div>
		</a>
<?php } ?>
<?php if($allRows > $showLimit){ ?>
    <div class="show_more_main" id="show_more_main<?php echo $ojt_offers_id; ?>">
        <span id="<?php echo $ojt_offers_id; ?>" class="show_more" title="Load more posts">Show more</span>
        <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
    </div>
<?php } ?>  
<?php 
    } 
}
?>