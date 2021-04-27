<?php  

 require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

 if(isset($_POST["ach_id"]))  

 { 



      foreach($_POST["ach_id"] as $ach_id)  

      {  

           $query_delete_consultation_hours = "DELETE FROM adviser_consultation_hours WHERE ach_id = '".$ach_id."'";  

           mysqli_query($dbc, $query_delete_consultation_hours);

      }  

 }  

 ?>  