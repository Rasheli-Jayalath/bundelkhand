<?php
include("top.php");

//require_once('rs_lang.website.php');
?><?php 

if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}
?>





<?php 

$item_date = $_GET['item_date'];
$unique_id = $_GET['oid'];
	//$road_name = 'N5';
?>


    <?php 
	$query4 = "SELECT * FROM attributes_gallery where component_name='$componentName' and oid = '$unique_id' and item_type=1 and item_date='$item_date'";
	//echo $query4;
	 $result4=mysql_query($query4);
	 mysql_num_rows($result4);
 if (mysql_num_rows($result4) > 0) {
while($row4 = mysql_fetch_assoc($result4))
{
		$image_name_eng=$row4['image_name_eng'];
	$image_name_rus=$row4['image_name_rus'];
		if($row4['item_type']=="1")
		{
			$extension = explode(".", $row4['item_name']);
		$extension[1];
		if($extension[1] == "jpg" || $extension[1] == "JPG" || $extension[1] == "png")
		{
		

	 
		?>
        				<div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:250px;margin-right:0px;">
        <a class="image-popup-vertical-fit"  href="<?php echo SITE_URL; ?>idip_photos/<?php echo $row4['item_name']; ?>" title="<?php if($image_name_eng=="" && $image_name_rus=="")
{
	echo $row4['item_name'];
}
else
{
	if($_SESSION["lang"]=='en')
	{
		 echo $row4['image_name_eng'];
	}
	else 
	{
		 echo $row4['image_name_rus'];
	}
} ?>">
	<img src="<?php echo SITE_URL; ?>idip_photos/<?php echo $row4['item_name']; ?>"  width="250" height="180px"/>
</a>&nbsp;

</div>
	</li>
	</div>

    <?php
		
	}
	
		}
}
 }
			$query41 = "SELECT * FROM attributes_gallery where component_name='$componentName' and oid = '$unique_id' and item_type=3 and item_date='$item_date'";
	//echo $query4;
	 $result41=mysql_query($query41);
	 mysql_num_rows($result41);
 if (mysql_num_rows($result41) > 0) {
while($row41 = mysql_fetch_assoc($result41))
{
		if($row41['item_type']=="3")
		{
			$extension = explode(".", $row41['item_name']);
		$extension[1];
		if($extension[1] == "mp4")
		{
		

	 
		?>
        				 <div class="video" >
        <video width="500" height="340" controls>
 <source src="<?php echo SITE_URL; ?>videos/<?php echo $row41['item_name']; ?>" type="video/mp4">
  Sorry, your browser doesn't support the video element.
</video>
</div>

    <?php
		
	}
	
		}
}
 }
	
	
 
 /*else
 {
	 	?>
        <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:210px;margin-right:0px;">
        
	<img style="width:; height:" src="images/no_image_1.jpg" width="200" height="180px" />

</div>
	</li>
	</div>
        
<?php
	 
	 }*/
	?>

