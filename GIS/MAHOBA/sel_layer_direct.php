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

$channel_id = $_GET['channel_id'];

$array_chanl=explode("_",$channel_id);
if(count($array_chanl)>4)
{
	$comp_name=$array_chanl[0];
$subcomp_name=$array_chanl[1];
$ws_name=$array_chanl[2];
$cat_name=$array_chanl[3];
$channel_idd=$array_chanl[4];
	
}
else if(count($array_chanl)==4)
{
	$comp_name=$array_chanl[0];
$subcomp_name=$array_chanl[1];
$ws_name=$array_chanl[2];
$cat_name="";
$channel_idd=$array_chanl[3];
}

if($channel_id!="")
{
	//$road_name = 'N5';
?>



<select name="layer" id="layer"  style="width:200px" >
<option value=""><?php echo ALL_LAYERS;?></option>
<?php
	if(count($array_chanl)>4)
	{
			if($channel_idd!="0")	
			{
				//echo "if";
		$tquery1 = "select distinct layer from  dgps_survey_data where component_name='$comp_name' and sub_component_name='$subcomp_name' and ws_name='$ws_name' and cat_name = '$cat_name' and channel_id = '$channel_idd'";
			}
		else if($channel_idd=="0")
		{
			
		$tquery1 = "select distinct layer from  dgps_survey_data where sub_component_name='$subcomp_name' and ws_name='$ws_name' and cat_name = '$cat_name'";	
		}
	}
	else if(count($array_chanl)==4)
	{
	$tquery1 = "select distinct layer from  dgps_survey_data where sub_component_name='$subcomp_name' and ws_name='$ws_name'  and channel_id = '$channel_idd'";
	}
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



