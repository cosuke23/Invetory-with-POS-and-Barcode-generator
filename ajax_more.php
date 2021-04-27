<?php
if(isset($_POST["comp_id"]) && !empty($_POST["comp_id"])){
date_default_timezone_set('Asia/Manila');
//include database configuration file
require 'assets/connection/mysqli_dbconnection.php';
$comp_search=$_POST['comp_search'];
//count all rows except already displayed
$queryAll = mysqli_query($dbc,"SELECT COUNT(*) as num_rows FROM company_info WHERE comp_id < ".$_POST['comp_id']." and status='Active' ORDER BY comp_id DESC");
$row = mysqli_fetch_assoc($queryAll);
$allRows = $row['num_rows'];

$showLimit = 10;

//get rows query
if($comp_search === ""){
$query = mysqli_query($dbc, "SELECT * FROM company_info WHERE comp_id < ".$_POST['comp_id']." and status='Active' ORDER BY comp_id DESC LIMIT ".$showLimit);
}else{
$query = mysqli_query($dbc, "SELECT * FROM company_info WHERE comp_id < ".$_POST['comp_id']." and status='Active' and (comp_name LIKE '%$comp_search%' OR comp_desc LIKE '%$comp_search%') ORDER BY comp_id DESC LIMIT ".$showLimit);
}
//number of rows
$rowCount = mysqli_num_rows($query);

if($rowCount > 0){ 
    while($row = mysqli_fetch_assoc($query)){ 
        $comp_id = $row['comp_id'];
		$comp_pic64 = $row['img_data'];
		$comp_pic_decoded = base64_decode($comp_pic64);
		$f=finfo_open();
		$compImage_type = finfo_buffer($f, $comp_pic_decoded, FILEINFO_MIME_TYPE);
		?>
       
		<a href="company_info.php?comp_id=<?php echo $comp_id; ?>">
			<div style="padding-left:20px;padding-top:10px"  class="list_item pn-offer">
				<span style="font-size:17px;"><?php echo $row['comp_name']; ?></span>
				<img class="" style="float:right;padding-right:10px;padding-top:5px;padding-bottom:5px" src=<?php echo '"data:'.$compImage_type.';base64,'.$comp_pic64.'"'; ?> width="50" height="50">
			</div>
		</a>
		
<?php } ?>
<?php if($allRows > $showLimit){ ?>
    <div class="show_more_main" id="show_more_main<?php echo $comp_id; ?>">
        <span id="<?php echo $comp_id; ?>" class="show_more" title="Load more posts">Show more</span>
        <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
    </div>
<?php } ?>  
<?php 
    } 
}
?>