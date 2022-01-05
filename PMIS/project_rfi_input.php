<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "Non Confirmity Notices";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($ncf_flag==0)
{
	header("Location: index.php?init=3");
}
$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
    //Based on the lowecase $_GET['language'] value, we will decide,
    //what lanuage do we use
    switch (strtolower($_GET["language"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang'] = 'en';
            break;
        case "rus":
            //If the string is tr or TR
            $_SESSION['lang'] = 'rus';
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang'] = $defaultLang;
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.admin.php');

}
else
{
	require_once('rs_lang.admin_rus.php');

}

$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$objCSDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
$file_path="project_data/";
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
function getExtention($type){
	if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
		return "jpg";
	elseif($type == "image/png")
		return "png";
	elseif($type == "image/gif")
		return "gif";
	elseif($type == "application/pdf")
		return "pdf";
	elseif($type == "application/msword")
		return "doc";
	elseif($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		return "docx";
	elseif($type == "text/plain")
		return "doc";
		
}
if(isset($_REQUEST['save']))
{
	
	$iss_no=$_REQUEST['iss_no'];
	$iss_title=$_REQUEST['iss_title'];
	$iss_detail=$_REQUEST['iss_detail'];
	$iss_status=$_REQUEST['iss_status'];
	$iss_action=$_REQUEST['iss_action'];
	$iss_remarks=$_REQUEST['iss_remarks'];
	$comp_id=$_REQUEST['comp_id'];
	$message="";
	$pgid=1;
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	 $file_name=genRandom(5)."-".$pid;
   
	if(($_FILES["al_file"]["type"] == "application/pdf")|| ($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$flink=$file_name.".".$extension;
	  $target_file=$file_path.$flink;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['al_file']['tmp_name'], $target_file);	
	
	
	}
	}
 $sql_pro=mysql_query("INSERT INTO t013nonconformitynotice (pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks,attachment,comp_id) Values(".$pid.",'".$iss_no."', '".$iss_title."', '".$iss_detail."', '".$iss_status."', '".$iss_action."', '".$iss_remarks."', '".$flink."', '".$comp_id."')");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= "Error in adding record";
}
	
	$iss_no='';
	$iss_title='';
	$iss_detail='';
	$iss_status='';
	$iss_action='';
	$iss_remarks='';
	$al_file='';
}
if(isset($_REQUEST['nos_id']))
{
$nos_id=$_REQUEST['nos_id'];

$pdSQL1="SELECT nos_id, pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks, attachment, comp_id FROM t013nonconformitynotice  where pid = ".$pid." and  nos_id = ".$nos_id;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$iss_no=$pdData1['iss_no'];
	$iss_title=$pdData1['iss_title'];
	$iss_detail=$pdData1['iss_detail'];
	$iss_status=$pdData1['iss_status'];
	$iss_action=$pdData1['iss_action'];
	$iss_remarks=$pdData1['iss_remarks'];
	$comp_id=$pdData1['comp_id'];
	$old_attachment=$pdData1['attachment'];
}
if(isset($_REQUEST['update']))
{
	
	$nos_id=$_REQUEST['nos_id'];
	$iss_no=$_REQUEST['iss_no'];
	$iss_title=$_REQUEST['iss_title'];
	$iss_detail=$_REQUEST['iss_detail'];
	$iss_status=$_REQUEST['iss_status'];
	$iss_action=$_REQUEST['iss_action'];
	$iss_remarks=$_REQUEST['iss_remarks'];
	$comp_id=$_REQUEST['comp_id'];
	$message="";
	$pgid=1;
	if($old_attachment){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path.$old_attachment);
				
			}
					
				}
				if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	 $file_name=genRandom(5)."-".$pid;
   
	if(($_FILES["al_file"]["type"] == "application/pdf")|| ($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$flink=$file_name.".".$extension;
	 $target_file=$file_path.$flink;
	 //$target_file = $file_path . basename($_FILES['al_file']["name"]);
	
	move_uploaded_file($_FILES['al_file']['tmp_name'], $target_file);	
	
	
	}
	}
