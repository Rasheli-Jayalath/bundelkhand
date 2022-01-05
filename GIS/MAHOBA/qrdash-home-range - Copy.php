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

/*$lng = $_REQUEST['lngi'];
$d_in_km = $_REQUEST['dis_km'];*/

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

<script language="javascript" type="text/javascript">
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

	function getcomponent(projectid) {
			
		if (projectid!=0) {
			var strURL="findcomponent.php?project="+projectid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('componentdiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} else {
			document.getElementById('componentid').value = 0;
			document.getElementById('componentid').disabled = true;
			document.getElementById('activitytypeid').value = 0;
			document.getElementById('activitytypeid').disabled = true;
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;	
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;	
		}
		   document.getElementById('componentid').value = 0;
			document.getElementById('componentid').disabled = true;
			document.getElementById('activitytypeid').value = 0;
			document.getElementById('activitytypeid').disabled = true;
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;	
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;	
	}

	function getactivitytype(componentid) {		
		if (componentid!=0) {
			var strURL="findactivitytype.php?component="+componentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('activitytypediv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:4\n " + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} else {
			document.getElementById('activitytypeid').value = 0;
			document.getElementById('activitytypeid').disabled = true;
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
		    document.getElementById('activitytypeid').value = 0;
			document.getElementById('activitytypeid').disabled = true;
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
	}
	
	function getsubcomponent(componentid) {
		
		if (componentid!=0) {
		var strURL="findsubcomponent.php?component="+componentid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('subcomponentdiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP: 5\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		else {
		    
			document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
		    document.getElementById('subcomponentid').value = 0;
			document.getElementById('subcomponentid').disabled = true;
		    document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;	
	}
	
	function getactivity(subcomponentid) {	
	
		if (subcomponentid!=0) {
			var strURL="findactivity.php?subcomponent="+subcomponentid;
			
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('activitydiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:6\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} else {
			document.getElementById('activityid').value = 0;
			document.getElementById('activityid').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
		document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;	
	}
	
	function getactivitytech(subcomponentid) {	
	
		if (subcomponentid!=0) {
			var strURL="findactivitytechnical.php?subcomponent="+subcomponentid;
			
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('activitydiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:6\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} else {
			document.getElementById('activityidt').value = 0;
			document.getElementById('activityidt').disabled = true;
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;		
		}
		document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;	
	}
	
	
	function getsubactivity(activityid) {
	
		if (activityid!=0) {
			var strURL="findsubactivity.php?activity="+activityid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('subactivitydiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} else {
			document.getElementById('subactivityid').value = 0;
			document.getElementById('subactivityid').disabled = true;				
		}
	}
	
	
function getbehav(behavid) {
		if (behavid!=0) {
			var strURL="findbehav.php?behav="+behavid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('behavdiv').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
	}
	function GetProgressQuantity(bid,activityid) 
	{
			
		if (bid!=0) {
			var strURL="findProgressQuantity.php?bid="+bid+"&activityid="+activityid;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('ProgressQunatity').innerHTML=req.responseText;						
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
	function frmValidate(frm){
	var flag = true;
	
	if(frm.bid.value == 0){
		msg = "Progress month is required";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
	}
	function frmValidate1(frm){
	var flag = true;
	var msg="";
	if(frm.projectid.value == "0"){
				msg = msg + "\r\n<?php echo "Please Select the Project";?>";
				
				flag = false;
			}
	if(flag == false){
				alert(msg);
				return false;
			}
	}
	
	function doToggle(ele){ 

	var obj = document.getElementById(ele);
	
	if(obj){
		if(obj.style.display == ""){
			obj.style.display = "none";
		}
		else{
			obj.style.display = "";
		}
	}
}

function doToggle1(ele){ 
	
	if (ele=="fun_1")
	{
	document.getElementById("fun_1").style.display = 'block';
	document.getElementById("nfun_1").style.display = 'none';
	document.getElementById("aban_1").style.display = 'none';
	
	}
	else if (ele=="nfun_1")
	{
	document.getElementById("fun_1").style.display = 'none';
	document.getElementById("nfun_1").style.display = 'block';
	document.getElementById("aban_1").style.display = 'none';
	}
	else if (ele=="aban_1")
	{
	document.getElementById("fun_1").style.display = 'none';
	document.getElementById("nfun_1").style.display = 'none';
	document.getElementById("aban_1").style.display = 'block';
	}
}
	
</script>
<style type="text/css">
 body { font: normal 10pt Helvetica, Arial; }
 #map { width: 100%; height: 350px; border: 0px; padding: 0px;  }
 </style>
 <script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
 <script src="../highcharts/js/highcharts.js"></script>
<script src="../highcharts/js/modules/exporting.js"></script>



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

    <script type="text/javascript">
    //<![CDATA[

    var tabLinks = new Array();
    var contentDivs = new Array();

    function init() {

      // Grab the tab links and content divs from the page
      var tabListItems = document.getElementById('tabs').childNodes;
      for ( var i = 0; i < tabListItems.length; i++ ) {
        if ( tabListItems[i].nodeName == "LI" ) {
          var tabLink = getFirstChildWithTagName( tabListItems[i], 'A' );
          var id = getHash( tabLink.getAttribute('href') );
          tabLinks[id] = tabLink;
          contentDivs[id] = document.getElementById( id );
        }
      }

      // Assign onclick events to the tab links, and
      // highlight the first tab
      var i = 0;

      for ( var id in tabLinks ) {
        tabLinks[id].onclick = showTab;
        tabLinks[id].onfocus = function() { this.blur() };
        if ( i == 0 ) tabLinks[id].className = 'selected';
        i++;
      }

      // Hide all content divs except the first
      var i = 0;

      for ( var id in contentDivs ) {
        if ( i != 0 ) contentDivs[id].className = 'tabContent hide';
        i++;
      }
    }

    function showTab() {
      var selectedId = getHash( this.getAttribute('href') );
	  

      // Highlight the selected tab, and dim all others.
      // Also show the selected content div, and hide all others.
      for ( var id in contentDivs ) {
        if ( id == selectedId ) {
          tabLinks[id].className = 'selected';
          contentDivs[id].className = 'tabContent';
        } else {
          tabLinks[id].className = '';
          contentDivs[id].className = 'tabContent hide';
        }
      }

      // Stop the browser following the link
      return false;
    }

    function getFirstChildWithTagName( element, tagName ) {
      for ( var i = 0; i < element.childNodes.length; i++ ) {
        if ( element.childNodes[i].nodeName == tagName ) return element.childNodes[i];
      }
    }

    function getHash( url ) {
	
      var hashPos = url.lastIndexOf ( '#' );
	  
	  
      return url.substring( hashPos + 1 );
    }

    //]]>
    </script>
	
<style type="text/css">
select option.red {
color: #76031B;

}
select option.green {
color:#006C00;

}
select option.blue {
color:#000055;

}
#mainTable table tr td a:hover
		{
		font-weight:bold;
		font-size:14px;
		
		
		}
.boxsize {
  width: 97.2%;
  height: 80px;  
  padding: 10px;
  border: 1px solid #006;
  background-color: #FAFAFA;
  border-radius:5px;
}
</style>
<style>
form ul { list-style-type: none; }

form ul li { display: inline-block }
</style>

  </head>
  <body onload="init();">
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
<div style=" background-color:#046b99; z-index: 1; position: absolute; left: 2%; top: 15%; width: 25%; transform: translate(0px, 0px);
border-radius: 10px; height:50px">
<h2 style="color:#FFF; font-size:18px; margin-top:1px; line-height:1.2em; letter-spacing:-1px; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif; margin: 5px 0px 15px 0px; clear: both; font-weight: lighter;">
<?php 
$from_kmpost = $_REQUEST['from_kmpost'];
$to_kmpost = $_REQUEST['to_kmpost'];
 $channel_id = $_REQUEST['channel_id'];
if(isset($from_kmpost) && $from_kmpost!="") 
{ if(isset($to_kmpost) && $to_kmpost!="" && isset($channel_id) ){
	
	?>
 <?php echo CHANNEL?>: <?php echo $channel_id;?><br/>
<?php echo CHAINAGE?>: <?php echo $from_kmpost." ".TO." ".$to_kmpost;  ?></h2>
    <?php
	 $cquery_1 = "SELECT * FROM dgps_survey_data WHERE  component_name='$componentName' and channel_id='".$channel_id."' and chainage_id BETWEEN ".$from_kmpost." AND ".$to_kmpost;
	//echo $cquery_1;
$cresult_1 = mysql_query($cquery_1);
$num=mysql_num_rows($cresult_1);

 $middle=round($num/2);
$cquery_r = "select latitude, longitude from dgps_survey_data where  component_name='$componentName' and channel_id='".$channel_id."' and chainage_id BETWEEN ".$from_kmpost." AND ".$to_kmpost." limit ".$middle.", 1";
//echo $cquery_r;
$cresult_r = mysql_query($cquery_r);
$cdata_r = mysql_fetch_array($cresult_r);
$dgps_lat=$cdata_r['latitude'];
$dgps_long=$cdata_r['longitude'];
}}
?>

<?php

?>

</div>

<div style=" background-color:#046b99; z-index:1; position: absolute; left: 2%; top: 25%; width: 25%; transform: translate(0px, 0px);
border-radius: 10px; height:50px">
<span style="cursor:pointer; margin-left:30px; margin-bottom:10px; line-height:3.5em;" onclick="openNav()">
<img title="Thematic Layers" src="../images/map_layers.jpg" />
</span>
<button onclick="close_div()">Statistics</button>

</div>

<div id="myDIV" style="z-index: 1; position: absolute; transform: translate(0px, 0px);border-radius: 10px; width:97.5%; padding-top:3px; padding-left:3px; font-size:14px; color:#006; width: 430px; margin-top: 210px; margin-left: 20px; height:350px">
<h2 style="color:#000; margin-left:0px"><?php echo "Statistics";?> </h2>
<table  cellpadding="5px" cellspacing="0px" width="96%" align="center"  id="tblList" style="border-left:1px #000000 solid;margin-left:5px;margin-right:5px; margin-top:-15px; height:300px; background-color:#F4F4F4;">
<tr bgcolor="000066" style="color:#FFF">
 
  <td  colspan="3" align="left" style="font-size:12px"><strong>
  <?php   
  		
		echo " ".SUMMARY."<br/> ".CHANNEL.": ".$channel_id." ".CHAINAGE." ".FROM." "; 
		echo $from_kmpost." ".TO." ".$to_kmpost;	?></strong>
  
  <a href="javascript:void(0)" class="closebtn" onclick="close_div()" style="float:right; margin-top:-10px; background-color: cadetblue;">
  <img src="../images/close.png" title="<?php echo CLOSE?>" /></a>
    </td>
</tr>

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
    <td style="text-align:center; color:#FFF ;height:1px; padding:20px; line-height:0.4em;"><a href="detail_all_range.php?channel_id=<?php echo $channel_id; ?>&from_kmpost=<?php echo $from_kmpost;?>&to_kmpost=<?php echo $to_kmpost?>&detail=<?php echo $row['code']; ?>&language=<?php echo $_SESSION['lang']; ?>" target="_blank" style="text-decoration:none"><?php echo $row['total']; ?></a></td>
</tr>

 <?php
  }
 }
 ?>
</table>
</div>
           </div>

         
  


  
</div>
<div id="mySidenav" class="sidenav" style="background-color:; margin-top: 120px; margin-left:28px; height:410px;border-radius: 10px;">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="padding: 0px 0px 0px 0px"><img src="../images/close.png" title="<?php echo CLOSE;?>" /></a>
  <div class="a" style="background-color:; height:50px; width:200px;margin-top: -50px; margin-left:22px;">
<input type="button" value="<?php echo CHECK_ALL;?>" onclick="check();">
<input type="button" value="<?php echo UNCHECK_ALL;?>" onclick="uncheck();">
</div>
<br/>

  <table cellpadding="0px" cellspacing="0px" align="center" width="70%"  > 
<tr>
<td>
<div id="maincol" style="margin-left:13px;">
<div id="legends" style="float:left;font-size:14px; color:#006; margin-left:-8px; margin-top:-30px">
<strong style="margin-top:10px">Kainar</strong>
<table align="center" style="font-size:11px;border: 2px solid rgba(0,0,0,0.2); background-clip: padding-box;" >
<?php $kmlsql="select * from kmls_add where type = 2 and component_name='$componentName'";
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
	$image_name_point='<span><svg height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
			$checked="";
		
	
	$image_name_point='<span><svg width="10" height="10">
  <rect width="10" height="10" style="fill:'.$color_lp.'";stroke-width:3;fill-opacity:0.1;stroke-opacity:0.9;stroke:'.$color_1p.'" />
</svg></span>';
	
	}
	
	$i=$i+1;
	if($i==1)
	{
		?>
<table align="center" style="font-size:11px;border: 2px solid rgba(0,0,0,0.2);" width="" >        
    <tr>

	<td width="11%">	<h3><?php echo SURVEY_LAYERS?></h3>
    
<input type="checkbox" id="<?php echo $justname."toggle"?>"  <?php echo $checked;?> /><label for="<?php echo $justname."toggle"?>">
<?php echo $name;?></label>:<?php echo $image_name_point;?></td></tr>
        <?php
	}
	else if ($i%2!=0 && $i!=1)
	{
		?>
        <tr>        
		<td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> /><label for="<?php echo $justname."toggle"?>"><?php echo $name;?></label>:<?php echo $image_name_point;?></td></tr>
        <?php
	}
    else if($i%2==0)
	{
		?>
        <tr>
        <td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> /><label for="<?php echo $justname."toggle"?>"><?php echo $name;?></label>:<?php echo $image_name_point;?></td></tr>
        <?php
	}
}
?>





<?php $kmlsql="select * from kmls_add where type = 1 and component_name='$componentName'";
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
	$image_name_point='<span><svg height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
			$checked="";
		
	
	$image_name_point='<span><svg width="10" height="10">
  <rect width="10" height="10" style="fill:'.$color_lp.'";stroke-width:3;fill-opacity:0.1;stroke-opacity:0.9;stroke:'.$color_1p.'" />
</svg></span>';
	
	}
	
	$i=$i+1;
	if($i==1)
	{
		?>
<table align="center" style="font-size:11px;border: 2px solid rgba(0,0,0,0.2);" width="" >        
    <tr>

	<td width="11%">	<h3><?php echo DESIGN_LAYERS?>:</h3>
    
<input type="checkbox" id="<?php echo $justname."toggle"?>"  <?php echo $checked;?> /><label for="<?php echo $justname."toggle"?>">
<?php echo $name;?></label>:<?php echo $image_name_point;?></td></tr>
        <?php
	}
	else if ($i%2!=0 && $i!=1)
	{
		?>
        <tr>        
		<td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> /><label for="<?php echo $justname."toggle"?>"><?php echo $name;?></label>:<?php echo $image_name_point;?></td></tr>
        <?php
	}
    else if($i%2==0)
	{
		?>
        <tr>
        <td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> /><label for="<?php echo $justname."toggle"?>"><?php echo $name;?></label>:<?php echo $image_name_point;?></td></tr>
        <?php
	}
}
?>



<?php $kmlsql="select * from kmls_add where type = 3 and component_name='$componentName'";
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
	$image_name_point='<span><svg height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
			$checked="";
		
	
	$image_name_point='<span><svg width="10" height="10">
  <rect width="10" height="10" style="fill:'.$color_lp.'";stroke-width:3;fill-opacity:0.1;stroke-opacity:0.9;stroke:'.$color_1p.'" />
</svg></span>';
	
	}
	
	$i=$i+1;
	if($i==1)
	{
		?>
<table align="center" style="font-size:11px;border: 2px solid rgba(0,0,0,0.2);" width="" >        
    <tr>

	<td width="11%">	<h3>Sarybulak Layers:</h3>
    
<input type="checkbox" id="<?php echo $justname."toggle"?>"  <?php echo $checked;?> /><label for="<?php echo $justname."toggle"?>">
<?php echo $name;?></label>:<?php echo $image_name_point;?></td></tr>
        <?php
	}
	else if ($i%2!=0 && $i!=1)
	{
		?>
        <tr>        
		<td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> /><label for="<?php echo $justname."toggle"?>"><?php echo $name;?></label>:<?php echo $image_name_point;?></td></tr>
        <?php
	}
    else if($i%2==0)
	{
		?>
        <tr>
        <td width="11%"><input type="checkbox" id="<?php echo $justname."toggle"?>" <?php echo $checked;?> />
        <label for="<?php echo $justname."toggle"?>"><?php echo $name;?></label>:<?php echo $image_name_point;?></td></tr>
        <?php
	}
}
?>

</table>		
</div>
</div>
</td>
</tr>
</table>
  
  
</div>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "21%";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
function close_div() {
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }

</script>
  
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
<?php $kmlsql="select * from kmls_add where component_name='$componentName'";
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
	<?php $kmlsqlp="select * from kmls_add where component_name='$componentName'";
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
	<?php $kmlsql="select * from kmls_add where component_name='$componentName'";
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
 
<?php $kmlsql="select * from kmls_add where component_name='$componentName'";
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
	<?php $kmlsqlp="select * from kmls_add where component_name='$componentName'";
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
	<?php $kmlsql="select * from kmls_add where component_name='$componentName'";
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


<?php include("includes/maps_kms.php"); ?>




<div id="buffer_detail"></div>



<div class="clear"></div>
	<?php //include("includes/footer.php");?>
	<div class="clear"></div>
</body>
</html>