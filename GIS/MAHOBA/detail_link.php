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

	$SQLbf = "Select * from dgps_survey_data where unique_id='$unique_id'";
	//echo $SQLbf;
	$reportresultbf= mysql_query($SQLbf);
	$reportdatabf = mysql_fetch_array($reportresultbf);
	$latbf = $reportdatabf['latitude'];  
   $lngbf = $reportdatabf['longitude'];   
   

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

<!--<script src="lightbox/js/lightbox.min.js"></script>-->
<link rel="stylesheet" href="../magnific-popup/magnific-popup.css">

<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Magnific Popup core JS file -->

<!--  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
-->  

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
<script>
function doToggle(ele){ 

	var obj = document.getElementById(ele);
	
	if(obj){
		if(obj.style.display == "none"){
			obj.style.display = "";
		}
		else{
			obj.style.display = "none";
		}
	}
}

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

	function doFilterImage(oid) {
			
	
	var item_date=document.getElementById('item_date').value
if(item_date!=0)
{
	
			var strURL="date_wise_image.php?item_date="+item_date+"&oid="+oid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
													
							document.getElementById('date_wise_image').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		 
		  document.getElementById("date_wise_image").style.display = 'block';
		  document.getElementById("all_images").style.display = 'none';
		  document.getElementById("video1").style.display = 'none';
		  document.getElementById("more").style.display = 'none';
		  
}
else
{
	 document.getElementById("date_wise_image").style.display = 'none';
	document.getElementById("all_images").style.display = 'block';
	document.getElementById("video1").style.display = 'block';
	  document.getElementById("more").style.display = 'block';
}
	}


</script>
<script>
$(document).ready(function() {

	$('.image-popup-vertical-fit').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-img-mobile',
		image: {
			verticalFit: true
		}
		
	});

	$('.image-popup-fit-width').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		image: {
			verticalFit: false
		}
	});

	$('.image-popup-no-margins').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
	});

});

</script>
  </head>
  <body onload="init();">
<?php  include 'includes/headerMainHome.php'; ?>
<div id="navcontainer" class="menu"  style="  width:1348px; margin-top:3px;float: inherit;">
 <span style="float:left; font-size:20px; font-weight:bold; padding-top:4px;color:white; padding-left:6px;"><?php echo GIS_DASHBOARD?></span>
 <span style="float:right; font-size:12px; padding-top:5px; padding-right:3px;color:white; text-decoration:none"><a href="../index.php"><img  src="../images/home.png"/></a></span>
</div>

