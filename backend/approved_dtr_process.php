<?php  

 require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

 if(isset($_POST["dtr_id"]))  

 { 

      foreach($_POST["dtr_id"] as $dtr_id)  

      {  

           $query_update_dtr = "UPDATE dtr SET remarks = 'Approved' WHERE dtr_id = '".$dtr_id."'";  

           mysqli_query($dbc, $query_update_dtr);

           

      }  

 }  

 ?>  