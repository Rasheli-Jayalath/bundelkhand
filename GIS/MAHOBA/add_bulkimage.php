<?php 
include("top.php");
if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}

$channel_id=$_REQUEST['channel_id'];
$from_kmpost=$_REQUEST['from_kmpost'];
$to_kmpost=$_REQUEST['to_kmpost'];
$detail=$_REQUEST['detail'];

$query = "SELECT code,latitude,longitude,layer,oid,label from dgps_survey_data where component_name='$componentName' and channel_id='".$channel_id."' and chainage_id BETWEEN ".$from_kmpost. " AND ".$to_kmpost.' and code="'.$detail.'"';



 if(isset($_REQUEST['unique_id']))
  {
	   $unique_id=$_REQUEST['unique_id'];
  }
  
/*  
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST['Cancel']))
{
	redirect('detail_link.php?unique_id='.$unique_id);
} */


	 $SQLbf = "Select * from dgps_survey_data where oid='$unique_id' and component_name='$componentName'";
	//echo $SQLbf;
	$reportresultbf= mysql_query($SQLbf);
	$reportdatabf = mysql_fetch_array($reportresultbf);
	$latbf = $reportdatabf['dgps_lat'];  
   $lngbf = $reportdatabf['dgps_long'];   
   
function getExtention($type){
	if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
		return "jpg";
	elseif($type == "image/png")
		return "png";
	elseif($type == "image/gif")
		return "gif";
	elseif($type == "image/mp4")
		return "mp4";
	elseif($type == "image/jpeg")
		return "jpeg";
}
$editflag = 0;
if(isset($_REQUEST['attrib_gallery_id']))
{
	
$attrib_gallery_id=$_REQUEST['attrib_gallery_id'];
$pdSQL1="select * from attributes_gallery where attrib_gallery_id = ".$attrib_gallery_id. " and component_name='$componentName'";
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);
$oid=$pdData1['oid'];
$al_file=$pdData1['item_name'];
	$dwg_title=$pdData1['image_type'];
	$dwg_date=$pdData1['item_date'];
	$dwg_status=$pdData1['item_type'];
	$image_name_eng=$pdData1['image_name_eng'];
	$image_name_rus=$pdData1['image_name_rus'];	
	$editflag = 1;
	
}


if(isset($_GET['mode']) && $_GET['mode'] == "delete"){
				$attrib_gallery_id = $_GET['attrib_gallery_id'];
				$pdSQL = "select * from attributes_gallery where attrib_gallery_id = ".$attrib_gallery_id. " and component_name='$componentName'";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
$attrib_gallery_id=$_REQUEST['attrib_gallery_id'];
$old_al_file= $pdData["item_name"];
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink("../idip_photos/" .$old_al_file);
			}
					
				}
					 $sdelete= "Delete from attributes_gallery where attrib_gallery_id=".$attrib_gallery_id. " and component_name='$componentName'";
	   mysql_query($sdelete);
	if ($sdelete == TRUE) {
    $message=  "Record deleted successfully";
	} else {
    $message= mysql_error($db);
	}
				
						redirect('add_bulkimage.php?channel_id='.$channel_id.'&from_kmpost='.$from_kmpost.'&to_kmpost='.$to_kmpost.'&detail='.$detail);
					}				

