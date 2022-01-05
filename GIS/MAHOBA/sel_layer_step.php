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

$category_name = $_GET['cat_name'];

$array_cat=explode("_",$category_name);
if(count($array_cat)>3)
{
	$comp_name=$array_cat[0];
$subcomp_name=$array_cat[1];
$ws_name=$array_cat[2];
$cat_name=$array_cat[3];

}


if($category_name!="")
{
	//$road_name = 'N5';
?>



<select name="layer" id="layer"  style="width:200px" >
<option value=""><?php echo ALL_LAYERS;?></option>
<?php
	if(count($array_cat)>2)
	{
		if($cat_name!="0")	
			{
$tquery1 = "select distinct layer from  dgps_survey_data where component_name='$comp_name' and sub_component_name='$subcomp_name' and ws_name='$ws_name' and cat_name = '$cat_name'";
		}
		else if($cat_name=="0")	
			{
			$tquery1 = "select distinct layer from  dgps_survey_data where component_name='$comp_name' and sub_component_name='$subcomp_name' and ws_name='$ws_name'";
		}
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



