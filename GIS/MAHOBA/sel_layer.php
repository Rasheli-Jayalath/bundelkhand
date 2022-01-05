<?php
include("top.php");
if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}
?>

<?php 

$ws_name = $_GET['ws_name'];
$array_ws=explode("_",$ws_name);
$comp_name=$array_ws[0];
$subcomp_name=$array_ws[1];
$wss_name=$array_ws[2];

if($ws_name!="")
{
	//$road_name = 'N5';
?>



<select name="layer" id="layer"  style="width:200px" >
<option value=""><?php echo ALL_LAYERS;?></option>
<?php
 $tquery1 = "select distinct layer from  dgps_survey_data where component_name='$comp_name' and sub_component_name='$subcomp_name' and ws_name = '$wss_name'";
$tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$layer=$tdata['layer'];


?>
<option value="<?php echo $tdata['layer']; ?>"><?php echo $tdata['layer']; ?></option>
<?php

}
?>
</select>

<?php
}

?>