/*$size=50;
$max_size=($size * 1024 * 1024);*/
if(isset($_REQUEST['save']))
{ 
    //$dwg_no=$_REQUEST['dwg_no'];
	$dwg_title=($_REQUEST['dwg_title']);
	$dwg_date=$_REQUEST['dwg_date'];
	$dwg_status=$_REQUEST['dwg_status'];
	$image_name_eng1=$_REQUEST['image_name_eng'];
		
	$image_name_rus1=$_REQUEST['image_name_rus'];
	if($image_name_eng1!="" && $image_name_rus1!="")
	{
	$image_name_eng=$image_name_eng1;
		
	$image_name_rus=$image_name_rus1;
	}
	else if($image_name_eng1!="" && $image_name_rus1=="")
	{
	$image_name_eng=$image_name_eng1;
		
	$image_name_rus=$image_name_eng1;
	}
	else if($image_name_eng1=="" && $image_name_rus1!="")
	{
	$image_name_eng=$image_name_rus1;
		
	$image_name_rus=$image_name_rus1;
	}
		//echo $name_array = $_FILES['al_file']['name'];
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	$loadfile = basename($_FILES["al_file"]["name"]);
        $target = "../idip_photos/" . $load_file;	
	$file_name=$loadfile;
   
	if( 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$target_file=$file_path.$file_name;
        $target = "../idip_photos/" . $target_file;	
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target))
	{
	
	
	$query = "SELECT code,latitude,longitude,layer,oid,label from dgps_survey_data where component_name='$componentName' and channel_id='".$channel_id."' and chainage_id BETWEEN ".$from_kmpost. " AND ".$to_kmpost.' and code="'.$detail.'"';
//echo $query;
$result=mysql_query($query);

 if (mysql_num_rows($result) > 0) {
	 $m=0;
 while($row5 = mysql_fetch_assoc($result))
 { 
	$unique_id=$row5['oid'];
		
	$sql_query="insert into attributes_gallery (component_name,oid, item_type, item_name, item_date, image_type, image_name_eng, image_name_rus) values('".$componentName."',".$unique_id.",".$dwg_status.", '".$file_name."', '".$dwg_date."', '".$dwg_title."', '".$image_name_eng."', '".$image_name_rus."')";
	$sql_pro=mysql_query($sql_query);
	
 }
 }
	if ($sql_pro == TRUE) {
    $message=  "New records added successfully";
	} else {
    $message= mysql_error($db);
	}
	}
	}
	}
	$al_file='';
	$dwg_title='';
	$dwg_date='';
	$dwg_status='';
	$image_name_eng='';
		
	$image_name_rus='';
	//header("Location: add_image.php?unique_id=$unique_id");
	
}

if(isset($_REQUEST['update']))
{
	$dwg_title=$_REQUEST['dwg_title'];
	$dwg_date=$_REQUEST['dwg_date'];
	$dwg_status=$_REQUEST['dwg_status'];
	$image_name_eng1=$_REQUEST['image_name_eng'];		
	$image_name_rus1=$_REQUEST['image_name_rus'];
	if($image_name_eng1!="" && $image_name_rus1!="")
	{
	$image_name_eng=$image_name_eng1;
		
	$image_name_rus=$image_name_rus1;
	}
	else if($image_name_eng1!="" && $image_name_rus1=="")
	{
	$image_name_eng=$image_name_eng1;
		
	$image_name_rus=$image_name_eng1;
	}
	else if($image_name_eng1=="" && $image_name_rus1!="")
	{
	$image_name_eng=$image_name_rus1;
		
	$image_name_rus=$image_name_rus1;
	}
$pdSQL = "select * from attributes_gallery where attrib_gallery_id = ".$attrib_gallery_id. " and component_name='$componentName'";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
$attrib_gallery_id=$_REQUEST['attrib_gallery_id'];
$old_al_file= $pdData["item_name"];
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink("../idip_photos/" .$old_al_file);
			}
					
				}

	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	$loadfile = basename($_FILES["al_file"]["name"]);
        $target = "../idip_photos/" . $load_file;	
	 $file_name=$loadfile;
   
	if( 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$target_file=$file_path.$file_name;
        $target = "../idip_photos/" . $target_file;	
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target))
	{
			
    $sql_pro="UPDATE attributes_gallery set oid = '".$unique_id."', item_type = '".$dwg_status."', item_name = '".$file_name."', item_date = '".$dwg_date."',	image_type = '".$dwg_title."', image_name_eng = '".$image_name_eng."', image_name_rus = '".$image_name_rus."' where attrib_gallery_id=".$attrib_gallery_id. " and component_name='$componentName'";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}
	}
	}
	else
	{
	echo "Invalid File Format";
	}
	}
	else
	{
$sql_pro="UPDATE attributes_gallery set oid = '".$unique_id."', item_type = '".$dwg_status."', item_date = '".$dwg_date."',
    image_type = '".$dwg_title."', image_name_eng = '".$image_name_eng."', image_name_rus = '".$image_name_rus."' where attrib_gallery_id=".$attrib_gallery_id. " and component_name='$componentName'";	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}
	}
}

?>

