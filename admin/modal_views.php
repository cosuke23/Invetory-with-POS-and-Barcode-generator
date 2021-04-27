      	 <div id="view<?php echo $cid; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
          	 <?php



  $query = mysql_query("SELECT * from candidatesq left join files  on candidatesq.student_id=files.student_id where candidatesq.id='$cid'") or die(mysql_error());
  while ($row = mysql_fetch_array($query)) {
    $image= $row['floc'];
$img="data:image/png;base64,$image";
    ?>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 id="myModalLabel">Students Answer</h3>
          </div>
          <div class="modal-body">
          <div class="alert alert-success">

<img  src="<?php echo $img; ?>" alt="POGI" /></br>
                    
                      Q2:Refered to Q1; Why did you chose this position?: <?php echo $row['Ans_Q2']; ?><br>
										Q3: Do you think your ready for this position ? why?:<?php echo $row['Ans_Q3']; ?><br>
											Q4: Could you Do it? Defend your answer.:<?php echo $row['Ans_Q4']; ?><br>
											Q5:Your Main Flatform!  :<?php echo $row['Ans_Q5']; ?><br>
							
  <?php } ?>
          </div>
          </div>
          </div>