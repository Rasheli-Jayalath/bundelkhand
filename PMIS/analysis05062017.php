<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
$uname			= $_SESSION['uname'];
$admflag		= $_SESSION['admflag'];
/*$superadmflag	= $_SESSION['superadmflag'];
$payrollflag	= $_SESSION['payrollflag'];
$petrolflag		= $_SESSION['petrolflag'];
$petrolEntry	= $_SESSION['petrolEntry'];
$petrolVerify	= $_SESSION['petrolVerify'];
$petrolApproval	= $_SESSION['petrolApproval'];
$petrolPayment	= $_SESSION['petrolPayment'];*/
if ($uname==null  ) {
header("Location: index.php?init=3");
} 
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");

$file_path="pictorial_data/";
$msg						= "";

 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
if(isset($_REQUEST['lid']))
{
$lid=$_REQUEST['lid'];
$pdSQL1="SELECT lid, pid, title FROM  locations  WHERE  lid = ".$lid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

$title=$pdData1['title'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['lid'])&$_REQUEST['lid']!="")
{

 mysql_query("Delete from  locations where lid=".$_REQUEST['lid']);
 header("Location: location_form.php");
}
$pdSQLq="";
$pdSQLq = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title FROM  project_photos a inner join locations b on(a.ph_cap=b.lid) WHERE a.pid=".$pid;
if(!empty($_GET['date_p'])){
	$date_p = urldecode($_GET['date_p']);
	$pdSQLq .=" AND date_p='".$date_p."'";
}
if(!empty($_GET['location'])){
	$location = urldecode($_GET['location']);
	$pdSQLq .=" AND ph_cap='".$location."'";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  
 <?php /*?> <link rel="stylesheet" type="text/css" media="all" href="calender/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <script type="text/javascript" src="calender/calendar.js"></script>
  <script type="text/javascript" src="calender/lang/calendar-en.js"></script>
  <script type="text/javascript" src="calender/calendar-setup.js"></script><?php */?>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>

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
</style>
<script type="text/javascript">
function doFilter(frm){
	var qString = '';
	if(frm.location.value != ""){
		qString += 'location=' + escape(frm.location.value);
	}
	
	if(frm.date_p.value != ""){
		qString += '&date_p=' + frm.date_p.value;
	}
	/*if(frm.desg_id.value != ""){
		qString += '&desg_id=' + frm.desg_id.value;
	}
	if(frm.emp_type.value != ""){
		qString += '&emp_type=' + frm.emp_type.value;
	}
	if(frm.smec_egc.value != ""){
		qString += '&smec_egc=' + frm.smec_egc.value;
	}*/
	document.location = 'analysis.php?' + qString;
}
</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
<h1> Location Control Panel</h1>
<table style="width:100%; height:100%">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Analysis</span><span style="float:right">
    <form action="pictorial_form.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="" target="_self" method="post"  enctype="multipart/form-data">
  <table border="1" width="100%" height="100%">
  <tr><td><label><?php echo "Location:";?></label></td>
  <td><select id="location" name="location">
     <option value="0">Select Location</option>
  		<?php $pdSQL = "SELECT lid, pid, title FROM  locations WHERE pid=".$pid." order by lid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;?>
  <option value="<?php echo $pdData["lid"];?>" <?php if($location==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
   <?php } 
   }?>
  </select></td>
  </tr>
  <tr><td><label><?php echo "Date:";?></label></td>
  <td><select id="date_p" name="date_p">
     <option value="0">Select Date</option>
  		<?php $pdSQLd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE pid=".$pid." order by date_p  ASC";
						 $pdSQLResultd = mysql_query($pdSQLd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultd)>=1)
							  {
							  while($pdDatad = mysql_fetch_array($pdSQLResultd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatad["date_p"];?>" <?php if($date_p==$pdDatad["date_p"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatad["date_p"]));?></option>
   <?php } 
   }?>
  </select></td>
  </tr>
  <tr><td colspan="2"> 
	<input type="button" onclick="doFilter(this.form);" class="SubmitButton" name="Submit" id="Submit" value=" View " />
	</td></tr>
	 </table>
	
  </form> 
  </td></tr>
  <tr>
  <td>
   <div style="overflow-y: scroll; height:360px;">
  <table width="650" class="table table-bordered">
  <tbody>
  <?php  
			
			 $cm=0;
			
			 $pdSQLResult = mysql_query($pdSQLq);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				
				if($cm==0 || $cm%6==0)
				{
				echo "<tr>";
				}?>
            
           
                          <td width="26%" ><?php if($result['al_file']!="")
				{
			/*	$file_array=explode(".",$result['al_file']);
				$file_type=$file_array[1];
				if(($file_type=="jpeg") || ($file_type=="jpg") || ($file_type=="gif") || ($file_type=="png"))
				{*/
				?>
                <a href="<?php echo $file_path.$result['al_file']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none"><img src="<?php echo $file_path.$result['al_file']; ?>" title="Inatke as on <?php echo date('d F, Y',strtotime($month)); ?>" style=" border:3px solid #000; border-radius:6px;margin-top:10px;"  width="150" height="100"/></a>
				<?php /*?> <a href="sp_photo_large.php?photo=<?php echo $result['al_file'];?>&phid=<?php echo $result['phid'];?>" target="_parent" ><img src="<?php echo $file_path.$result['al_file']; ?>" width="150" height="100" border="0" /></a><?php */?>
				<?php /*?><?php
				}
				else
				{
				?>
                 <a href="sp_photo_large.php?photo=<?php echo $result['al_file'];?>&phid=<?php echo $result['phid'];?>" target="_parent" >
                 <img src="images/tag_small.png"  border="0" width="150" height="100"/></a>
                 <?php<?php */?>
				 <?php //}
				}?></td>
            <?php 
			$cm++;
			if($cm==6 || $cm%6==0)
			{
			echo "</tr>";
			}
			}}?>
                     
                              </tbody>
      </table>
                        </div>
                        </td>
                        </tr>
  </table>
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