<?php 
function dateDiff($start, $end) 
{   
$start_ts = strtotime($start);  
$end_ts = strtotime($end);  
$diff = $end_ts - $start_ts;  
return round($diff / 86400); 
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title><?php echo "Add Image"?></title>
<link rel="stylesheet" type="text/css" media="all" href="../datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="../datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="../datepickercode/jquery-ui.js"></script>
<link href="../css/CssAdminStyle.css" rel="stylesheet" type="text/css" />
<link href="../css/CssLogin2.css" rel="stylesheet" type="text/css" />
  
<script language="javascript" type="text/javascript">
function frmValidate(frm){
	
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if((frm.image_name_eng.value == "") && (frm.image_name_rus.value == "")){
		msg = msg + "\r\n<?php echo "Please add image name in atleast one field (english or russian)";?>";
		flag = false;
	}
	
	if(flag == false){
		alert(msg);
		return false;
	}
}
 </script>
 <script>
  $(function() {
	
    $( "#dwg_date" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
	
  });
   


</script>
<style>
#frm-image-upload{
    padding: 0px;
	margin-left:px;
    background-color: lightblue;
	text-align:center;
}

.form-row {
    padding: 20px;
    border-top: #8aacb7 1px solid;
}

.button-row {
    padding: 10px 20px;
    border-top: #8aacb7 1px solid;
}

#btn-submit {
    padding: 10px 40px;
    background: #586e75;
    border: #485c61 1px solid;
    color: #FFF;
    border-radius: 2px;
}

.file-input {
    background: #FFF;
    padding: 5px;
    margin-top: 5px;
    border-radius: 2px;
    border: #8aacb7 1px solid;
}

.response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
}

.error {
    background: #fdcdcd;
    border: #ecc0c1 1px solid;
}

.success {
    background: #c5f3c3;
    border: #bbe6ba 1px solid;
}
</style>
  </head>
  <body onload="init();">
<?php  include 'includes/headerMainHome.php'; 
?>


<style type="text/css">
<!--
.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
-->
</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 
<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	position: relative;
    display: inline-block;
	cursor:pointer;
   /* border-bottom: 1px dotted black;*/

}
.msg_head .tooltiptext {
	cursor:pointer;
    visibility: hidden;
    width: 80px;
    background-color: gray;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.msg_head:hover .tooltiptext {
    visibility: visible;
}
.msg_body{
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}

.new_div li {
    list-style: outside none none;
}

.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("./images/frame.png") no-repeat scroll 0 0;
    float: left;
    height: 90px;
    padding: 50px 0 0 6px;
    width: 152px;
	padding-left: 21px !important;
}
.imageTitle {
    color: #464646;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: normal;
}
.ms-WPBody a:link {
    color: #0072bc;
    text-decoration: none;
}
/*div a {
    color: #767676 !important;
    font-family: arial;
    font-size: 12px;
    line-height: 17px;
    text-decoration: none !important;
}*/
img {
    border: medium none;
}
#frm-image-upload{
    padding: 0px;
	margin-left:px;
    background-color: lightblue;
	text-align:center;
}

.form-row {
    padding: 20px;
    border-top: #8aacb7 1px solid;
}

.button-row {
    padding: 10px 20px;
    border-top: #8aacb7 1px solid;
}

#btn-submit {
    padding: 10px 40px;
    background: #586e75;
    border: #485c61 1px solid;
    color: #FFF;
    border-radius: 2px;
}

.file-input {
    background: #FFF;
    padding: 5px;
    margin-top: 5px;
    border-radius: 2px;
    border: #8aacb7 1px solid;
}

.response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
}

.error {
    background: #fdcdcd;
    border: #ecc0c1 1px solid;
}

.success {
    background: #c5f3c3;
    border: #bbe6ba 1px solid;
}

</style>


<script src="lightbox/js/lightbox.min.js"></script>
<div id="tableContainer">
<div style=" background-color:#046b99;border-radius: 10px; height:75px; margin-left:10px">
<h2 style="color:#FFF; font-size:26px; margin-top:4px; line-height:1.5em; letter-spacing:-1px; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif; margin: 5px 0px 15px 0px; clear: both;">
<?php
	  //$kmpost=$_REQUEST['kmpost'];
	
 echo CHANNEL.": ".$channel_id."&nbsp;&nbsp;&nbsp;";
 echo CHAINAGE.": ".$from_kmpost. " ".TO." ".$to_kmpost;
 echo "<br>";
	 $result=mysql_query($query);

 $row5 = mysql_fetch_assoc($result);
	$dgps_detail=$row5['layer'];
 