<style>
.sidenav {
  height: 20%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color:#FFF;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
  background-color: gainsboro;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
<div style="background-color:#046b99; z-index:1; position: absolute; left: 1%; top: 32%; width: 3.5%; transform: translate(0px, 0px);
border-radius: 10px; height:50px">
<span style="cursor:pointer;margin-left:6px;line-height: 3em;" onclick="openNav()"><img src="../images/map_layers.jpg" alt="<?php echo THEMATIC_LAYERS?>" title="<?php echo THEMATIC_LAYERS?>" /></span>&nbsp;&nbsp;
</div>


<script>
function opensearch_km() {
  document.getElementById("search_km").style.width = "30%";
  document.getElementById("search").style.width = "0";
  document.getElementById("mySidenav").style.width = "0";
}

function closesearch_km() {
  document.getElementById("search_km").style.width = "0";
}

function closesearch_km() {
  document.getElementById("search_km").style.width = "0";
}
function opensearch() {
  document.getElementById("search").style.width = "24%";
document.getElementById("mySidenav").style.width = "0";  
  document.getElementById("search_km").style.width = "0";
}

function closesearch() {
  document.getElementById("search").style.width = "0";
}
function openNav() {
  document.getElementById("mySidenav").style.width = "22%";
  document.getElementById("search").style.width = "0";
    document.getElementById("search_km").style.width = "0";

}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

function range_kmpost(lang) {
var channel_id = document.getElementById('channel_id').value;		
var from_kmpost = parseInt(document.getElementById('from_kmpost').value);	
var to_kmpost = parseInt(document.getElementById('to_kmpost').value);
var queryString = "?channel_id=" + channel_id + "&from_kmpost=" + from_kmpost + "&to_kmpost=" + to_kmpost+ "&language=" + lang;
window.open ("qrdash-home-range.php" + queryString, '_blank');
 //window.open('qrdash-home-km.php?from_kmpost='+from_kmpost+'to='+to_kmpost, '_blank');	
}


	
</script>



<div id="mySidenav" class="sidenav" style="background-color:#FAFAFA; margin-top:130px; margin-left:65px; height:410px;
border-radius: 10px;">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="padding: 0px 0px 0px 0px;"><img title="<?php echo CLOSE?>" src="../images/close.png" style=" background-color:#CCC" />
</a>
<div class="a" style="background-color:; height:50px; width:200px;margin-top: -50px; margin-left:22px;">
<input type="button" value="<?php echo CHECK_ALL?>" onclick="check();">
<input type="button" value="<?php echo UNCHECK_ALL?>" onclick="uncheck();">
</div>
<br/>
<div id="maincol" style="margin-left:13px;">
<div id="legends" style="float:left;font-size:14px; color:#006; margin-left:; margin-top:-30px"><strong style="margin-top:10px">Kainar
</strong>
<?php $kmlsql="select * from kmls_add where type = 2";
$kmlresult=mysql_query($kmlsql);
$total=mysql_num_rows($kmlresult);

$i=0;
$checked="";
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$color_lp="#".$kmldata['color_lp'];
	//$color_poly="border-color:".$color_lp;
	$attribute_type=$kmldata['attribute_type'];
	$kmlid_1=$kmldata['kid'];
	$name = $kmldata['name'];
	
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	if($attribute_type=="point")
	{
			$checked= "";
		
	$image_name="GMC/kml/".$kmldata['image_name'];
	$image_name_point="<img src=".$_CONFIG['site_url'].$image_name." alt=".$justname." height='22px' width='22px' />";
	
	}
	else if($attribute_type=="line")
	{
		
	$checked='checked="checked"';
	$image_name_point='<span><svg style="margin-left:6px;" height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
		
			$checked="";
		
	
	$image_name_point='<span><svg style="margin-left:6px;" width="10" height="10">
<rect width="10" height="10" style=" fill:'.$color_lp.'";stroke-width:3;fill-opacity:0.1;stroke-opacity:0.9;stroke:'.$color_1p.'" />
</svg></span>';
	
	}
	
	$i=$i+1;
	if($i==1)
	{
		?>
<table align="center" style="font-size:11px;border: 2px solid rgba(0,0,0,0.2);" width="" >        
    <tr>

	<td width="11%">	<h3 style="font-size: 11px; font-weight: bold;"><?php echo SURVEY_LAYERS?></h3>
    
<input type="checkbox" id="<?php echo $justname."toggle"?>"  <?php echo $checked;?> />
<label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
	else if ($i%2!=0 && $i!=1)
	{
		?>
        <tr>        
		<td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> />
        <label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
    else if($i%2==0)
	{
		?>
        <tr>
        <td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> />
        <label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
}
?>





<?php $kmlsql="select * from kmls_add where type = 1";
$kmlresult=mysql_query($kmlsql);
$total=mysql_num_rows($kmlresult);

$i=0;
$checked="";
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$color_lp="#".$kmldata['color_lp'];
	//$color_poly="border-color:".$color_lp;
	$attribute_type=$kmldata['attribute_type'];
	$kmlid_1=$kmldata['kid'];
	$name = $kmldata['name'];
	
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	if($attribute_type=="point")
	{
			$checked= "";
		
	$image_name="GMC/kml/".$kmldata['image_name'];
	$image_name_point="<img src=".$_CONFIG['site_url'].$image_name." alt=".$justname." height='22px' width='22px' />";
	
	}
	else if($attribute_type=="line")
	{
		
	$checked='checked="checked"';
	$image_name_point='<span><svg style="margin-left:6px;" height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
			$checked="";
		
	
	$image_name_point='<span><svg style="margin-left:6px;" width="10" height="10">
  <rect width="10" height="10" style="fill:'.$color_lp.'";stroke-width:3;fill-opacity:0.1;stroke-opacity:0.9;stroke:'.$color_1p.'" />
</svg></span>';
	
	}
	
	$i=$i+1;
	if($i==1)
	{
		?>
    <tr>

	<td width="11%">	<h3 style="font-size: 11px; font-weight: bold;"><?php echo DESIGN_LAYERS?></h3>
    
<input type="checkbox" id="<?php echo $justname."toggle"?>"  <?php echo $checked;?> />
<label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
	else if ($i%2!=0 && $i!=1)
	{
		?>
        <tr>        
		<td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> />
        <label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
    else if($i%2==0)
	{
		?>
        <tr>
        <td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> />
        <label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
}
?>
</table>



<div id="legends" style="font-size:14px; color:#006;"><strong style="margin-top:10px">Sarybulak
</strong>
<?php $kmlsql="select * from kmls_add where type = 4";
$kmlresult=mysql_query($kmlsql);
$total=mysql_num_rows($kmlresult);

$i=0;
$checked="";
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$color_lp="#".$kmldata['color_lp'];
	//$color_poly="border-color:".$color_lp;
	$attribute_type=$kmldata['attribute_type'];
	$kmlid_1=$kmldata['kid'];
	$name = $kmldata['name'];
	
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	if($attribute_type=="point")
	{
			$checked= "";
		
	$image_name="GMC/kml/".$kmldata['image_name'];
	$image_name_point="<img src=".$_CONFIG['site_url'].$image_name." alt=".$justname." height='22px' width='22px' />";
	
	}
	else if($attribute_type=="line")
	{
		
	$checked='checked="checked"';
	$image_name_point='<span><svg style="margin-left:6px;" height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
			$checked="";
		
	
	$image_name_point='<span><svg style="margin-left:6px;" width="10" height="10">
<rect width="10" height="10" style=" fill:'.$color_lp.'";stroke-width:3;fill-opacity:0.1;stroke-opacity:0.9;stroke:'.$color_1p.'" />
</svg></span>';
	
	}
	
	$i=$i+1;
	if($i==1)
	{
		?>
<table align="center" style="font-size:11px;border: 2px solid rgba(0,0,0,0.2);" width="" >        
    <tr>

	<td width="11%">	<h3 style="font-size: 11px; font-weight: bold;"><?php echo SURVEY_LAYERS?></h3>
    
<input type="checkbox" id="<?php echo $justname."toggle"?>"  <?php echo $checked;?> />
<label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
	else if ($i%2!=0 && $i!=1)
	{
		?>
        <tr>        
		<td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> />
        <label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
    else if($i%2==0)
	{
		?>
        <tr>
        <td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> />
        <label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
}
?>





<?php $kmlsql="select * from kmls_add where type = 3";
$kmlresult=mysql_query($kmlsql);
$total=mysql_num_rows($kmlresult);

$i=0;
$checked="";
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$color_lp="#".$kmldata['color_lp'];
	//$color_poly="border-color:".$color_lp;
	$attribute_type=$kmldata['attribute_type'];
	$kmlid_1=$kmldata['kid'];
	$name = $kmldata['name'];
	
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	if($attribute_type=="point")
	{
			$checked= "";
		
	$image_name="GMC/kml/".$kmldata['image_name'];
	$image_name_point="<img src=".$_CONFIG['site_url'].$image_name." alt=".$justname." height='22px' width='22px' />";
	
	}
	else if($attribute_type=="line")
	{
		
	$checked='checked="checked"';
	$image_name_point='<span><svg style="margin-left:6px;" height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
			$checked="";
		
	
	$image_name_point='<span><svg style="margin-left:6px;" width="10" height="10">
  <rect width="10" height="10" style="fill:'.$color_lp.'";stroke-width:3;fill-opacity:0.1;stroke-opacity:0.9;stroke:'.$color_1p.'" />
</svg></span>';
	
	}
	
	$i=$i+1;
	if($i==1)
	{
		?>
    <tr>

	<td width="11%">	<h3 style="font-size: 11px; font-weight: bold;"><?php echo DESIGN_LAYERS?></h3>
    
<input type="checkbox" id="<?php echo $justname."toggle"?>"  <?php echo $checked;?> />
<label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
	else if ($i%2!=0 && $i!=1)
	{
		?>
        <tr>        
		<td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> />
        <label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
    else if($i%2==0)
	{
		?>
        <tr>
        <td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> />
        <label for="<?php echo $justname."toggle"?>"><?php echo $image_name_point;?></label><?php echo $name;?></td></tr>
        <?php
	}
}
?>
</table>
</div>


</div>
</div>
</div>


<script>
function check()
{
 var check=document.getElementsByTagName('input');
 for(var i=0;i<check.length;i++)
 {
  if(check[i].type=='checkbox')
  {
   check[i].checked=true;
  }
 }
<?php $kmlsql="select * from kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	
	var <?php echo $justname."Visible";?>=true;

 <?php
	
}
 ?>  
	<?php $kmlsqlp="select * from kmls_add";
$kmlresultp=mysql_query($kmlsqlp);
while($kmldatap=mysql_fetch_array($kmlresultp))
{
	$file_name=$kmldatap['file_name'];
	$kmlid=$kmldatap['kid'];
	$kid=$kmlid-1;
		?>
	parser.hideDocument(parser.docs[<?php echo $kid;?>]);

 <?php
	}
 ?>  
	<?php $kmlsql="select * from kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	$("#<?php echo $justname."toggle"; ?>").on("click", function(e) {
		if (<?php echo $justname."Visible"; ?>) {
			parser.showDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = false;
		} else {
			parser.hideDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = true;
		}		
	});

 <?php
}
 ?> 

}

function uncheck()
{
 var uncheck=document.getElementsByTagName('input');
 for(var i=0;i<uncheck.length;i++)
 {
  if(uncheck[i].type=='checkbox')
  {
   uncheck[i].checked=false;
  }
 }
 
<?php $kmlsql="select * from kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	
	var <?php echo $justname."Visible";?>=true;

 <?php
	
}
 ?>  
	<?php $kmlsqlp="select * from kmls_add";
$kmlresultp=mysql_query($kmlsqlp);
while($kmldatap=mysql_fetch_array($kmlresultp))
{
	$file_name=$kmldatap['file_name'];
	$kmlid=$kmldatap['kid'];
	$kid=$kmlid-1;
		?>
	parser.showDocument(parser.docs[<?php echo $kid;?>]);

 <?php
	}
 ?>  
	<?php $kmlsql="select * from kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	$("#<?php echo $justname."toggle"; ?>").on("click", function(e) {
		if (<?php echo $justname."Visible"; ?>) {
			parser.hideDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = false;
		} else {
			parser.showDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = true;
		}		
	});

 <?php
}
 ?> 
 
}
</script>








  
<?php include("includes/maps_single.php"); ?>

