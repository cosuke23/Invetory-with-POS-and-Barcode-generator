<?php

// Start the session..

session_start();

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';

include '/default_comp_img.php';



//Show all possible problems..

error_reporting(E_ALL | E_STRICT);



// Set the auto increment..

function generateId($con, $id, $table_name) {

    $query = "SELECT $id FROM $table_name";

    $result = mysqli_query($con, $query);

    $num = mysqli_num_rows($result);

    if($num <= 0) {

        $id = 1;

        return $id;

    } else {

        $query1 = "SELECT MAX($id) FROM $table_name";

        $result1 = mysqli_query($con, $query1);

        $row1 = mysqli_fetch_array($result1, MYSQLI_NUM);

        $id = $row1[0] + 1;

        return $id;

    }

}



if(isset($_POST['btn_add_consulation_hours']))

  {

    $adviser_id =  mysqli_real_escape_string($dbc, trim($_POST['adviser_id']));

    $ach_id =  mysqli_real_escape_string($dbc, trim($_POST['ach_id']));

    $hour_start =  mysqli_real_escape_string($dbc, trim($_POST['hour_start']));

    $hour_end =  mysqli_real_escape_string($dbc, trim($_POST['hour_end']));

    $day =  mysqli_real_escape_string($dbc, trim($_POST['day']));

      $ach_id = generateId($dbc, 'ach_id','adviser_consultation_hours');



     //----------

	 $q_adviserdata = "select * from adviser_consultation_hours where adviser_id='$adviser_id' and day='$day' and hour_start ='$hour_start' and hour_end='$hour_end'";

   

	 $q_adviserdata_res= $dbc->query($q_adviserdata);

	 if($q_adviserdata_res->num_rows != 0){

		

			header("Location: add_consultation_hours.php?error1=1&adviser_id=$adviser_id");

      exit;

	 }



   else{

		

	  $query_add_con_hr = "INSERT INTO adviser_consultation_hours(adviser_id,day,hour_start,hour_end,ach_id) VALUES

      ('$adviser_id','$day','$hour_start','$hour_end','$ach_id')";



      $result_add_con_hr = mysqli_query($dbc,$query_add_con_hr);

      if($result_add_con_hr)

        {

          echo "add CH";

          header("Location:add_consultation_hours.php?username=$adviser_id&success=1");

          

        }

      else  

      {

        echo "query error failed please try again.."; 

      }

	 

	 }

  }

	 

	 

	

	 //----------



      //add query for company_info

    





?>

