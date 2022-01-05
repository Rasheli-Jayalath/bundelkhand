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

$component_name = $_GET['component_name'];
if($component_name!="")
{
	//$road_name = 'N5';
?>



<select name="sub_component_name" id="sub_component_name"  style="width:200px" onchange="getWorkstage(this.value)">
<option value="<?php echo $component_name; ?>_0"><?php echo ALL_SUBCOMP;?></option>
<?php
echo $tquery1 = "select distinct sub_component_name from  dgps_survey_data where component_name = '$component_name'";
$tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$sub_component_name=$tdata['sub_component_name'];


?>
<option value="<?php echo $component_name."_".$tdata['sub_component_name']; ?>"><?php echo $tdata['sub_component_name']; ?></option>
<?php

}
?>
</select>

<?php
}

?>