<div style="width:1050px; min-height:750px; background-color: #F6F6F6; margin-top:10px; margin-left:150px">
<div align="center" style="font-size:22px; background-color:#9BAFD5 "><strong><?php echo DETAILS;?></strong></div>
<div style="float:left; width:500px;margin-top:20px; background-color:">
<div  style="background-color:; min-height:150px; width:480px; margin-left:10px">
<table border="1">
<?php if(($_SESSION['ne_gmcentry']== 1) || ($_SESSION['ne_gmcadm']== 1)){
	
?>
    <tr><td colspan="2" style="text-align:left;background-color:#06C; color:#FFF; font-weight:bold; font-size:20px; padding-left:5px"><?php echo "Document Summary"?>
   
     <button style="float:right" class="SubmitButton"><a href="add_report.php?unique_id=<?php echo $unique_id ?>" target="_blank"><?php echo "Add Report"?></a></button>
     </td>

</tr>
    <?php
}
else
{
	?>
    <tr><td colspan="2" style="text-align:center;background-color:#06C; color:#FFF; font-weight:bold; font-size:20px;"><?php echo "Document Summary"?></td>

</tr>
    <?php
}?>
<tr style="background-color: #C0C0C0;"><td  style="text-align:center; font-weight:bold; width:170px; font-size:14px"><?php echo "File Type"?></td><td  style="text-align:center; font-weight:bold; font-size:14px"><?php echo "File Name"?></td></tr>
<?php
$query4 = "SELECT * FROM dgps_survey_data where unique_id='$unique_id'";
	 $result4=mysql_query($query4);
	 mysql_num_rows($result4);
 if (mysql_num_rows($result4) > 0) {
while($row4 = mysql_fetch_assoc($result4))
{
 $file=$row4['item_name'];
		$extension = explode(".", $file);
		$extension[1];
		if($extension[1] == "jpg")
		{

 }
if($extension[1] == "xls" || $extension[1] == "xlsx")
		{ ?>
<tr><td  style="text-align:left; padding-left:5px; font-size:14px"><?php echo "KM Excel File";?></td><td  style="text-align:left; padding-left:5px;font-size:14px">
<a href="excel_files/<?php echo $file;?>"  target="_blank" > 
<?php	echo $file; ?>

			<?php /*?><?php $imageabc = file_get_contents('E:/dataserver/nha_gis/geo_photos/'.$row4['item_name']);
		 $image_codes = base64_encode($imageabc);
	 <?php */?>
        
<?php } 
}
 }
