<div id="showStudentModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>


	 <div class="modal-body">
			<input type="text" name="kurso" id ="kurso" ></input>
	 
	 
	 
		<?php
		echo $kurso;
		
		
		
									//	$query_studList = "SELECT a.stud_no, a.date_created, a.status, d.lname, d.fname, d.mname, c.program_code FROM endorsement AS a JOIN adviser_info AS b JOIN program_list AS c JOIN student_info AS d JOIN student_ojt_records as E WHERE a.comp_id='$comp_id2' AND b.adviser_id = a.adviser_id AND c.program_id = a.program_id AND d.stud_no=a.stud_no AND a.status='Active' AND a.stud_no = e.stud_no AND e.ojt_status='Ongoing' GROUP BY a.stud_no";
									/*
									$query_studList = "SELECT a.stud_no, a.date_created, a.status, d.lname, d.fname, d.mname, c.program_code FROM endorsement AS a JOIN adviser_info AS b JOIN program_list AS c JOIN student_info AS d JOIN student_ojt_records as Ee WHERE a.comp_id='$comp_id2' AND b.adviser_id = a.adviser_id AND c.program_id = a.program_id AND d.stud_no=a.stud_no AND a.status='Active' AND a.stud_no = Ee.stud_no AND Ee.ojt_status='Ongoing' GROUP BY a.stud_no";
																			
									$result_studList = mysqli_query($dbc, $query_studList);
										$nr = mysqli_num_rows($result_studList);
										 
									
									  print'<div class="panel-body">

									  <div class="responsive-table">
									  <table id="showStudentDATATABLES" class="table table-bordered table-hover table-condensed table-reflow" width="100%" cellspacing="0">
									  <thead>
										<tr>
											<th class="text-center">STUDENT NUMBER</th>
											<th class="text-center">FULL NAME</th>   
											<th class="text-center" >PROGRAM</th>
											<th class="text-center">DATE ISSUE</th>
											<th class="text-center">STATUS</th>                     
										</tr>
										</thead>
									  <tbody>';
									  
									  while($r_m = mysqli_fetch_array($result_studList)) {
									  
										$studNo = $r_m[0];
										$dateIssue = $r_m[1];
										$staTus = $r_m[2];
										$lname = $r_m[3];
										$fname = $r_m[4];
										$mname = $r_m[5];
										$progCode = $r_m[6];
									  */
									  ?>
							<!--		  <tr>
									<td><?php echo $studNo; ?></td>
										<td><?php echo $lname.", ".$fname." ".$mname; ?></td>
										<td><?php echo $progCode; ?></td>
										<td><?php echo $dateIssue; ?></td>
										<td><?php echo $staTus; ?></td>
									  </tr>
									  </tbody>
-->
									  <?php //}?>
									 <!--</table>
									 </div>
									 </div>-->
		
		
	  </div>
      
      <div class="modal-footer">
			<button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
$('#showStudentModal').modal("show");
</script>