<?php 
include("top.php");
if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}

 if(isset($_REQUEST['unique_id']))
  {
	   $unique_id=$_REQUEST['unique_id'];
  }

	$SQLbf = "Select * from dgps_survey_data where oid='$unique_id'  and component_name='$componentName'";
	//echo $SQLbf;
	$reportresultbf= mysql_query($SQLbf);
	$reportdatabf = mysql_fetch_array($reportresultbf);
	$latbf = $reportdatabf['dgps_lat'];  
   $lngbf = $reportdatabf['dgps_long'];   
function getExtention($type){
	if($type == "application/pdf")
		return "pdf";
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
				@unlink( "../pdf/" .$old_al_file);
			}
					
				}
					$sdelete= "Delete from attributes_gallery where attrib_gallery_id=".$attrib_gallery_id. " and component_name='$componentName'";
	   mysql_query($sdelete);
	if ($sdelete == TRUE) {
    $message=  "Record deleted successfully";
	} else {
    $message= mysql_error($db);
	}
				
						redirect('add_report.php?unique_id='.$unique_id);
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
        $target = "../pdf/" . $load_file;	
	$file_name=$loadfile;
   
	if( 
	($_FILES["al_file"]["type"] == "application/pdf"))
	{ 
	$target_file=$file_path.$file_name;
        $target = "../pdf/" . $target_file;	
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target))
	{
		
	$sql_query="insert into attributes_gallery (component_name,oid, item_type, item_name, item_date, image_type, image_name_eng, image_name_rus) values('".$componentName."',".$unique_id.",".$dwg_status.", '".$file_name."', '".$dwg_date."', '".$dwg_title."', '".$image_name_eng."', '".$image_name_rus."')";
	$sql_pro=mysql_query($sql_query);
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
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
				@unlink( "../pdf/" .$old_al_file);
			}
					
				}

	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	$loadfile = basename($_FILES["al_file"]["name"]);
        $target = "../pdf/" . $load_file;	
	 $file_name=$loadfile;
   
	if( ($_FILES["al_file"]["type"] == "application/pdf"))
	{ 
	$target_file=$file_path.$file_name;
        $target = "../pdf/" . $target_file;	
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target))
	{
			
    $sql_pro="UPDATE attributes_gallery set oid = '".$unique_id."', item_type = '".$dwg_status."', item_name = '".$file_name."', item_date = '".$dwg_date."', image_type = '".$dwg_title."', image_name_eng = '".$image_name_eng."', image_name_rus = '".$image_name_rus."' where attrib_gallery_id=".$attrib_gallery_id. " and component_name='$componentName'";
	
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
$sql_pro="UPDATE attributes_gallery set oid = '".$unique_id."', item_type = '".$dwg_status."', item_date = '".$dwg_date."', image_type = '".$dwg_title."', image_name_eng = '".$image_name_eng."', image_name_rus = '".$image_name_rus."' where attrib_gallery_id=".$attrib_gallery_id. " and component_name='$componentName'";	
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

    <title><?php echo "Add Report"?></title>
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

 

<div id="tableContainer">
<table  align="center">
  <tr style="height:10%">
<?php if ($editflag == 1) { ?>
<div align="center" style="font-size:20px; background-color:#9BAFD5; width:420px; margin-top:20px; margin-left:444px; height:50px; line-height:50px;">
<strong><?php echo UPDATE_FILE?></strong></div>
<?php } else { ?>
<div align="center" style="font-size:20px; background-color:#9BAFD5; width:420px; margin-top:20px; margin-left:450px; height:50px; line-height:50px;">
<strong><?php echo UPLOAD_FILE?></strong></div>
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
		 <option value="2" <?php if($dwg_status=='2'){echo "selected"; }?> >Drawing</option>
  		<option value="4" <?php if($dwg_status=='4'){echo "selected"; }?>>GIS Map</option>
		 <option value="5" <?php if($dwg_status=='5'){echo "selected"; }?> >Monthly Report</option>
  		<option value="6" <?php if($dwg_status=='6'){echo "selected"; }?>>Weekly Report</option>
		 <option value="7" <?php if($dwg_status=='7'){echo "selected"; }?> >Quarterly Report</option>
  		<option value="8" <?php if($dwg_status=='8'){echo "selected"; }?>>Survey Report</option>
		</select>
 </td>
  </tr>
  <tr><td><label><?php echo "File Name (English):";?></label></td>
  <td><input style="margin-left:15px" type="text" name="image_name_eng" id="image_name_eng" value="<?php echo $image_name_eng; ?>" /></td>
  </tr>
  <tr>
  <td><label><?php echo "File Name (Russian):";?></label></td>
  <td><input style="margin-left:15px" type="text" name="image_name_rus" id="image_name_rus" value="<?php echo $image_name_rus; ?>" /></td>
  </tr>
    
  <tr><td><label><?php echo "Upload File:";?><b>(PDF Only)</b></label></td>
  <td><input style="margin-left:50px" type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>" /></td>
  </tr>
  <tr><td><label><?php echo "Upload Date:";?></label></td>
  <td><input style="margin-left:15px" type="text" name="dwg_date" id="dwg_date" value="<?php echo $dwg_date;?>"/> </td>
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
	 ?> <input id="btn-submit" type=button onClick="parent.location='detail_link.php?unique_id=<?php echo $unique_id?>'" value='<?php echo CANCEL?>'></td></tr>
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
      
       <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo FILE_NAME;?></td>
        <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo "Name (Russian)";?></td> 
       <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo "Uploaded Date";?></td>                           
       <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo FILE_TYPE;?></td>       
      <td colspan="2" style="width:20%; font-weight:bold; background:#ededed"><?php echo ACTION;?></td>
      
    </tr>
    <?php
	$query4 = "SELECT * FROM attributes_gallery where oid = '$unique_id'  and component_name='$componentName'";
	//echo $query4;
	 $result4=mysql_query($query4);
	 mysql_num_rows($result4);
 if (mysql_num_rows($result4) > 0) {
while($row4 = mysql_fetch_assoc($result4))
{
		
		if($row4['item_type']=="2" || $row4['item_type']=="4" || $row4['item_type']=="5" || $row4['item_type']=="6" || $row4['item_type']=="7" || $row4['item_type']=="8")
		{
			$extension = explode(".", $row4['item_name']);
		$extension[1];
		if($extension[1] == "pdf")
		{
		?>
    		<tr bgcolor="<?php echo $bgcolor;?>">
                
                  <td class="clsleft"><?php echo $row4['image_name_eng'];?></td>
			<td class="clsleft"><?php echo $row4['image_name_rus'];?></td> 
            <td class="clsleft"><?php echo $row4['item_date'];?></td>    
                <td class="clsleft">
				<?php 
				if($row4['item_type']=="2") 
				{ echo "Drawing";} 
				else if ($row4['item_type']=="4")
				{echo "GIS Map";}
				else if ($row4['item_type']=="5")
				{echo "Monthly Report";}
				else if ($row4['item_type']=="6")
				{echo "Weekly Report";}
				else if ($row4['item_type']=="7")
				{echo "Quarterly Report";}
				else if ($row4['item_type']=="8")
				{echo "Survey Report";}?>
                </td>
                
                
               <?php if(($_SESSION['ne_gmcentry']== 1) && ($_SESSION['ne_gmcadm']== 0)){
?>                  
                <td colspan="2"><a href="add_report.php?attrib_gallery_id=<?php echo $row4['attrib_gallery_id'];?>&unique_id=<?php echo $row4['oid']?>" title="<?php echo EDIT?>"><img src="<?php echo SITE_URL;?>images/edit.gif" border="0" /></a></td>
                <?php
				}
				?>
               <?php if(($_SESSION['ne_gmcentry']== 1) && ($_SESSION['ne_gmcadm']== 1)){
?>
                <td><a href="add_report.php?attrib_gallery_id=<?php echo $row4['attrib_gallery_id'];?>&unique_id=<?php echo $row4['oid']?>" title="<?php echo EDIT?>"><img src="<?php echo SITE_URL;?>images/edit.gif" border="0" /></a></td>
                <td><a href="add_report.php?mode=delete&attrib_gallery_id=<?php echo $row4['attrib_gallery_id'];?>&unique_id=<?php echo $row4['oid']?>" onClick="return confirm('Are you sure you want to delete this image?');" title="<?php echo DELETE?>" name="<?php echo DELETE?>"><img src="<?php echo SITE_URL;?>images/delete.gif" border="0" alt="<?php echo DELETE?>" title="<?php echo DELETE?>" /></a></td>
                <?php
				}
				?>
    		</tr>

    <?php
		
	}
		}
	
	}	
 }
 
 else
 {
	 	?>
        <div class="new_div" style="float:left">
			
	<div  style="float:left;width:210px;margin-right:0px;">
        
	<img style="width:; height:" src="../images/norecord.png" width="200" height="180px" />

</div>
	
	</div>
        
<?php
	 
	 }
	?>
  </table>
		</div>
