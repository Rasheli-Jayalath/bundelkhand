<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Pictorial Analysis";
if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($pic_flag==0  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$file_path="pictorial_data";
$data_url="photos/";
$msg= "";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];

 $album_id=$_REQUEST['album_id'];
 if(isset($album_id)&&!empty( $album_id))
 {
  $pdSQL11="SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$pid." and  albumid = ".$album_id;
$pdSQLResult11 = mysql_query($pdSQL11) or die(mysql_error());
$pdData11 = mysql_fetch_array($pdSQLResult11);
$status=$pdData11['status'];
$album_name=$pdData11['album_name'];
 }
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
		
		if(!empty($_GET['location'])){
			$location = urldecode($_GET['location']);
			$pdSQLq .=" AND ph_cap='".$location."'";
		}
		if(!empty($_GET['date_p'])){
			$date_p = urldecode($_GET['date_p']);
			$pdSQLq .=" AND (date_p='".$date_p."'";
		}
		if(!empty($_REQUEST['date_p2'])){
			$date_p2 = urldecode($_REQUEST['date_p2']);
			$pdSQLq .=" OR date_p='".$date_p2."' )";
		}
	//	echo $pdSQLq;
		
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
</style>
<script type="text/javascript">
function getGalleryView(month) 
	{
	
		var location=document.getElementById("location").value;  
			
		if (month!="") {
			var strURL="findGalleryView.php?date_p="+month+" &location="+location;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('Gallery_View').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		   
	}
function doFilter(frm){
	var qString = '';
	if(frm.location.value != ""){
		qString += 'location=' + escape(frm.location.value);
	}
	
	if(frm.date_p.value != ""){
		qString += '&date_p=' + frm.date_p.value;
	}
	if(frm.date_p2.value != ""){
		qString += '&date_p2=' + frm.date_p2.value;
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
<script>
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
	
function getDates(lid)
{
	
	if (lid!=0) {
			var strURL="finddate.php?lid="+lid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("location_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 

}
</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
</head>
<body>

  <?php include 'includes/header.php'; ?>
<div id="content">

<table style="width:100%; height:100%">

  <tr style="height:45%"><td width="5%" align="left" valign="top" >
  <div style="border:1px solid #000; border-radius:6px; vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; background-color:#E0E0E0">
  <?php  if($picentry_flag==1 || $picadm_flag==1)
	{
	?>
  <div style="clear:both; margin:5px ">
<a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('pictorial_form.php', 'Upload Photos ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none">Upload Photos</a>
	</div>
    <?php
	}
	?>
<div style="vertical-align:top; margin:5px 15px 0px 5px; padding:5px 0px 0px 5px;" >
  <div id="LoginBox" class="borderRound borderShadow" >
<form action="" target="_self" method="post"  enctype="multipart/form-data">
  <table border="0" width="100%" height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td colspan="2" align="left"><strong>Select Location:</strong></td></tr>
  <tr>
  <td colspan="2"><select id="location" name="location" onchange="getDates(this.value)" style="width:242px">
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
  <tr><td colspan="2" align="left"><strong>Comparison Dates:</strong></td></tr>
  <tr><td  colspan="2"  align="left"><div id="location_div" style="width:100%">
  <select id="date_p" name="date_p" style="width:120px">
     <option value="0">Date 1</option>
     <?php 
			$pdSQLdd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE pid=".$pid." order by date_p  ASC";
		
  		
						 $pdSQLResultdd = mysql_query($pdSQLdd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultdd)>=1)
							  {
							  while($pdDatadd = mysql_fetch_array($pdSQLResultdd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatadd["date_p"];?>" <?php if($date_p==$pdDatadd["date_p"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatadd["date_p"]));?></option>
   <?php } 
   }?>
  </select>
  <select id="date_p2" name="date_p2"  style="width:120px">
     <option value="0">Date 2</option>
     <?php 
			$pdSQLd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE pid=".$pid." order by date_p  ASC";
		
						 $pdSQLResultd = mysql_query($pdSQLd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultd)>=1)
							  {
							  while($pdDatad = mysql_fetch_array($pdSQLResultd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatad["date_p"];?>" <?php if($date_p2==$pdDatad["date_p"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatad["date_p"]));?></option>
   <?php } 
   }?>
  </select>
  </div></td>
  </tr>
  <tr><td colspan="2" align="center"> 
	<input type="button"  onclick="doFilter(this.form);" class="SubmitButton" name="Submit" id="Submit" value=" View " />
	</td></tr>
	 </table>
	
  </form>
  </div>
</div>
<div style="vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px;" id="Gallery_View">
   <?php if(!empty($_GET['date_p'])&&!empty($_GET['location'])&&!empty($_GET['date_p2']))
  {

			 $pdSQLResult = mysql_query($pdSQLq);
			if(mysql_num_rows($pdSQLResult) >= 1){
			while($result = mysql_fetch_array($pdSQLResult))
			{
				 if($result['al_file']!="")
				{
			
				?>
                <strong><?php echo $result['title']."&nbsp; as on &nbsp;&nbsp;".date('d F, Y',strtotime($result['date_p'])); ?>:</strong>
                <a href="<?php echo $file_path."/".$result['al_file']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none"><img src="<?php echo $file_path."/thumb/".$result['al_file']; ?>" title="<?php echo date('d F, Y',strtotime($result['date_p'])); ?>"  style=" border:3px solid #000; border-radius:6px;margin-top:10px;"  width="270px" /></a>
			<br/><br/>
				 <?php 
				}
			}
				}
				
  } ?>       
</div> 
</div>
  
   
  </td><td width="67%" valign="top"> <div style="border:1px solid #000; border-radius:6px; vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; "><table style="width:100%; height:100%">
  
    <tr style="height:60px">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Photo/Video Albums</span>
    
	<span style="float:right">
    <?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]))
	{?>
    <a class="SubmitButton"  href="analysis.php"  style="margin:5px; text-decoration:none">View Albums</a>
	<?php } ?>
	<?php  if($picentry_flag==1 || $picadm_flag==1)
	{
	?>
    <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_album_input.php', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none">Manage Albums</a>
	
	<?php
	}
	?>
	
	</span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
<?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]))
{?>
<table style="width:100%; height:auto; border:1px solid #ccc; border-radius:6px;"  >
  
    <tr >
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span><?php echo $album_name; ?>
    </span>
	<span style="float:right; width:160px;margin-top:10px">
	<?php  if($picentry_flag==1 || $picadm_flag==1)
	{
	?>
    <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_photo_album_input.php?album_id=<?php echo $album_id; ?>', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none">Manage Photos</a>
	
	<?php
	}
	?>
	
	</span></td></tr>
  <tr><td align="center" valign="top">
 <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." order by phid";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				
				
				?>
				<?php if($result['al_file']!="")
				{
				$file_array=explode(".",$result['al_file']);
				$file_type=$file_array[1];
				if(($file_type=="jpeg") || ($file_type=="jpg") || ($file_type=="gif") || ($file_type=="png"))
				{
				?>
				<div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:163px;margin-right:0px;">

	   <a  href="<?php echo  $data_url.$result['al_file']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none" >
	<div style="border: thin #999 solid; padding: 3px;margin-bottom: 5px;">	
	<img src="<?php echo $data_url."thumb/".$result['al_file']; ?>"  border="0" title="<?php echo $result['ph_cap'];?>"/>
	</div>
	</a>
	</div>
	</li>
	</div>
            <?php
				}
				else
				{
				?>
                <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">

	   <a  href="sp_photo_large.php?photo=<?php echo $result['al_file'];?>&phid=<?php echo $result['phid'];?>&album_id=<?php echo $album_id;?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none" >
	<div class="img-frame-gallery">	
	<img src="images/tag_small.png"  border="0" width="150" height="100" />
	</div>
	</a>
	
	</div>
	</li>
	</div>
                
                 <?php
				 }
				}
				}
			}
			else
			{
			?>
			<tr><td>No Record Found</td></tr>
			<?php
			}?>
                              </tbody>
      </table>

  </td></tr>
  </table>
  <div style="clear:both; margin-top:10px"></div>
  <table style="width:100%; height:auto; border:1px solid #ccc; border-radius:6px;" >
    <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span><?php echo "Videos"; ?></span>
	<span style="float:right; width:160px;margin-top:10px">
	<?php  if($picentry_flag==1 || $picadm_flag==1)
	{
	?>
	
     <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_video_input.php?album_id=<?php echo $album_id; ?>', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  
     style="margin-top:20px;text-decoration:none">Manage Videos</a>
	<?php
	}
	?>
	</span></td></tr>
  <tr><td align="center" valign="top">

   <table width="100%" style=" padding: 3px; font-family: Verdana, Geneva, sans-serif; font-size: 12px;
    font-weight: bold;  margin: 0px;">
     <tbody><?php  
			
			 $cm=0;
			 $pdSQL = "SELECT vid, pid,album_id,v_cap,v_al_file FROM t32project_videos WHERE pid = ".$pid." and album_id=".$album_id." order by vid";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				
				if($cm==0 || $cm%6==0)
				{
				echo "<tr>";
				}?><td width="26%" style="border: thin #999 solid; padding: 3px; font-family: Verdana, Geneva, sans-serif; font-size: 12px;
    font-weight: bold;  margin: 0px;"><?php if($result['v_al_file']!="")
				{
				$file_array=explode(".",$result['v_al_file']);
				$file_type=$file_array[1];
				/*if(($file_type=="jpeg") || ($file_type=="jpg") || ($file_type=="gif") || ($file_type=="png"))
				{*/
				?>
				 <a  href="javascript:void(null);" onclick="window.open('sp_video_large.php?video=<?php echo $result['v_al_file'];?>&vid=<?php echo $result['vid'];?>&album_id=<?php echo $album_id;?>', 'View Video ','width=700px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  
     style="margin-top:20px;text-decoration:none"  alt="<?php echo $result['v_cap'];?>">
                 <img src="./images/video_file_icon.jpg" width="150" height="100" border="0"  title="<?php echo $result['v_cap'];?>"/></a>
			               
                 <?php
				 
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
  </td></tr>
  </table>
<?php }
else
{?>
  <table width="100%" style="margin:0px; border:0px; padding:0px">
			<tbody><tr>
			<td width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
                            <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$pid." and status=1 order by albumid desc";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				$album_id=$result[albumid];
				$pdSQL_r = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
			 $pdSQLResult_r = mysql_query($pdSQL_r);
			if(mysql_num_rows($pdSQLResult_r) >= 1)
			{
			
				$result_r = mysql_fetch_array($pdSQLResult_r);
				$al_file_r=$result_r['al_file'];
			}
			else
			{
			$al_file_r="no_image.jpg";
			}
				
				?>
				
            <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
 <!--    <a  href="javascript:void(null);" onclick="window.open('sp_photo.php?album_id=<?php echo $result['albumid'];?>', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none" >-->
	    <a  href="analysis.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url."thumb/".$al_file_r; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?>				     </div>
	</div>
	</li>
	</div>

            <?php 
			$cm++;
			
			}}?>
        </td>
		</tr>
		</tbody>
		</table>
	<?php }?>
  </td></tr>
  
  </table></div></td></tr>
  
  </table>
</div>
  <?php include ("includes/footer.php"); ?>

</body>
</html>
<?php
	$objDb  -> close( );
?>