echo "Layer Name : ".$dgps_detail."&nbsp;&nbsp;&nbsp;";
 ?>
 </h2><?php
 

	?>
 </div> 
<table  align="center">
  <tr style="height:10%">
<?php if ($editflag == 1) { ?>
<div align="center" style="font-size:20px; background-color:#9BAFD5; width:432px; margin-top:20px; margin-left:444px; height:50px; 
line-height:50px;">
<strong><?php echo UPDATE_IMGVID?></strong></div>
<?php } else { ?>
<div align="center" style="font-size:20px; background-color:#9BAFD5; width:420px; margin-top:20px; margin-left:450px; height:50px; 
line-height:50px;">
<strong><?php echo UPLOAD_IMGVID?></strong></div>
			  <?php } ?>
  </tr>
  <tr style="height:45%"><td align="center">
   <div id="LoginBox" class="borderRound borderShadow" >
  <form id="frm-image-upload" name='frm-image-upload'   method="post" action="" enctype="multipart/form-data" onSubmit="return frmValidate(this);">
    <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px; height:300px">
	<?php
	$pdSQL6 = "SELECT * FROM attributes_gallery where oid = '$unique_id' and component_name='$componentName'";
	$pdSQLResult6 = mysql_query($pdSQL6);
	$pdData6 = mysql_fetch_array($pdSQLResult6);
	?>
  <tr><td><label><?php echo "Select File Type:";?></label></td>
  <td>
  		<select name="dwg_status">
		 <option value="1" <?php if($dwg_status=='1'){echo "selected"; }?> >Image</option>
  		<option value="3" <?php if($dwg_status=='3'){echo "selected"; }?>>Video</option>
		</select>
 </td>
  </tr>
    <tr><td><label><?php echo "Image Name (English):";?></label></td>
  <td><input style="margin-left:15px" type="text" name="image_name_eng" id="image_name_eng" value="<?php echo $image_name_eng; ?>" /></td>
  </tr>
  <tr>
  <td><label><?php echo "Image Name (Russian):";?></label></td>
  <td><input style="margin-left:15px" type="text" name="image_name_rus" id="image_name_rus" value="<?php echo $image_name_rus; ?>" /></td>
  </tr> 
  <tr><td><label><?php echo "Upload File:";?><b>(JPG,JPEG,PNG and mp4 only)</b></label></td>
  <td><input style="margin-left:50px" type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>" /></td>
  </tr>
  <tr><td><label><?php echo "Upload Date:";?></label></td>
  <td><input style="margin-left:15px" type="text" id="dwg_date"  name="dwg_date"  value="<?php echo $dwg_date;?>"/> </td>
  </tr>
  <tr><td><label><?php echo "Image taken:";?></label></td>
  <td>                <input type="radio" id="camera" name="dwg_title" value="1" <?php if($dwg_title==1) {echo "checked";} ?> checked="checked">
                <label for="camera">By Camera</label>
                <input type="radio" id="drone" name="dwg_title" value="2" <?php if($dwg_title==2) {echo "checked";} ?> >
                <label for="drone">By Drone</label>            
</td>
  </tr>
  
  <tr><td colspan="2" align="center"> 
  <?php if(isset($_REQUEST['attrib_gallery_id']))
	 {
		 
	 ?>
     <input type="hidden" name="dwgid" id="dwgid" value="<?php echo $_REQUEST['dwgid']; ?>" />
     <input  type="submit" name="update" id="btn-submit" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="btn-submit" value="Save" />
	 <?php
	 }
	 ?> <input id="btn-submit" type=button onClick="parent.location='detail_all_range_pu.php?channel_id=<?php echo $channel_id; ?>&from_kmpost=<?php echo $from_kmpost; ?>&to_kmpost=<?php echo $to_kmpost; ?>&detail=<?php echo $detail; ?>'" value='<?php echo CANCEL?>'></td></tr>
	 </table>
	
  </form> 
  </div>
  </td></tr>
  </table>
      <?php if(!empty($message)) { ?>
<div style="background:#c5f3c3; border:#bbe6ba 1px solid; padding:10px; border-radius:2px; width:425px; margin-left:450px;"><?php echo $message; ?></div> 
    <?php }?>
</div>



