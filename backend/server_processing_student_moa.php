<?php

function checkStud($stud_no,$tochange) {
                      $con = mysqli_connect('localhost','root','','e2e_ojtassisti');
                                    $results = mysqli_query($con,'SELECT count(stud_no) FROM student_checklist  WHERE remarks = "Completed" and deliverable_id=7 and stud_no='.$stud_no);
$querys = mysqli_fetch_array($results, MYSQLI_ASSOC);
           


if($querys>0){
                                            $resultx = mysqli_query($con,'SELECT stud_no,date_submitted FROM student_checklist  WHERE  deliverable_id=5 and stud_no='.$stud_no);
$query1 = mysqli_fetch_array($resultx, MYSQLI_ASSOC);
$day=$query1['date_submitted'];

$expi=date('Y-m-d',strtotime($day. '+ 14 days'));

 $resulti = mysqli_query($con,'SELECT `stud_no` FROM `student_report` WHERE `stud_no` = ' . $stud_no);
            $queryi = mysqli_fetch_array($resulti, MYSQLI_ASSOC);

            $result = mysqli_query($con,'SELECT stud_no,date_submitted FROM student_checklist  WHERE remarks = "On process" and deliverable_id=5 and date_submitted
                     >='.$expi.' and stud_no='.$stud_no );
            $query = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($queryi>0&&$query>0){
              return ($queryi ? "<font color='VIOLET'><B>".$tochange ."</B></font>" : $tochange);
            
            }else if($queryi>0){
              return ($queryi ? "<font color='RED'><B>".$tochange ."</B></font>" : $tochange);
            }
            return ($query ? "<font color='blue'><B>".$tochange ."</B></font>" : $tochange);
          }else{

                        $result = mysqli_query($con,'SELECT stud_no,date_submitted FROM student_checklist  WHERE remarks = "On Process" and deliverable_id=5 and stud_no='.$stud_no );
            $query = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return ($query ? "<font color='RED'><B>".$tochange ."</B></font>" : $tochange);
          }
}
     
// DB table to use
$table = 'student_info';

$primaryKey = 'stud_no';
 
$columns =  array(
            array( 'db' => 'stud_no', 
                    'dt' => 0 ,
                    'formatter' => function($stud_no) { 
                        return '<img src="../files/student_pics/' . $stud_no. '.jpg" style="height:50px;width:60px;">' ;
            
            
            
            
  
                    }
                 ),
            array( 'db' => 'stud_no', 'dt' => 1,
       'formatter' => function($stud_no) { 
          return checkStud($stud_no,$stud_no);
                    }),
            array( 'db' => 'lname', 'dt' => 2,
       'formatter' => function($lname,$row) { 
          $stud_no = $row[0];
          return checkStud($stud_no,$lname);
                    }),
            array( 'db' => 'fname', 'dt' => 3 ,
       'formatter' => function($fname,$row) { 
          $stud_no = $row[0];
          return checkStud($stud_no,$fname);
                    }),
            array( 'db' => 'mname', 'dt' => 4 ,
       'formatter' => function($mname,$row) { 
          $stud_no = $row[0];
          return checkStud($stud_no,$mname);
                    }),
            array( 'db' => 'stud_no', 
                    'dt' => 5 ,
                    'formatter' => function($stud_no) {
                       $edit = '<a href="update_Student_information.php?stud_no='.$stud_no.'">
                                  <button type="submit" class=" btn btn-outline btn-primary" data-toggle="tooltip" title= "Update Info">
                                  <span class="glyphicon glyphicon-pencil"></span></button>
                                  </a>';
                      $ojt_records = '<a href="student_ojt_details.php?stud_no='.$stud_no.'">
                                  <button type="submit" class="btn btn-outline btn-info" data-toggle="tooltip" title= "OJT Records">
                                  <span class="fa fa-file-text"></span></button>
                                  </a>';
                      $more = '<a href="view_Student_information.php?stud_no='.$stud_no.'">
                                  <button type="submit" class="btn btn-outline btn-warning" data-toggle="tooltip" title= "More">
                                  <span class="glyphicon glyphicon-info-sign"></span></button>
                                  </a>';
                        return $edit.$ojt_records.$more;
                    }
                 ),
            );
            
// SQL server connection information
$sql_details = array(
     'user' => 'root',
    'pass' => '',
    'db'   => 'e2e_ojtassisti',
    'host' => 'localhost'
);

 
require( 'ssp.class.php' );
$joinQuery = "FROM `student_info` AS `a` JOIN `student_checklist` AS `c`  ON (`a`.`stud_no` =  `c`.`stud_no`  )";     
$extraWhere = "";
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
   
);