?>
</a>
</td></tr>
</table>
</div>       


<?php
   $query = "SELECT * FROM dgps_survey_data where unique_id='$unique_id'";
  
$result=mysql_query($query);
 if (mysql_num_rows($result) > 0) {
$row = mysql_fetch_assoc($result);

 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$i++;
 ?>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/detail.css">
<div style="background-color:; width:480px;  margin-top:20px; margin-left:10px; float:left">
<table border="1">
<tr><td colspan="2" style="text-align:left;background-color:#06C; color:#FFF; font-weight:bold; font-size:20px; padding-left:5px"><?php echo "Attributes of"." ".$row['shape'];?></td></tr>

<tr style="background-color: #C0C0C0;"><td  style="text-align:center; font-weight:bold; width:; font-size:14px"><?php echo "Attributes"?></td><td  style="text-align:center; font-weight:bold; font-size:14px"><?php echo "Values"?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Unique ID</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['unique_id']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Layer Name</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['layer']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Shape</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['shape']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Gauge</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['gauge']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Shape Length</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['shape_length']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Shape Area</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['shape_area']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Railway</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['railway']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Usage</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['usage']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Highway</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['highway']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Electrified</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['electrified']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Block Code</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['block_code']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">District</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['district']; ?></td></tr>

<tr><td style="text-align:left;padding-left:5px; font-size:14px">Sub District</td>
<td style="text-align:left;padding-left:5px; font-size:14px"><?php echo $row['sub_district']; ?></td></tr>

<?php
 }?>