$sql_pro="UPDATE t013nonconformitynotice SET iss_no='$iss_no', iss_title='$iss_title', iss_detail='$iss_detail',  iss_status='$iss_status',  iss_action='$iss_action', iss_remarks='$iss_remarks' , attachment='$flink' , comp_id='$comp_id'  where nos_id=$nos_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= "Error in updating record";
}
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
header("Location: project_rfi_info.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="scripts/JsCommon.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
</head>
<body>

<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
	 <table class="issues" width="100%" style="background-color:#FFF">
     
  <tr ><th><?php echo "Request for Inspection Reports";?><span style="float:right"><form action="project_nonconfirmity_info.php" method="post"><input type="submit" name="back" id="back" value="<?php echo BACK;?>" /></form></span></th></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="project_nonconfirmity_input.php" target="_self" method="post"  enctype="multipart/form-data">
  <table class="issues" width="100%" style="background-color:#FFF">
  <tr><td><label><?php echo COMP; ?>:</td><td><select id="comp_id" name="comp_id" onchange="getDates(this.value)" style="width:242px">
     	<option value="0"><?php echo COMP ?></option>
  		<?php $pdSQL = "SELECT * FROM  component_tbl WHERE project_id=".$pid." order by comp_id";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;?>
  <option value="<?php echo $pdData["comp_id"];?>" <?php if($comp_id==$pdData["comp_id"]) {?> selected="selected" <?php }?>><?php echo $pdData["comp_name"];?></option>
   <?php } 
   }?>
  </select></td></tr>
  <tr><td><label><?php echo "No";?>:</label></td><td><input  type="text" name="iss_no" id="iss_no" value="<?php echo $iss_no; ?>" /></td></tr>
  
    <tr>
      <td><?php echo "Detail";?>:</td><td><textarea rows="4" cols="50" name="iss_title"><?php echo $iss_title; ?></textarea></td></tr>
   
     <tr><td><label><?php echo RECT;?>:</label></td><td>
     <textarea rows="4" cols="50" name="iss_detail"><?php echo $iss_detail; ?></textarea>
	  <?php /*
			  $oFCKeditor = new FCKeditor('iss_detail') ;
			  $oFCKeditor->BasePath   = 'fckeditor/';
			  $oFCKeditor->Width      = "506px";
			  $oFCKeditor->Height     = "250";
			  $oFCKeditor->ToolbarSet = "Basic";
			  $oFCKeditor->Value     = stripslashes($iss_detail);      
			  $oFCKeditor->Create( );*/
			  ?>
	</td></tr>
     <tr>
       <td><label><?php echo ACTION;?>:</label></td>
       <td><textarea rows="4" cols="50" name="iss_action"><?php echo $iss_action; ?></textarea></td>
     </tr>
	
	  <tr><td><label><?php echo STATUS;?>:</label></td><td>Pending<input type="radio" id="iss_status" name="iss_status" value="1"  checked="checked"/>Closed<input type="radio" id="iss_status" name="iss_status" value="2"  <?php if($iss_status==2) echo 'checked="checked"';?>/></td></tr>
	   <tr><td><label><?php echo REMARKS?>:</label></td><td><textarea rows="4" cols="50" name="iss_remarks"><?php echo $iss_remarks; ?></textarea></td></tr>
	  <tr><td><label><?php echo ATTACH;?></label></td>
  <td><input  type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>" /></td>
  </tr>
	 <tr>
	 <td>&nbsp;</td>
	 <td > <?php if(isset($_REQUEST['nos_id']))
	 {
		 
	 ?>
     <input type="hidden" name="nos_id" id="nos_id" value="<?php echo $_REQUEST['nos_id']; ?>" />
     <input  type="submit" name="update" id="update" value="<?php echo UPDATE?>" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="<?php echo SAVE;?>" />
	 <?php
	 }
	 ?> </td></tr>
	 </table>
	  
	  
  
  
  </form> 
  </td></tr>
  
  </table>
	<br clear="all" />
	
	
	
<div id="search"></div>
	<div id="without_search"></div>

</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
