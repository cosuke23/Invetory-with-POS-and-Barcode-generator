<?php  

 require 'asset/connection/mysqli_dbconnection.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);

 if(isset($_POST["program_id"]))  

 {  

      foreach($_POST["program_id"] as $program_id)  

      {  

           $program_list_delete = "DELETE FROM program_list WHERE program_id = '".$program_id."'";  

           mysqli_query($dbc, $program_list_delete);  

      }  

 }  

 ?>  