</table>
</div>
</div>


<script type="text/javascript">
function opendiv() {
  document.getElementById("mydiv").style.display = "block";
  
}
function excelFunction() {
	
 window.open('http://localhost/GeoDashboard/Excel_files/', '_blank');
}

</script>


<style>
/*Eliminates padding, centers the thumbnail */

/* Styles the thumbnail */

a.lightbox img {
height: 150px;
border: 3px solid white;
box-shadow: 0px 0px 8px rgba(0,0,0,.3);
margin: 0px 20px 20px 0px;
}

/* Styles the lightbox, removes it from sight and adds the fade-in transition */

.lightbox-target {
position: fixed;
top: -100%;
width: 100%;
background: rgba(0,0,0,.7);
width: 100%;
opacity: 0;
-webkit-transition: opacity .5s ease-in-out;
-moz-transition: opacity .5s ease-in-out;
-o-transition: opacity .5s ease-in-out;
transition: opacity .5s ease-in-out;
overflow: hidden;
}

/* Styles the lightbox image, centers it vertically and horizontally, adds the zoom-in transition and makes it responsive using a combination of margin and absolute positioning */

.lightbox-target img {
margin: auto;
position: absolute;
top: 0;
left:0;
right:0;
bottom: 0;
max-height: 0%;
max-width: 0%;
border: 3px solid white;
box-shadow: 0px 0px 8px rgba(0,0,0,.3);
box-sizing: border-box;
-webkit-transition: .5s ease-in-out;
-moz-transition: .5s ease-in-out;
-o-transition: .5s ease-in-out;
transition: .5s ease-in-out;
}

/* Styles the close link, adds the slide down transition */

a.lightbox-close {
display: block;
width:40px;
height:40px;
box-sizing: border-box;
background: white;
color: black;
text-decoration: none;
position: absolute;
top: -80px;
right: 0;
-webkit-transition: .5s ease-in-out;
-moz-transition: .5s ease-in-out;
-o-transition: .5s ease-in-out;
transition: .5s ease-in-out;
}

/* Provides part of the "X" to eliminate an image from the close link */

