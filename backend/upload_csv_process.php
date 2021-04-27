<?php

require 'asset/connection/mysqli_dbconnection.php';



$db = mysql_connect("localhost", "sticaloo_e2e2", "e2eadmin") or die("Could not connect.");

ini_set('max_execution_time', 10000);

if(!$db) 

    die("no db");

if(!mysql_select_db("sticaloo_ojtassisti",$db))

    die("No database selected.");

  

if (isset($_POST['submit'])) {

    $fileinfo = pathinfo($_FILES["filename"]["name"]);

    $filetype = $_FILES["filename"]["type"];

    $filename = basename($_FILES['filename']['name']);

     //$newname = dirname(__FILE__).'/uploadCSV/'.$filename;

   if(empty($filetype)){

         header("Location:upload.php?error2=1");

        exit;

    }   

    else if(strtolower(trim($fileinfo["extension"])) != "csv")

    {

        header("Location:upload.php?error=1&filename=$filename");

         exit;

    }

    else if (is_uploaded_file($_FILES['filename']['tmp_name'])) {

        //Import uploaded file to Database

        $handle = fopen($_FILES['filename']['tmp_name'], "r");

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

           $q_SSOL = "SELECT stud_no FROM official_student_list";             

           $result_q_SSOL =  mysqli_query($dbc, $q_SSOL);

           

           if($result_q_SSOL->num_rows > 0 )

             {           

              while ($row = mysqli_fetch_array($result_q_SSOL))

              {

                    $stud_no = $row[0]; 

                if($stud_no == $data[0])

                {   

                    $query_update_sol = "DELETE FROM official_student_list WHERE stud_no = '$stud_no'";

                    mysql_query($query_update_sol) or die(mysql_error()); 

                }

             }

              $import="INSERT INTO official_student_list(stud_no,lname,fname,mname,program_code,status) 

                    VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]')";

                    mysql_query($import) or die(mysql_error());

        }else{



        }

    }   

        fclose($handle);

        echo "successfully inserted";

        header("Location:upload.php?success=1&filename=$filename");

    }

    

}

?>