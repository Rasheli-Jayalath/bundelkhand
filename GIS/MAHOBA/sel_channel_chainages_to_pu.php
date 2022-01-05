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



<?php echo TO_CHAINAGE?>:

<select name="to_kmpost_pu" id="to_kmpost_pu"    <?php if($_SESSION['lang']=="rus")	{?>    style="margin-left: 45px;"    <?php } else {	 ?>	  style="margin-left: 22px;"	<?php }	?>>
<option value="0"><?php echo SELECT_CHAINAGE?></option>
<?php
echo $tquery1 = "select distinct chainage_id from dgps_survey_data where component_name='$componentName' and channel_id = '$channel_id' order by chainage_id ASC";
 $tresult1 = mysql_query($tquery1);

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