a.lightbox-close:before {
content: "";
display: block;
height: 30px;
width: 1px;
background: black;
position: absolute;
left: 26px;
top:10px;
-webkit-transform:rotate(45deg);
-moz-transform:rotate(45deg);
-o-transform:rotate(45deg);
transform:rotate(45deg);
}

/* Provides part of the "X" to eliminate an image from the close link */

a.lightbox-close:after {
content: "";
display: block;
height: 30px;
width: 1px;
background: black;
position: absolute;
left: 26px;
top:10px;
-webkit-transform:rotate(-45deg);
-moz-transform:rotate(-45deg);
-o-transform:rotate(-45deg);
transform:rotate(-45deg);
}

/* Uses the :target pseudo-class to perform the animations upon clicking the .lightbox-target anchor */

.lightbox-target:target {
opacity: 1;
top: 0;
bottom: 0;
}

.lightbox-target:target img {
max-height: 100%;
max-width: 100%;
}

.lightbox-target:target a.lightbox-close {
top: 0px;
}
/* padding-bottom and top for image */
.mfp-no-margins img.mfp-img {
	padding: 0;
}
/* position of shadow behind the image */
.mfp-no-margins .mfp-figure:after {
	top: 0;
	bottom: 0;
}
/* padding for main container */
.mfp-no-margins .mfp-container {
	padding: 0;
}


/* 

for zoom animation 
uncomment this part if you haven't added this code anywhere else

*/


.mfp-with-zoom .mfp-container,
.mfp-with-zoom.mfp-bg {
	opacity: 0;
	-webkit-backface-visibility: hidden;
	-webkit-transition: all 0.3s ease-out; 
	-moz-transition: all 0.3s ease-out; 
	-o-transition: all 0.3s ease-out; 
	transition: all 0.3s ease-out;
}

.mfp-with-zoom.mfp-ready .mfp-container {
		opacity: 1;
}
.mfp-with-zoom.mfp-ready.mfp-bg {
		opacity: 0.8;
}

