<?php
include("top.php");
?><?php 

if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}
?>

<?php 

$channel_id = $_GET['channel_id'];
if($channel_id!="")
{
	//$road_name = 'N5';
?>



<select name="layer" id="layer"  style="width:200px" >
<option value="0">All Chainages</option>
<?php
echo $tquery1 = "select distinct chainage_id from dgps_survey_data where component_name='$componentName' and channel_id = '$channel_id'";
echo $tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$sub_component_name=$tdata['chainage_id'];


?>
<option value="<?php echo $tdata['chainage_id']; ?>"><?php echo $tdata['chainage_id']; ?></option>
<?php

}
?>
</select>

<?php
}

?>



