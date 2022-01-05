<?php 
include("top.php");
if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}
 
	  $label_f=$_REQUEST['label_f'];
	  //$detail=$_REQUEST['detail'];
	  $lat=$_REQUEST['latitude']; 
	  $lng=$_REQUEST['longitude'];
	  $code=$_REQUEST['code'];
	  $d_in_km=$_REQUEST['d_in_km'];
	  
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

    <title><?php echo GIS_DASHBOARD?></title>

    <link href="../css/CssAdminStyle.css" rel="stylesheet" type="text/css" />
<link href="../css/CssLogin2.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css_map/index.css"/>
<link rel="stylesheet" type="text/css" href="../css_map/map.css"/>
<script src="../lightbox/js/lightbox.min.js"></script>
  <link href="../lightbox/css/lightbox.css" rel="stylesheet" /> 
  <style type="text/css">
 body { font: normal 10pt Helvetica, Arial; }
 #map1 { width: 100%; height: 350px; border: 0px; padding: 0px;  }
 </style>
 <style type="text/css">
      body { font-size: 80%; font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif; }
      ul#tabs { list-style-type: none; margin: 30px 0 0 0; padding: 0 0 0.3em 0; }
      ul#tabs li { display: inline; }
      ul#tabs li a { color: #fff; background-color: #003399; border: 1px solid #c9c3ba; border-bottom: none; padding: 0.5em; text-decoration: none; }
      ul#tabs li a:hover { background-color: #8B8B8B;  color:white;}
      ul#tabs li a.selected { color: #fff; background-color: #003399; font-weight: bold; padding: 0.7em 0.3em 0.38em 0.3em; }
      div.tabContent { border: 1px solid #c9c3ba; padding: 0.5em; background-color: #f1f0ee; }
      div.tabContent.hide { display: none; }
	  
	  ul#gmaps { list-style-type: none;  padding: 0 0 0.3em 0; margin-left:110px; margin-bottom:5px; margin-top:20px; }
      ul#gmaps li { display: inline; }
     ul#gmaps li a { color: #fff; background-color: #003399; border: 1px solid #c9c3ba; border-bottom: none; padding: 0.5em; text-decoration: none; }
      ul#gmaps li a:hover {  background-color: #8B8B8B;  color:white; }
     ul#gmaps li a.selected { color: #fff; background-color: #003399; font-weight: bold; padding: 0.7em 0.3em 0.38em 0.3em; }
	  div.tabContent { border: 1px solid #c9c3ba; padding: 0.5em; background-color: #f1f0ee; }
      div.tabContent.hide { display: none; }
    </style>

 <script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
 <script src="../highcharts/js/highcharts.js"></script>
<script src="../highcharts/js/modules/exporting.js"></script>
  </head>
  <body onload="init();">
<?php  include 'includes/headerMainHome.php'; ?>
<div id="navcontainer" class="menu"  style="  width:1348px; margin-top:10px">
<span style="float:left; font-size:20px; font-weight:bold; padding-top:4px;color:white; padding-left:6px;"><?php echo GIS_DASHBOARD?></span>
 <span style="float:right; font-size:12px; padding-top:5px; padding-right:3px;color:white; text-decoration:none"><a href="../index.php"><img  src="../images/home.png"/></a></span>
</div>
   
    
  <div id="wrapperPRight">
		<div id="pageContentName"><?php echo DETAILS;?></div>
		
		<div class="clear"></div>
		<br />
		<?php echo $objCommon->displayMessage();?>
<div style=" background-color:#046b99;border-radius: 10px; height:50px; margin-left:10px">
<h2 style="color:#FFF; font-size:26px; margin-top:4px; line-height:1.5em; letter-spacing:-1px; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif; margin: 5px 0px 15px 0px; clear: both;">
<?php
	  //$kmpost=$_REQUEST['kmpost'];
	  $label_f=$_REQUEST['label_f'];
//$from_kmpost = $_REQUEST['from_kmpost'];
//$to_kmpost = $_REQUEST['to_kmpost'];
//$channel_id = $_REQUEST['channel_id'];
 echo $label_f."&nbsp;Details&nbsp;&nbsp;&nbsp;";
 //echo CHAINAGE.": ".$from_kmpost
 
 ?>
 </h2>        
		<form name="prd_frm" id="prd_frm" method="post" action="">
        <table  cellpadding="5px" cellspacing="0px"   width="96%" align="center"  id="tblList" style="border-left:1px #000000 solid;
        margin-left:30px;margin-right:5px; margin-top:35px">

<tr>
<th ><?php echo SrNO?></th>
  <th ><?php echo UNIQUE_ID?></th>
  <th ><?php echo LABEL?></th>
  <th ><?php echo DESCRIPTION?></th>
  <th ><?php echo LATITUDE?></th>
   <th ><?php echo LONGITUDE?></th>
  </tr>
 
<?php 
 $query = "SELECT code,latitude,longitude,label_f,oid,label from dgps_survey_data
Where component_name='$componentName' and (6371 * acos(cos(radians($lat) )* cos(radians(latitude))*cos(radians( longitude )-radians($lng))+ sin(radians($lat) )* sin(radians
( latitude ) ) ) ) < $d_in_km and label_f = '$label_f'";
//echo $query;
$result=mysql_query($query);

 if (mysql_num_rows($result) > 0) {
	 $m=0;
 while($row5 = mysql_fetch_assoc($result)) 
 {
	 $dgps_code=$row5['code'];
	 $dgps_detail=$row5['label_f'];
	 $dgps_data_id=$row5['oid'];	
		
	 $m=$m+1;
?>
<tr>
<td width="2%"><?php echo $m;?></td>
 	<td>
	
    <a href="detail_link.php?unique_id=<?php echo $dgps_data_id; ?>" style="text-decoration:none" target="_blank"><?php echo $dgps_data_id; ?></a>
	
	</td>
     <td><?php  echo $row5['label_f'];?></td>
     <td><?php  echo $row5['label'];?></td>    
    <td><?php echo 	$row5['latitude'];?></td>
     <td><?php  echo $row5['longitude'];?></td>
<?php /*?>     <td align="center">  
      <?php 
	$query4 = "SELECT * FROM attributes_gallery where oid='$dgps_data_id'";
	 $result4=mysql_query($query4);
	 mysql_num_rows($result4);
 if (mysql_num_rows($result4) > 0) {
while($row4 = mysql_fetch_assoc($result4))
{
	

	if($row4['item_type']=="1"){
		echo "Image";
	}
	else if($row4['item_type']=="3")
	{
		//$imageabc1 = file_get_contents('E:/dataserver/nha_gis/geo_photos/'.$row4['item_name']);
		 //$image_codes1 = base64_encode($imageabc1);
		
        
        
        
       echo "Video";
        
	}
	
	echo "<br>";
	
}
 }
	?></td>
<?php */?>   
</tr>

 <?php
		}
	   
 }
 ?>
</table>	
		
	  </form>
	</div>
  </body>
  
</html>