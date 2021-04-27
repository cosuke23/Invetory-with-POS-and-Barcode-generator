<?php

// Start the session..

session_start();

// require the sql connection..

require 'asset/connection/mysqli_dbconnection.php';



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



if(isset($_POST['btn_add_program_category_list']))

  {

    $program_id =  mysqli_real_escape_string($dbc, trim($_POST['program_id']));

    $category_description =  mysqli_real_escape_string($dbc, trim($_POST['category_description']));

    $ojt_hours =  mysqli_real_escape_string($dbc, trim($_POST['ojt_hours']));



    

      //add query for program_category_list

      $category_id = generateId($dbc, 'category_id','program_category_list');



      $query_add_program_category_list = "INSERT INTO program_category_list(program_id,category_id,category_description,ojt_hours,status) VALUES

      ('$program_id','$category_id','$category_description','$ojt_hours','Active')";

      $result_add_program_category_list = mysqli_query($dbc,$query_add_program_category_list);

      

        $select_program_code = "SELECT program_code FROM program_list WHERE program_id = '$program_id'";

      $sresult_program_code = mysqli_query($dbc,$select_program_code);

        if($sresult_program_code->num_rows > 0)

               {   

                while ($row_name = mysqli_fetch_array($sresult_program_code))

                   {

                     $program_code = $row_name[0];      

                    }

              }

    

      if($result_add_program_category_list)

        {

          echo "Added";

          header("Location: program_category_list.php?added=1&category_description=$category_description&program_code=$program_code");

        }

      else  

      {

        echo "query error failed please try again.."; 

      } 

      

  }

?>

