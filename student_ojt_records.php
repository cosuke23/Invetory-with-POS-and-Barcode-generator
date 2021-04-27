<?php
$page_title = 'OJT AssiSTI Student Registration';
// require the sql connection..
require 'asset/connection/mysqli_dbconnection.php';
date_default_timezone_set("Asia/Manila");
$acad_year_start = date('Y');
$acad_year_end = $acad_year_start +1;
date_default_timezone_set("Asia/Manila");
$current_year = date("Y") - 1;
$next_year = date("Y") + 1;
 $stud_no= $_GET['stud_no'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OJT assiSTI</title>
  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker.css"/>
  <link rel="stylesheet"  type="text/css" href="asset/css/bootstrap-datepicker.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/datepicker.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/datepicker3.min.css" />
  <link rel="stylesheet"  type="text/css" href="asset/css/animate.notify.css" />
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>
  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>
  <link href="asset/css/style.css" rel="stylesheet">
  <!-- end: Css -->
  <link rel="shortcut icon" href="asset/img/ojtassistilogo.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
	  
	  <?php
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
		?>
</head>
<body id="mimin" class="dashboard">
      
   <div class="container-fluid mimin-wrapper">
    <!-- start:Left Menu -->
		<?php
			$query_stud_info = "SELECT a.stud_no,a.lname,a.fname,a.mname,a.gender,DATE_FORMAT(a.bday, '%m/%d/%Y') AS bday,a.email,a.mobile_no,a.tel_no,a.address,a.facebook,a.program_id, b.program_code, c.ojt_status, c.year_level, c.semester, c.category_id, d.category_description, c.acad_year_start, c.acad_year_end FROM student_info AS a INNER JOIN program_list AS b INNER JOIN student_ojt_records AS c INNER JOIN program_category_list AS d WHERE a.program_id = b.program_id AND b.program_id = d.program_id AND a.stud_no = c.stud_no AND a.stud_no='$stud_no';";
            $result_stud_info = mysqli_query($dbc, $query_stud_info);
            $num_rows = mysqli_num_rows($result_stud_info);
			
            while($row = mysqli_fetch_array($result_stud_info)) 
			{
                $stud_no = $row[0];
                $lname = $row[1];
                $fname = $row[2];
                $mname = $row[3];
                $gender = $row[4];
                $bday = $row[5];
                $email = $row[6];
                $mobile_no = $row[7];
                $tel_no = $row[8];
                $address = $row[9];
                $facebook = $row[10];
				$program_id = $row[11];
                $program_code = $row[12];
				$ojt_status = $row[13];
				$year_lvl = $row[14];
				$semester = $row[15];
				$category_id= $row[16];
				$ojt_category = $row[17];
				$acad_year_start = $row[18];
				$acad_year_end = $row[19];
			}
		
		?>
            
          <!-- start: Content -->
            <div >
              <div class="col-md-12 padding-0">
                <div class="col-md-12 padding-0">
                  <div class="panel">
                   <div class="row">
                            <div class="panel-heading"><h3>OJT RECORDS INFORMATION</h3></div>
                          </div>
					<form id="defaultForm" method="post" action="student_update_ojt_records_process.php<?php if(isset($_GET['rb'])){echo "?rb=1";}?>" enctype="multipart/form-data">
						  <input type="hidden" name="stud_no" value="<?php echo $stud_no;?>"/>
						  
						  <?php
							$query_stud_records = "SELECT a.stud_no,a.year_level,a.semester,c.section,a.category_id,a.enrollment_status,a.ojt_status,a.acad_year_start,a.acad_year_end,b.category_description FROM student_ojt_records AS a INNER JOIN program_category_list AS b INNER JOIN section_list AS c WHERE c.section_id = a.section_id AND a.category_id = b.category_id AND a.stud_no = '$stud_no'";
							$result_stud_records = mysqli_query($dbc, $query_stud_records);
							$num_rows = mysqli_num_rows($result_stud_records); 
							  
                              while($row = mysqli_fetch_array($result_stud_records)) {
								$stud_no_records = $row[0];
								$year_level_rd = $row[1];
								$semester_rd = $row[2];
								$section_rd = $row[3];
								$category_id_rd = $row[4];
								$enrollment_status_rd = $row[5];
								$ojt_status_rd = $row[6];
								$acad_year_start_rd = $row[7];
								$acad_year_end_rd = $row[8];
								$category_description = $row[9];
								
							if($program_id == 2 || $program_id == 3 || $program_id == 4)
							{
								if($ojt_status == "Finished" || $ojt_status_rd == "Finished")
								{
									if($category_id == 4 || $category_id == 7 || $category_id == 9)
									{
										$show="block";
										$show2="block";
										
									}
									else
									{
										$show="block";
										$show2="block";
									}
									$status="Finished";
								}
								else if($ojt_status == "Ongoing" || $ojt_status_rd == "Ongoing")
								{
									$show="none";
									$show2="block";
									$status="Ongoing";
								}
								else if($ojt_status == "DNA" || $ojt_status_rd == "DNA")
								{
									$show="block";
									$show2="block";
									$status="DNA";
								}
								else
									{
										$show="block";
										$show2="block";
									}
							}
							if($program_id==1)
							{
								if($ojt_status == "DNA" || $ojt_status_rd == "DNA")
								{
									$show="block";
									$show2="block";
									$status="DNA";
								}
							}
								
								
								print '<div class="col-md-12 row" style="background-color:#0d47a1; padding-right:15px;padding-left:30px;"><h4 style="color:white;">OJT Records - '.$status.'</h4></div>
								<div class="col-md-12" style="padding:20px;">
                          <div class="row">
                           <div class="col-md-3">
                              <h5>ENROLLED STATUS</h5>
                                <div class="form-group">
                                  <h4>'.$enrollment_status_rd.'</h4>
                                </div>
                           </div>
						   
						   <div class="col-md-3">
                              <h5>OJT STATUS</h5>
                                <div class="form-group">
                                  <h4>'.$ojt_status_rd.'</h4>
                                </div>
                           </div>
						   
						   <div class="col-md-3">
                            <h5>ACADEMIC YEAR START</h5>
                                <div class="form-group">
                                  <h4>'.$acad_year_start_rd.'</h4>
                                </div>
						  </div>
						<div class="col-md-3">
                            <h5>ACADEMIC YEAR END</h5>
                                <div class="form-group">
                                  <h4>'.$acad_year_end_rd.'</h4>
                                </div>
						  </div>	
						
						<div class="col-md-3">
                            <h5>SECTION</h5>
                                <div class="form-group">
                                  <h4>'.$section_rd.'</h4>
                                </div>
                           </div>
						
						<div style="display:'.$show2.'">
						<div class="col-md-3">
                            <h5>OJT CATEGORY</h5>
                               <div class="form-group">
                                 <h4>'.$category_description.'</h4>
                               </div>
						</div>
						   
						<div class="col-md-3">
                            <h5>YEAR LEVEL</h5>
                               <div class="form-group">
                                 <h4>'.$year_level_rd.'</h4>
								 <input type="hidden" name="yearlvl" value="'.$year_level_rd.'"/>
                               </div>
                        </div>
						
                           <div class="col-md-3">
                             <h5>SEMESTER</h5>
                                <div class="form-group">
                                  <h4>'.$semester_rd.'</h4>
								  <input type="hidden" name="smstr" value="'.$semester_rd.'"/>
                                </div>
                           </div>
                           
						</div>
                           	
							
						  </div>
						  
                       </div>';
                      }
						?>  
						<div class="panel-body" style="padding-bottom:30px;">
                        <div class="row" style="display:<?php echo $show; ?>">
                        <div class="col-md-12 row" style="background-color:#0d47a1; padding-right:15px;padding-left:30px;"><h4 style="color:white;">Register</h4></div>
						<div class="col-md-12">
						<div class="form-group has-feedback">	
						<br>
							<?php
							if(isset($_GET['error'])) 
                            {  
                            print '<div class="col-md-6">
                              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                     <span class="fa fa-remove"></span> &nbsp; | &nbsp;
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <strong>&nbsp;Invalid data. Please check your year level and semester</strong>
                               </div></div>';
                            }
                            ?>
							<div class="col-md-12"><div/>
                           <div class="col-md-3">
                              <h5 >ENROLLED STATUS</h5>
                              <div class="form-group has-feedback">
                                <h4>Not Enrolled</h4>
                                <input type="hidden" name="enrollment_status" value="Not Enrolled"/>
                              </div>
                            </div>
                             <div class="col-md-3">
                                <h5 style="padding-left:5px;">OJT STATUS</h5>
                                   <input type="hidden" name="ojt_status" value="Ongoing"/>
								   <h4 style="padding-left:5px;">Ongoing</h4>
                             </div>
                            <?php
								$query_act="SELECT * FROM active_semester_acad_year";
								$result_act=mysqli_query($dbc, $query_act);
								if(mysqli_num_rows($result_act)>0)
								{
									$row_act = mysqli_fetch_assoc($result_act);
									$semester_act = $row_act['active_semester'];
									$acad_year_start_act = $row_act['active_acad_year_start'];
									$acad_year_end_act = $row_act['active_acad_year_end'];
								}
							?>
							<?php
								$query_act="SELECT * FROM active_semester_acad_year where status='Active'";
								$result_act=mysqli_query($dbc, $query_act);
								if(mysqli_num_rows($result_act)>0)
								{
									$row_act = mysqli_fetch_assoc($result_act);
									$semester_act = $row_act['active_semester'];
									$acad_year_start_act = $row_act['active_acad_year_start'];
									$acad_year_end_act = $row_act['active_acad_year_end'];
								}
								
								$query_ongoing="SELECT * FROM active_semester_acad_year where status='Ongoing'";
								$result_ongoing=mysqli_query($dbc, $query_ongoing);
								if(mysqli_num_rows($result_act)>0)
								{
									$row_ongoing = mysqli_fetch_assoc($result_ongoing);
									$semester_ongoing = $row_ongoing['active_semester'];
									$acad_year_start_ongoing = $row_ongoing['active_acad_year_start'];
									$acad_year_end_ongoing = $row_ongoing['active_acad_year_end'];
								}
							?>
							<div class="col-md-3">
                              <h5 style="padding-left:5px;">SEMESTER / AY&nbsp;<label style="color:red;font-size:20px;">*</label></h5>
                              <div class="form-group has-feedback">
                                  
								   
								   <select name="semester_ay">
										<option value="<?php echo $semester_act.'|'.$acad_year_start_act; ?>" ><?php echo $semester_act.' '.$acad_year_start_act.' - '.$acad_year_end_act; ?></option>
										<option value="<?php echo $semester_ongoing.'|'.$acad_year_start_ongoing; ?>" ><?php echo $semester_ongoing.' '.$acad_year_start_ongoing.' - '.$acad_year_end_ongoing; ?></option>
									</select>
                              </div>
                            </div>
                        </div>  
						</div>
						
					<?php 
							
					  print '<div class="col-md-10">
							<div class="row-0">
                            <div class="col-md-4">
                             <h5 style="padding-left:5px;">OJT CATEGORY</h5>
                              <div class="form-group has-feedback">';
							  
                              
							  $query_ojt_category = "SELECT program_id,category_id,category_description,ojt_hours FROM program_category_list WHERE program_id ='$program_id' AND category_id != '$category_id' AND status='Active'";
							  
                              $result_ojt_category = mysqli_query($dbc, $query_ojt_category);
                              $num_rows2 = mysqli_num_rows($result_ojt_category);
							  $comstart_cate = " ";
							  $comend_cate =" ";
							 if($ojt_status=="DNA")
							 {
								$comstart_cate = "<!--";
								$comend_cate ="-->";
								print '<h4>'.$category_description.'</h4>
								<input type="hidden" name="category_id" value="'.$category_id.'">';
							 }
									
                              print''.$comstart_cate.'<select class="form-control"  name="category_id" class="form-control">';
                              
                               while($row_pl = mysqli_fetch_array($result_ojt_category)){
                                  
                                  $program_id_new = $row_pl[0];
                                  $category_id_new = $row_pl[1];
                                  $category_description= $row_pl[2];
	
                                    echo "<option value='".$category_id_new."'>".$category_description."</option>";    
                              }
                              //----------yearlevel----------//
								$comstart1="";
								$comstart2="";
								$comstart3="";
								$comstart4="";
								$comstart5="";
								$comend1="";
								$comend2="";
								$comend3="";
								$comend4="";
								$comend5="";
							
							//---------semester----------//
								$comstartS1="";
								$comstartS2="";
								$comstartS3="";
								$comendS1="";
								$comendS2="";
								$comendS3="";
								
									if($program_id == 1)
									{
										$comstart1="<!--";
										$comstart2="<!--";
										$comstart3="<!--";
										$comstart5="<!--";
										$comend1="-->";
										$comend2="-->";
										$comend3="-->";
										$comend5="-->";
									}
									if($program_id_new == 2 || $program_id_new == 3 || $program_id_new == 4)
									{
										if($semester_rd == "1st Semester")
										{
											
											if($year_level_rd == "1st Year")
											{
												$comstart5="<!--";
												$comend5="-->";
											}
											else if($year_level_rd == "2nd Year")
											{
												$comstart1="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend5="-->";
												
											}
											else if($year_level_rd == "3rd Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend5="-->";
											}
											else if($year_level_rd == "4th Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart3="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend3="-->";
												$comend5="-->";
											}
											
										}
										else if($semester_rd == "2nd Semester")
										{	
											if($year_level_rd == "1st Year")
											{
												$comstart1="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend5="-->";
											}
											else if($year_level_rd == "2nd Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend5="-->";
											}
											else if($year_level_rd == "3rd Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart3="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend3="-->";
												$comend5="-->";
											}
											else if($year_level_rd == "4th Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart3="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend3="-->";
												$comend5="-->";
											}
										}
									}
									else if($program_id_new == 3)
									{
										if($semester_rd == "1st Semester")
										{
											if($year_level_rd == "1st Year")
											{
												$comstart5="<!--";
												$comend5="-->";
											}
											else if($year_level_rd == "2nd Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend5="-->";
											}
											else if($year_level_rd == "3rd Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend5="-->";
											}
											else if($year_level_rd == "4th Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart3="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend3="-->";
												$comend5="-->";
											}
											
										}
										else if($semester_rd == "2nd Semester")
										{	
											if($year_level_rd == "1st Year")
											{
												$comstart1="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend5="-->";
											}
											else if($year_level_rd == "2nd Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend5="-->";
											}
											else if($year_level_rd == "3rd Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart3="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend3="-->";
												$comend5="-->";
											}
											else if($year_level_rd == "4th Year")
											{
												$comstart1="<!--";
												$comstart2="<!--";
												$comstart3="<!--";
												$comstart5="<!--";
												$comend1="-->";
												$comend2="-->";
												$comend3="-->";
												$comend5="-->";
											}
										}
									}
									
                              print '</select>'.$comend_cate.'
                            </div>
                          </div>
                            <div class="col-md-3">
                              <h5 style="padding-left:5px;">YEAR LEVEL</h5>
                              <div class="form-group has-feedback">';
							  	if($ojt_status=="DNA")
								 {
									$comstart_cate2 = "<!--";
									$comend_cate2 ="-->";
									print '<h4>'.$year_level_rd.'</h4>
									<input type="hidden" name="year_level" value="'.$year_level_rd.'">';
								 }
								 else{
                               print '<select class="form-control" name="year_level" id="year_level" class="form-control" placeholder="Year Level">
                                    
                                    '.$comstart1.'<option value="1st Year">1st Year</option>'.$comend1.'
                                    '.$comstart2.'<option value="2nd Year">2nd year</option>'.$comend2.'
                                    '.$comstart3.'<option value="3rd Year">3rd year</option>'.$comend3.'
                                    '.$comstart4.'<option value="4th Year">4th year</option>'.$comend4.'
                                    '.$comstart5.'<option value="5th Year">5th year</option>'.$comend5.'
                                    </select>';
									}
									
								
                              print '</div>
                            </div>
                            <div class="col-md-3">
                          </div>
                        </div>
						</div>';
						?>
						
						<div class="row">
                            <div class="col-md-8"></div>                        
                            <div class="col-md-4">
                                 <button type="submit" class="btn btn-warning" style="margin-left:100px;"  name="btn_ojt_records_update" id="btn_ojt_records_update">
                                  <span class="icons icon-action-redo"></span> &nbsp; REGISTER
                                 </button>
                             </div>
                          </div>
						</div>
                      </div><!--ENd of panel body-->
                      </form>
                      </div>
                     </div>
                </div>
            </div> <!-- end: content -->
      </div>
      
<!-- start: Javascript -->
<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/jquery.ui.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>
<!-- plugins -->
<script src="asset/js/plugins/moment.min.js"></script>
<script src="asset/js/plugins/jquery.datatables.min.js"></script>
<script src="asset/js/plugins/datatables.bootstrap.min.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>
<script src="asset/js/plugins/jquery.knob.js"></script>
<script src="asset/js/plugins/ion.rangeSlider.min.js"></script>
<script src="asset/js/plugins/bootstrap-material-datetimepicker.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>
<script src="asset/js/plugins/jquery.mask.min.js"></script>
<script src="asset/js/plugins/select2.full.min.js"></script>
<script src="asset/js/plugins/nouislider.min.js"></script>
<script src="asset/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="asset/js/moment.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="asset/js/bootstrap-notify.min.js"></script>
<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="text/javascript">
function get_value_ays(){
var selected_acad_year_start = document.getElementById("acad_year_start").value;
var x = 1;
var acad_year_end = parseInt(selected_acad_year_start) + parseInt(x);
 document.getElementById("acad_year_start_show").innerHTML =  acad_year_end;
 document.getElementById("acad_year_end_value").value =  acad_year_end;
 }
$(document).ready(function(){
$('#acad_year_start')
        .datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoClose: true
        }).on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'acad_year_start');
        });
		
  $('#datatables').DataTable();
   $('#bday')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoClose: true
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#defaultForm').bootstrapValidator('revalidateField', 'bday');
        });
   $('#defaultForm')
        .bootstrapValidator({
            message: 'Value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid:'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
        fields: {
        email: {
                    validators: {
                        notEmpty: {
                            message: 'Email is required and can\'t be empty'
                        },
            emailAddress: {
                            message: 'Invalid email address'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    }
                },
        address: {
                    validators: {
                        notEmpty: {
                            message: 'Address is required and can\'t be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    }
                },
        mobile_no: {
                    validators: {
                        notEmpty: {
                            message: 'Mobile number is required and can\'t be empty'
                        },
            regexp: {
                            regexp: /[0-9]+$/,
                            message: 'Mobile number can only consist of numbers'
                        },
            stringLength: {
                            min: 11,
                            max: 11,
                            message: 'Mobile number must be 11 numbers'
                        }
                    }
                },
            tel_no: {
                    validators: {
                      regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Telephone number can only consist of numbers'
                                  },
                      stringLength: {
                                      min: 7,
                                      max: 7,
                                      message: 'Telephone number must be 7 numbers'
                                  },
                              }
                          },
            facebook: {
                    validators: {
                        regexp: {
                            regexp: /^[a-zA-Z \-=.!@#$%^&*()_+{}|<>:,/? 0-9]+$/,
                            message: 'Invalid character'
                        }
                    },
                },
                image: {
                  validators: {
                     file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 1049088,   // 1366 * 768
                        message: 'The selected file is not valid,it should be (jpeg,jpg,png) and 1 MB at maximum size'
                      }
                    }
                },
                year_level: {
                    validators: {
                        notEmpty: {
                            message: 'Year level is required and can\'t be empty'
                        },
                    }
                },
                  category_id: {
                    validators: {
                        notEmpty: {
                            message: 'Section is required and can\'t be empty'
                        },
                    }
                },
				 acad_year_start: {
                    validators: {
                        notEmpty: {
                            message: 'Academic year start is required and can\'t be empty'
                        },
                        
                         regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Invalid characters'
                        },
                        callback: {
                        message: 'The date is not in the range',
                        callback: function(value, validator) {
                            var m = new moment(value, 'YYYY', true);
                            var cy = document.getElementById("current_year").value;
                             var ny = document.getElementById("next_year").value;
                            if (!m.isValid()) {
                                return false;
                            }
                            return m.isAfter(cy) && m.isBefore(ny);
                        }
                       },
                    }
                }
            }
          
        });
   
     
  });
</script>
<!-- end: Javascript -->
</body>
</html>