<div id="tableContainer" class="table" style="border-left:1px;">
		<table  width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo UNIQUE_ID?></td>
       <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo NAME;?></td>
       <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo "Name (Russian)";?></td>              
       <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo IMAGVID;?></td>
       <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo "Uploaded Date";?></td>       
       <td style="width:15%; font-weight:bold; background:#ededed" class="clsleft"><?php echo "Image Taken By";?></td>
       
      <td colspan="2" style="width:20%; font-weight:bold; background:#ededed"><?php echo ACTION;?></td>
      
    </tr>
    <?php
	
	$query = "SELECT code,latitude,longitude,layer,oid,label from dgps_survey_data where component_name='$componentName' and channel_id='".$channel_id."' and chainage_id BETWEEN ".$from_kmpost. " AND ".$to_kmpost.' and code="'.$detail.'"';
//echo $query;
$result=mysql_query($query);

 if (mysql_num_rows($result) > 0) {
	 $m=0;
 while($row5 = mysql_fetch_assoc($result))
 {
	$unique_id=$row5['oid'];
	
	$query4 = "SELECT * FROM attributes_gallery where oid = '$unique_id' and component_name='$componentName'";
	//echo $query4;
	 $result4=mysql_query($query4);
	 mysql_num_rows($result4);
 if (mysql_num_rows($result4) > 0) {
while($row4 = mysql_fetch_assoc($result4))
{
		
		if($row4['item_type']=="1" || $row4['item_type']=="4" || $row4['item_type']=="3")
		{
			$extension = explode(".", $row4['item_name']);
		$extension[1];
		if($extension[1] == "jpg" || $extension[1] == "JPG" || $extension[1] == "png" || $extension[1] == "gif" || $extension[1] == "mp4")
		{
		?>
    		<tr bgcolor="<?php echo $bgcolor;?>">
            <td class="clsleft"><?php echo $row4['oid'];?></td>
                  <td class="clsleft"><?php echo $row4['image_name_eng'];?></td>
			<td class="clsleft"><?php echo $row4['image_name_rus'];?></td>    
<td>
	<img src="<?php echo SITE_URL;?>idip_photos/<?php echo $row4['item_name']; ?>" width="50" height="35px"/>
</td>
<td class="clsleft"><?php echo $row4['item_date'];?></td>
            <td class="clsleft"><?php if($row4['image_type']=="1"){ echo "Camera";} 
				else if ($row4['image_type']=="2")
				{echo "Drone";}
;?></td>
<?php if(($_SESSION['ne_gmcentry']== 1) && ($_SESSION['ne_gmcadm']== 0)){
?>            
                <td colspan="2"><a href="add_image.php?attrib_gallery_id=<?php echo $row4['attrib_gallery_id'];?>&unique_id=<?php echo $row4['oid']?>" title="<?php echo EDIT;?>"><img src="<?php echo SITE_URL;?>images/edit.gif" border="0" /></a></td>
               
                <?php
				 }
				 ?>
<?php if(($_SESSION['ne_gmcentry']== 1) && ($_SESSION['ne_gmcadm']== 1)){
?>            
                <td><a href="add_bulkimage.php?attrib_gallery_id=<?php echo $row4['attrib_gallery_id'];?>&unique_id=<?php echo $row4['oid']?>&channel_id=<?php echo $channel_id; ?>&from_kmpost=<?php echo $from_kmpost; ?>&to_kmpost=<?php echo $to_kmpost; ?>&detail=<?php echo $detail; ?>" title="<?php echo EDIT;?>"><img src="<?php echo SITE_URL;?>images/edit.gif" border="0" /></a></td>
                <td><a href="add_bulkimage.php?mode=delete&attrib_gallery_id=<?php echo $row4['attrib_gallery_id'];?>&unique_id=<?php echo $unique_id ?>&channel_id=<?php echo $channel_id; ?>&from_kmpost=<?php echo $from_kmpost; ?>&to_kmpost=<?php echo $to_kmpost; ?>&detail=<?php echo $detail; ?>" onClick="return confirm('Are you sure you want to delete this image?');" title="<?php echo DELETE;?>" name="delete"><img src="<?php echo SITE_URL;?>images/delete.gif" border="0" alt="Delete" title="<?php echo DELETE;?>" /></a></td>
                <?php
				 }
				 ?>
    		</tr>

    <?php
		
	}
		}
	
	}	
 }
 }
 }

	 

	?>
  </table>
		</div>
