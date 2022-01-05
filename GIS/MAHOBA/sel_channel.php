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
	
?>



<select name="channel_id" id="channel_id"  style="width:200px" onchange="getLayers(this.value)">
<option value="<?php echo $ws_name."_0" ?>"><?php echo ALL_CHANNELS;?></option>
<?php
$tquery1 = "select distinct channel_id from  dgps_survey_data where component_name='$comp_name' and sub_component_name='$subcomp_name' and ws_name = '$wss_name'";
$tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$channel_id=$tdata['channel_id'];


?>
<option value="<?php echo $ws_name."_".$tdata['channel_id']; ?>"><?php echo $tdata['channel_id']; ?></option>
<?php

}
?>
</select>

<?php
}

?>



