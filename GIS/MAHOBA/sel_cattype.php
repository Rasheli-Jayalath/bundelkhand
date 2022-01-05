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
//$sub_component_name = $_GET['sub_component_name'];
$ws_name = $_GET['ws_name'];
$array_ws=explode("_",$ws_name);
$comp_name=$array_ws[0];
$subcomp_name=$array_ws[1];
$wss_name=$array_ws[2];
if($ws_name!="")
{
	//$road_name = 'N5';
?>



<select name="cat_name" id="cat_name"  style="width:200px" onchange="getChannels(this.value)">
<option value="<?php echo $ws_name."_0" ?>"><?php echo ALL_CAT_TYPES;?></option>
<?php


if($wss_name!="0")	
			{
echo $tquery1 = "select distinct cat_name from  dgps_survey_data where component_name='$comp_name' and  sub_component_name='$subcomp_name' and ws_name = '$wss_name'";
	}
	/*else if($wss_name=="0")	
	{
	echo $tquery1 = "select distinct channel_id from  dgps_survey_data where sub_component_name='$subcomp_name'";	
	}*/

$tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$cat_name=$tdata['cat_name'];


?>
<option value="<?php echo $ws_name."_".$tdata['cat_name']; ?>"><?php echo $tdata['cat_name']; ?></option>
<?php

}
?>
</select>

<?php
}

?>