.mfp-with-zoom.mfp-removing .mfp-container, 
.mfp-with-zoom.mfp-removing.mfp-bg {
	opacity: 0;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<body>
<script type="text/javascript">
$(document).ready(function () {
    $('.gallery li:lt(2)').show();
    $('.less').hide();
    var items =  9;
    var shown =  2;
    $('.more').click(function () {
        $('.less').show();
        shown = $('.gallery li:visible').length+2;
        if(shown< items) {
          $('.gallery li:lt('+shown+')').show(300);
        } else {
          $('.gallery li:lt('+items+')').show(300);
          $('.more').hide();
        }
    });
    $('.less').click(function () {
        $('.gallery li').not(':lt(3)').hide(300);
        $('.more').show();
        $('.less').hide();
    });
});
  </script>
<style>
.more, .less {
  background-color: #000;
  clear: both;
  color: #fff;
  cursor: pointer;
  display: block;
  font-size: 14px;
  margin-top: 6px;
  padding: ;
  text-align: center;
	text-transform: uppercase;
  width: 150px;
}
</style>
  <?php if(($_SESSION['ne_gmcentry']== 1) || ($_SESSION['ne_gmcadm']== 1)){
?>
<div style="background-color:#06C; width:500px; margin-top:20px;  margin-left:20px; float:left; color:white; font-weight:bold; font-size:20px; padding-left:5px"><?php echo IMAGVID?>

<button style="float:right; margin-right:10px"  class="SubmitButton"><a href="add_image.php?unique_id=<?php echo $unique_id?>" target="_blank"><?php echo ADD_IMAGVID?></a></button>
</div>
<?php
}
else
{
	?>
    <div style="background-color:#06C; width:500px; margin-top:20px;  margin-left:20px; float:left; color:white; font-weight:bold; font-size:20px; padding-left:5px"><?php echo IMAGVID?></div>
    <?php
}
?>
<div style="background-color:; width:500px; margin-top:20px;  margin-left:20px; float:left;">
<form action="" target="_self" method="post"  enctype="multipart/form-data">
<?php echo DATE_WISE_ANALYSIS?>: <select id="item_date" name="item_date" style="width:170px">
     <option value="0"><?php echo ALL_IMAGES?></option>
     <?php 
			$pdSQLdd = "SELECT DISTINCT(item_date) FROM  attributes_gallery  WHERE oid=".$unique_id." and component_name='$componentName' and item_date !='0000-00-00' order by item_date  ASC";
		
  		
						 $pdSQLResultdd = mysql_query($pdSQLdd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultdd)>=1)
							  {
							  while($pdDatadd = mysql_fetch_array($pdSQLResultdd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatadd["item_date"];?>" <?php if($item_date==$pdDatadd["item_date"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatadd["item_date"]));?></option>
   <?php } 
   }?>
  </select>
  <input type="button"  onclick="doFilterImage(<?php echo $unique_id;?>);" class="SubmitButton" name="Submit" id="Submit" value="<?php echo VIEW ?>" />
   
  </form>
 
  <br/>
  <ul class="gallery">

  <div id="date_wise_image" style="display:none">
  </div>
<div id="all_images" style="display:block">
    <?php 
	$query4 = "SELECT * FROM attributes_gallery where oid = '$unique_id' and item_type=1 and component_name='$componentName' limit 0,8";
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
		//$extension[1];
		if($extension[1] == "jpg" || $extension[1] == "JPG" || $extension[1] == "png")
		{
		

	 
		?>
        				<div class="new_div" style="float:left;">
			<li class="dfwp-item" style="float:left">
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
	<img src="<?php echo SITE_URL; ?>idip_photos/<?php echo $row4['item_name']; ?>" width="250" height="180px"/>
</a>&nbsp;

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
        <div class="new_div" style="float:left">
			<li  class="dfwp-item" style="float:left">
	<div  style="float:left;width:210px;margin-right:0px;">
        
	<img style="width:; height:" src="../images/no_image_1.jpg" width="200" height="180px" />

</div>
	</li>
	</div>
        
<?php
	 
	 }
	?>
  </div>
</ul>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<body>
<script type="text/javascript">
function closeimagediv() {
	document.getElementById('image_div').style.display = 'none';
document.getElementById('more').style.display = 'block';	
};  
function myFunction() {
  var x = document.getElementById("image_div");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
	document.getElementById('more').style.display = 'none';
}
</script>
<style>
.more, .less {
	
  background-color: #000;
  clear: both;
  color: #fff;
  cursor: pointer;
  display: block;
  font-size: 14px;
  margin-top: 6px;
  padding: ;
  text-align: center;
  text-transform: uppercase;
  width: 150px;
}
</style>

<div id="image_div" style="float:right; display:none">
    <?php 
	$query4 = "SELECT * FROM attributes_gallery where oid = '$unique_id' and item_type=1 and component_name='$componentName' limit 8,20";
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
        				<div class="new_div" style="float:left;">
			<li class="dfwp-item" style="float:left">
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
	<img src="<?php echo SITE_URL; ?>idip_photos/<?php echo $row4['item_name']; ?>" width="250" height="180px"/>
</a>&nbsp;

</div>
	</li>
	</div>

    <?php
		
	}
		}
	
	}	
 }
?>

<span class="less"  id="less" style="cursor:pointer;margin-left:" onclick="closeimagediv()"><?php echo SHOW_LESS?></span>&nbsp;&nbsp;
</div>

<span class="more" id="more" style="cursor:pointer;" onclick="myFunction()"><?php echo SHOW_MORE?></span>&nbsp;&nbsp;


    <?php 
	$query4 = "SELECT * FROM attributes_gallery where oid = '$unique_id' and item_type='3' and component_name='$componentName'";
	//echo $query4;
	 $result4=mysql_query($query4);
	 mysql_num_rows($result4);
 if (mysql_num_rows($result4) > 0) {
while($row4 = mysql_fetch_assoc($result4))
{
		
	
		$extension = explode(".", $row4['item_name']);
		$extension[1];
		if($extension[1] == "mp4")
		{
	
		?>
        <div class="video" id="video1">
        <video width="500" height="340" controls>
 <source src="<?php echo SITE_URL; ?>videos/<?php echo $row4['item_name']; ?>" type="video/mp4">
  Sorry, your browser doesn't support the video element.
</video>
</div>

        <?php
		}
	
	}	
 }

	?>
  
  </div>
   <script src="../magnific-popup/jquery.magnific-popup.js"></script>
   </div>
  </body>
  
</html>