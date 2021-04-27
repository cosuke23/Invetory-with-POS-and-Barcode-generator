<?php 
include '../db.php';
session_start();  

			$id=$_SESSION['id'];
if(isset($_POST['subpic'])){
	

	 move_uploaded_file($_FILES['ppic']['tmp_name'],"images/".$_FILES['ppic']['name']);
              
	 //	    mysqli_query($conn,"UPDATE admin SET img = '".$_FILES['ppic']['name']."' WHERE id='".$id."'")or die(mysqli_error());
			
			
}
//mysqli_close();
?>






<style type="text/css">
<!--
div#contact { 
position:fixed;
top:200px;
right:0; 

 }
.contimage{
filter: alpha(opacity=80);-moz-opacity:.80;opacity:.80;
}
h1{
color:#fff;
margin:0 0 30px 0;
font-size:36px;
font-family:"Times New Roman", Times, serif;
font-style:italic;
}
 /*  Contact Form Styling */
 #contactform #error ul{
 padding-left:0px;
 line-height:20px;
 }
 #contactform #error span{
 color:green;
 padding:5px 0 5px 0;
 position:absolute;
 top:60px;
 right:10px;
 width:150px;
 }
 #contactform #error ul li{
  color:#BF0B0B;
  font-weight:normal;
  }
 h2#contacth2{
 font-size:18px;
 color:#000;
 margin:0 0 10px 0;
 font-weight:normal;
 padding-bottom:10px;
 border-bottom:1px dotted #ccc;
 }
 #contactform fieldset{
 border:none;
 }
 #contactform #formleft{
 float:left;
 }
 #contactform #error{
 float:right;
 }
 #contactform .button{
	  margin-left:80px;
 background:#eded;
 color:#666;
 border:1px solid #ccc;
 padding:5px 20px 5px 20px;
 outline:none;
 }
 #contactform{
 color:#666;
 margin-left:50px;

 }
.clear{clear:both;}
.download{
display:block;
padding:20px 0 20px 0;
background:#222;
text-align:center;
border:1px solid #000;
color:#fd398f;
font-size:18px;
}
.download:hover{
background:#000;
}
#error{
color:#fd398f;
}
#contactform input[type="text"]
{
    width:250px;
	height:30px;
	font-size:15px;

}
#contactform input[type="number"]
{
    width:250px;
	height:30px;
	font-size:15px;

}

#contactform select
{
    width:250px;
	height:30px;
	font-size:15px;

}
-->
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>JQuery Ajax Contact Form</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
	$(document).ready(function() {
		$('#submitform').ajaxForm({
			target: '#error',
			success: function() {
			$('#error').fadeIn('slow');
			}
		});
	});

</script>
</head>
<body>
<div id="contactform">
<div id="formleft">

<form id="submitform" action="addnew.php" method="post" enctype="multipart/form-data" name="submitform" >
<input name="id" type="hidden" class="ed" id="brnu" value="" />
<input name="type" type="hidden" class="ed" id="brnu" value="<?php echo $_GET['type']; ?>" />
<input name="types" type="hidden" class="ed" id="brnu" value="<?php echo $_GET['types']; ?>" />
<h3><b>Add New Product</b></h3>
<input type="file" name="ppic"><br>
Upload Product Images

Product Name <br />
<input name="name" type="text" class="ed" id="name"  /><span class="required"><font color="#CC0000" size="2px">* </font></span>
<br>
Product Quantity <br />
<input name="Prod_quantity" type="number" class="ed" id="Prod_quantity" pattern="[A-Za-z\s]{2,}"  required/><span class="required"><font color="#CC0000" size="2px">* </font></span>
<br>
Product Price <br />
<input name="Prod_price" type="number" class="ed" id="Middle_Name" pattern="[A-Za-z\.s]{1,}"  required/><span class="required"><font color="#CC0000" size="2px">*</font></span>
<br>
Flavor</br>
 <?php
    //current URL of the Page. cart_update.php redirects back to this URL
    $flavor=$_GET['flavor'];
     if($flavor=="Matcha"){
     	?>

<select name="flavor">
<option>Redvelvet</option>
<option>Matcha</option>
<option>Taro</option>
<option>Winter Melon</option>	
</select>
<?php
}else{
	?>
<select name="flavor">
<option>Bubble</option>
<option>Taro</option>
<option>Green</option>
<option>British</option>	
</select>

<?php
}

	?>
<input type="submit" name="doRegister" class="button" value="save" id="doRegister" />
</form>
    </div>
	<div id="error">

	</div>
<div class="clear"></div>
</div>
</body>
</html>