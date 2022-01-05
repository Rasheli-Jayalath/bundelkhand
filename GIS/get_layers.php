<?php 
require_once("config/config.php");
$objCommon 		= new Common;
$objMenu 		= new Menu;
$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objProduct 	= new Product;
$objValidate 	= new Validate;
$objOrder 		= new Order;
$objLog 		= new Log;
require_once('rs_lang.admin.php');
//require_once('rs_lang.website.php');
?><?php 
$defaultLang='en'; 
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.eng.php');

}
else
{
	require_once('rs_lang.rus.php');

}
if($objAdminUser->is_login== false){
	header("location: index.php");
}
?>

<?php 

$component_name = $_GET['component_name'];
if($component_name!="")
{
	//$road_name = 'N5';
?>



<select name="layer_name" id="layer_name"  style="width:200px">
<option value="0">--<?php echo SELECT?>---</option>
<?php
echo $tquery1 = "select distinct layer from  dgps_survey_data where component_name = '$component_name'";
$tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$layer=$tdata['layer'];


?>
<option value="<?php echo $layer ?>"><?php echo $tdata['layer']; ?></option>
<?php

}
?>
</select>

<?php
}

?>



