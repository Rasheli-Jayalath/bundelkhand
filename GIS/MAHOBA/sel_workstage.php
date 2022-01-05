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

$sub_component_name = $_GET['sub_component_name'];
$array_subcomp=explode("_",$sub_component_name);
$comp_name=$array_subcomp[0];
$subcomp_name=$array_subcomp[1];
$wss_name=$array_ws[1];
if($sub_component_name!="")
{
	//$road_name = 'N5';
?>



<select name="ws_name" id="ws_name"  style="width:200px" onchange="getCattype(this.value)">
<option value="<?php echo $sub_component_name; ?>_0"><?php echo ALL_WSS;?></option>
<?php
$tquery1 = "select distinct ws_name from  dgps_survey_data where component_name='$comp_name' and sub_component_name = '$subcomp_name'";
$tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$ws_name=$tdata['ws_name'];


?>
<option value="<?php echo $sub_component_name."_".$tdata['ws_name']; ?>"><?php echo $tdata['ws_name']; ?></option>
<?php

}
?>
</select>

<?php
}

?>



