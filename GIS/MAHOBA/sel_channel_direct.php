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

$cat_name = $_GET['cat_name'];
$array_cat=explode("_",$cat_name);
$comp_name=$array_cat[0];
$subcomp_name=$array_cat[1];
$ws_name=$array_cat[2];
$catt_name=$array_cat[3];
if($cat_name!="")
{
	
?>



<select name="channel_id" id="channel_id"  style="width:200px" onchange="getLayers(this.value)">
<option value="<?php echo $cat_name."_0";?>"><?php echo ALL_CHANNELS;?></option>
<?php
	if($catt_name!="0")	
			{
 $tquery1 = "select distinct channel_id from  dgps_survey_data where component_name='$comp_name' and sub_component_name='$subcomp_name' and ws_name='$ws_name' and cat_name = '$catt_name'";
	}
	else if($catt_name=="0")	
	{
 	$tquery1 = "select distinct channel_id from  dgps_survey_data where component_name='$comp_name' and sub_component_name='$subcomp_name' and ws_name='$ws_name'";	
	}
$tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$channel_id=$tdata['channel_id'];


?>
<option value="<?php echo $cat_name."_".$tdata['channel_id']; ?>"><?php echo $tdata['channel_id']; ?></option>
<?php

}
?>
</select>

<?php
}

?>



