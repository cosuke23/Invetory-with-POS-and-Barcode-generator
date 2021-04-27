<?php  

 require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

 if(isset($_POST["sol_id"]))  

 { 



      foreach($_POST["sol_id"] as $sol_id)  

      {  

           $query_update_dtr = "DELETE FROM official_student_list  WHERE sol_id = '".$sol_id."'";  

           mysqli_query($dbc, $query_update_dtr);

      } 

 }  

 ?>  