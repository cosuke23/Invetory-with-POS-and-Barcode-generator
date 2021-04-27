<?php
  // require  'asset\connection\medoo\medoo.php';
  require 'asset/connection/mysqli_dbconnection.php';
    $conn = mysqli_connect("localhost", "root", "", "e2e_jws");
    $db = new medoo([
    // required
    'database_type' => 'mysql',
    'database_name' => 'e2e_jws',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'option' => [
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
      ]
  ]);

     $table = "event_manager";
    $columns = "*";
    $where = ["event_id" => $_GET['event_id']];

    $q_mi_sched_info =$database->get($table,$columns,$where);
    $event_date = $q_mi_sched_info["event_date"];
    $event_s_date = $q_mi_sched_info["event_start_date"];
    $event_e_date = $q_mi_sched_info["event_end_date"];

    $event_s_date_f = date("F j, Y",strtotime($event_s_date));
    $event_e_date_f = date("F j, Y",strtotime($event_e_date));
    $event_mi_period = $event_s_date_f . " - " . $event_e_date_f;

 
  
  $sql = "SELECT      
            b.stud_no AS 'STUDENT NO.',
            c.lname AS 'LAST NAME',
            c.fname AS 'FIRST NAME',
            d.program_code AS 'COURSE',
--            a.mi_sched_id AS 'MI NO.',
--             DATE_FORMAT(str_to_date(z.event_date, '%m/%d/%Y'),'%M %d, %Y') AS 'DATE',                 
            a.event_mi_batch_no AS 'BATCH NO.',
            DATE_FORMAT(a.event_mi_batch_date,'%M %d, %Y') AS 'DATE',                 
            TIME_FORMAT(a.time_start, '%h:%i %AM') AS 'START TIME',
            TIME_FORMAT(a.time_end, '%h:%i %AM') AS 'END TIME',
            a.venue AS 'VENUE',
            f.comp_name AS 'COMPANY ASSIGNMENT'
FROM        event_manager AS z 
INNER JOIN  event_mi_sched AS a ON z.event_id = a.event_id
INNER JOIN  event_mi_sched_stud_set AS b ON a.mi_sched_id = b.mi_sched_id 
INNER JOIN  student_info AS c ON b.stud_no = c.stud_no 
INNER JOIN  program_list AS d ON c.program_id = d.program_id 
LEFT OUTER JOIN nop_mock_interview AS e ON b.company_assigned_id = e.mi_id
LEFT OUTER JOIN company_info AS f ON f.comp_id = e.comp_id  
WHERE       z.event_id='4' AND b.status='Set'
ORDER BY    a.mi_sched_id ASC, c.lname ASC";


  $rec = mysqli_query($conn, $sql);
  $num_fields = mysqli_num_fields($rec);
  $header = "";
  $data = "";
  for($i = 0; $i < $num_fields; $i++ ) {
    $header .= mysqli_fetch_field_direct($rec,$i)->name . "\t";
  }
  while($row = mysqli_fetch_row($rec)) {
    $line = '';
    foreach($row as $value) {
      if((!isset($value)) || ($value == "")) {
        $value = "\t";
      } else {
        $value = str_replace( '"' , '""' , $value);
        $value = '"' . $value . '"' . "\t";
      }
      $line .= $value;
    }
    $data .= trim( $line ) . "\n";
  }
  $data = str_replace("\r" , "" , $data);
  if ($data == "") {
    $data = "\n No Record Found!\n";
  }
  header("Content-type: application/xls");
  header("Content-Disposition: attachment; filename=mock_interview_sched.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
  print "".$_GET['event_name']."\n$event_mi_period\n\n$header\n$data";
?>