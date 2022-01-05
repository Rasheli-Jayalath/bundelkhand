<?php
include("top.php");
?><?php 

if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}

$kmpost = $_REQUEST['kmpost'];
$from_kmpost = $_REQUEST['from_kmpost'];
$to_kmpost = $_REQUEST['to_kmpost'];
$channel_id = $_REQUEST['channel_id'];

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
 <span style="float:right; font-size:12px; padding-top:5px; padding-right:3px;color:white; text-decoration:none"><a href="index.php"><img  src="images/home.png"/></a></span>
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
	
 echo CHANNEL.": ".$channel_id."&nbsp;&nbsp;&nbsp;";
 echo CHAINAGE.": ".$from_kmpost. " ".TO." ".$to_kmpost;
 
 ?>
 </h2>        
		<form name="prd_frm" id="prd_frm" method="post" action="">
        <table  cellpadding="5px" cellspacing="0px"   width="96%" align="center"  id="tblList" style="border-left:1px #000000 solid;
        margin-left:30px;margin-right:5px; margin-top:35px">


<tr>

  <th style="height:1px" height="1px" ><?php echo DESCRIPTION?></th>
  <th style="height:1px" height="1px" ><?php echo CODE?></th>
  <th style="height:1px" height="1px"><?php echo TOTAL_POINTS?></th>
  </tr>
<?php 
$query = "SELECT code,  count(code) as total from dgps_survey_data where  component_name='$componentName' and channel_id='".$channel_id."' and chainage_id BETWEEN ".$from_kmpost. " AND ".$to_kmpost." group by code";
//echo $query;
$result=mysql_query($query);

 if (mysql_num_rows($result) > 0) {
	 $m=0;
 while($row = mysql_fetch_assoc($result)) 
 {
	 $dgps_code=$row['code'];
	
	$query_d = 'SELECT layer from dgps_survey_data where  component_name="'.$componentName.'" and code="'.$dgps_code.'" limit 0,1';
		$result_d=mysql_query($query_d);
		$row_d = mysql_fetch_assoc($result_d);
		$dgps_detail=$row_d['layer'];
		
	 $m=$m+1;
?>
<tr>
 	<td style="height:1px; padding:20px; line-height:0.4em;"><?php 
	echo $row_d['layer'];?></td>
    <td style="text-align:center; height:1px; padding:20px; line-height:0.4em;"><?php 
	echo $row['code'];?></td>
    <td style="text-align:center; color:#FFF ;height:1px; padding:20px; line-height:0.4em;"><a href="detail_all_range_pu.php?channel_id=<?php echo $channel_id; ?>&from_kmpost=<?php echo $from_kmpost;?>&to_kmpost=<?php echo $to_kmpost?>&detail=<?php echo $row['code']; ?>&language=<?php echo $_SESSION['lang']; ?>" target="_blank" style="text-decoration:none"><?php echo $row['total']; ?></a></td>
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