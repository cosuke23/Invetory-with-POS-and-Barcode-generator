<?php



require 'asset/connection/mysqli_dbconnection.php';



if(isset($_POST['btn_delete_comp'])){



$id=$_POST['comp_info_cb'];

$adviser_id =  implode(",",$id);

 

 echo $adviser_id;





}

?>