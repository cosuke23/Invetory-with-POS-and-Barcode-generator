<?php 
include ('../db.php');


?>
<?php 
session_start();  
?>

<?php 

$errors="";
$success="";			
if(isset($_POST['doRegister'] )== 'Register') {
$type = $_POST['type'];
$img = $_POST['ppic'];
$pname = $_POST['name'];
$qty = $_POST['Prod_quantity'];
$price = $_POST['Prod_price'];
$types = $_POST['types'];
$flavor = $_POST['flavor'];
$approved=1;
	 move_uploaded_file($_FILES['ppic']['tmp_name'],"../assets/img/slider/milk_tea/".$_FILES['ppic']['name']);


$sql=mysqli_query($conn,"SELECT * from $type WHERE name='$pname' ");
	  $count= mysqli_num_rows($sql);
	  if($count>0){	
	  	
	   $errors.= 'Product is already Exist!';
	  }else{
	mysqli_query($conn,"INSERT into $type(tea_id,img,name,price,qty,product_size,status,flavor)VALUES
		    ('','".$_FILES['ppic']['name']."','$pname','$qty'
			,'$price','L','Active','$flavor')");
			  




$url="product.php";
$success.="SUCCESS- Product Added Successfully.";
?>

<script type="text/javascript">
window.alert("succes");
	   window.location.href = 'tables.php?flavor=<?php echo "Matcha"?>';
</script>
<?php




	 
	 
	 }
}

?>

<div id='emailerror'>
	<ul>
		<?php echo $errors; ?>
		<div style="color:green"><?php echo $success; ?></div>
	</ul>
</div>