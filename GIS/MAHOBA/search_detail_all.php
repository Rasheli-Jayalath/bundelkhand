<?php
include("top.php");
if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}
// echo $component_name = $_REQUEST['component_name'];
 $component_name = $componentName;
echo $sub_component_name = $_REQUEST['sub_component_name'];
echo $ws_name = $_REQUEST['ws_name'];
  echo $road_type = $_REQUEST['road_type'];
   echo $attrib_type = $_REQUEST['attrib_type'];
   if($attrib_type==1)
{
	$dgps_attrib_type="Point";
}
else if($attrib_type==2)
{
	$dgps_attrib_type="Line";
}
if($attrib_type==3)
{
	$dgps_attrib_type="Polygon";
}
else
{
	$dgps_attrib_type="Point";
}
	  $kmpost=$_REQUEST['kmpost'];
	  $detail=$_REQUEST['detail'];
 

	
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
    <!-- This page is copyright Elated Communications Ltd. (www.elated.com) -->

    <title><?php echo GIS_DASHBOARD?></title

    ><link href="../css/CssAdminStyle.css" rel="stylesheet" type="text/css" />
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
<link rel="stylesheet" type="text/css" media="all" href="../datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="../datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="../datepickercode/jquery-ui.js"></script>
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
	

	
function getRoadname(tehsil) {

		    
			
						
			var strURL="sel_roadname.php?tehsil="+tehsil;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("roadname").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			
	}
	
	function getSubcomp(component_name) {
	
			var strURL="sel_subcomp.php?component_name="+component_name;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("subcomp").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			//getKM(road_name);
			//getKMto(road_name);
	}
	
	function getWorkstage(sub_component_name) {
	
			
			var strURL="sel_workstage.php?sub_component_name="+sub_component_name;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("workstage").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			
	}
	function getCattype(ws_name) {
	
		//alert(subcomp_name);					
			var strURL="sel_cattype.php?ws_name="+ws_name;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("cattype").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			getChannel(ws_name);
			getLayer(ws_name);
	}
	
	
	function getChannels(cat_name) {
		
					
			var strURL="sel_channel_direct.php?cat_name="+cat_name;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("channel").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			//getKM(road_name);
			getLayers_cat(cat_name);
	}
	
	function getChannel(ws_name) {
				
			var strURL="sel_channel.php?ws_name="+ws_name;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("channel").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			//getKM(road_name);
			//getKMto(road_name);
	}
	function getLayers(channel_id) {

							
			var strURL="sel_layer_direct.php?channel_id="+channel_id;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("layer").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			//getKM(road_name);
			//getKMto(road_name);
	}
	function getLayers_cat(cat_name) {
		
							
			var strURL="sel_layer_step.php?cat_name="+cat_name;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("layer").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			//getKM(road_name);
			//getKMto(road_name);
	}
	function getLayer(ws_name) {

						
			var strURL="sel_layer.php?ws_name="+ws_name;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("layer").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			//getKM(road_name);
			//getKMto(road_name);
	}
function advSearch(project_name,component_name,sub_component_name,ws_name,cat_name,channel_id,layer) {
	
 // if (str.length==0) { 
 //  document.getElementById("livesearch").innerHTML="";
 //   document.getElementById("livesearch").style.border="0px";
 //   return;
 // }

/*if(last_subcat=="" || last_subcat==0)
{
alert("Please select Category first");
document.getElementById("advsearch").style.display="none"; 
}
else
{*/
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	//document.getElementById("livesearch").style.display="none"; 
	document.getElementById("advsearch").style.display="block"; 
      document.getElementById("advsearch").innerHTML=xmlhttp1.responseText;
      document.getElementById("advsearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp1.open("GET","result_search.php?project_name="+project_name+"&component_name="+component_name+"&sub_component_name="+sub_component_name+"&ws_name="+ws_name+"&cat_name="+cat_name+"&channel_id="+channel_id+"&layer="+layer,true);
  xmlhttp1.send();
 //}
}

</script>
 <script>
  $(function() {
    $( "#lease_start" ).datepicker();
	
  });
  $(function() {
    $( "#lease_end" ).datepicker();
	
  });
   </script>
  </head>
  <body >
<?php  include 'includes/headerMainHome.php'; ?>
<div id="navcontainer" class="menu"  style="  width:1348px; margin-top:10px">
 <span style="float:left; font-size:20px; font-weight:bold; padding-top:4px;color:white; padding-left:6px;"><?php echo GIS_DASHBOARD?></span>
 <span style="float:right; font-size:12px; padding-top:5px; padding-right:3px;color:white; text-decoration:none"><a href="index.php"><img  src="images/home.png"/></a></span>
</div>
   
    
  <div id="wrapperPRight" style="min-height:290px">
 
		<?php echo $objCommon->displayMessage();?>
<div style=" background-color:#046b99;border-radius: 10px; height:50px; margin-left:10px">
<h3 style="color:#FFF; font-size:30px; margin-top:4px; line-height:1.5em; letter-spacing:-1px; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif; margin: 5px 0px 15px 0px; clear: both;">
<?php echo QUICK_SEARCH;?></h3>        
		<div id="advance_search" >
<form name="searchfrm" id="searchfrm" action="reports_search.php"  method="post"  style=" border:1px solid #FFFFFF" >
     <table width="50%"  align="center" cellpadding="1" cellspacing="1" > 
		<tr style="height:60px" >
  
	  <td   width="60%" class="label"  colspan="2"> <strong><?php echo PROJECT_NAME;?></strong>
		  <?php
		$cqueryp = "select distinct project_name from  dgps_survey_data";
		$cresultp = mysql_query($cqueryp);
		$cdatap = mysql_fetch_array($cresultp);
			$project_name=$cdatap['project_name'];
		
?>
      <input type="text" value="<?php echo $project_name?>" name="project_name"  id="project_name"  style="width:400px"/>
	 </td>
      <td   width="40%" class="label"  colspan="2" >  &nbsp;&nbsp;
	 </td>

</tr>
      <tr style="height:60px" >
	  
	  <td width="30%" class="label" > <strong><?php echo COMP_NAME;?>:</strong>
	   <div id="componentname"  >
        <input type="text" value="<?php echo $component_name?>" name="component_name"  id="component_name"   style="width:187px"/>
     <?php /*?> <select  name="component_name" id="component_name" onchange="getSubcomp(this.value)" style="width:200px" disabled="disabled" >
  		<option value="0" ><?php echo ALL_COMP;?> </option>
		 <?php
		$cquery = "select distinct component_name from  dgps_survey_data";
		$cresult = mysql_query($cquery);
		while ($cdata = mysql_fetch_array($cresult)) {
			$component_name1=$cdata['component_name'];
		
?>
		
       <option value="<?php echo $cdata['component_name']; ?>" <?php if ($component_name == $cdata['component_name']) {echo ' selected="selected"';}?>><?php echo $cdata['component_name']; ?></option>
		<?php
		}
		?>
</select><?php */?>
</div></td>
     
      <td width="30%" >
      <strong><?php echo SEL_SUBCOMP;?>:</strong>
      <div id="subcomp"  >
      <?php if($component_name!=""){?>
<select name="sub_component_name" id="sub_component_name" style="width:200px" onchange="getWorkstage(this.value)">
<option value="<?php echo $component_name; ?>_0"><?php echo ALL_SUBCOMP;?></option>
<?php
echo $tquery1 = "select distinct sub_component_name from  dgps_survey_data where component_name ='$component_name'";
$tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$sub_component_name=$tdata['sub_component_name'];


?>
<option value="<?php echo $component_name."_".$tdata['sub_component_name']; ?>"><?php echo $tdata['sub_component_name']; ?></option>
<?php

}
?>
</select>
<?php
	  }
	  else
	  {
		  ?>
<select name="sub_component_name" id="sub_component_name"  style="width:200px">
<option value=""><?php echo ALL_SUBCOMP;?></option>

</select>
<?php
	  }
	  ?>





		</div>
     
</td>
	  <td width="30%" >
      <strong><?php echo SEL_WS;?>:</strong>
      <div id="workstage"  >
      <?php if($sub_component_name!=""){?>
<select name="ws_name" id="ws_name" style="width:200px" onchange="getCattype(this.value)">
<option value=""><?php echo ALL_WSS;?></option>
<?php
$tquery1w = "select distinct ws_name from  dgps_survey_data where sub_component_name ='$sub_component_name'";
$tresult1w = mysql_query($tquery1w);

while($tdataw=mysql_fetch_array($tresult1w))
{
$ws_name=$tdataw['ws_name'];


?>
<option value="<?php echo $tdataw['ws_name']; ?>"><?php echo $tdataw['ws_name']; ?></option>
<?php

}
?>
</select>
<?php
	  }
	  else
	  {
		  ?>
<select name="ws_name" id="ws_name"  style="width:200px">
<option value=""><?php echo ALL_WSS;?></option>

</select>
<?php
	  }
	  ?>





		</div>
     
</td>
		 </tr>
		 <tr>
		
		  <td width="30%" >
      <strong><?php echo SEL_CAT_TYPE;?>:</strong>
      <div id="cattype"  >
      <?php if($ws_name!=""){?>
<select name="cat_name" id="cat_name" style="width:200px" onchange="getChannels(this.value)">
<option value=""><?php echo ALL_CAT_TYPES;?></option>
<?php
$tquery1w = "select distinct cat_name from  dgps_survey_data where ws_name ='$ws_name'";
$tresult1w = mysql_query($tquery1w);

while($tdataw=mysql_fetch_array($tresult1w))
{
$cat_name=$tdataw['cat_name'];


?>
<option value="<?php echo $ws_name."_".$tdataw['cat_name']; ?>"><?php echo $tdataw['cat_name']; ?></option>
<?php

}
?>
</select>
<?php
	  }
	  else
	  {
		  ?>
<select name="cat_name" id="cat_name"  style="width:200px">
<option value=""><?php echo ALL_CAT_TYPES;?></option>

</select>
<?php
	  }
	  ?>





		</div>
     
</td>
		  <td width="30%" >
      <strong><?php echo SELECT_CHANNEL;?>:</strong>
      <div id="channel"  >
      <?php if($cat_name!=""){?>
<select name="channel_id" id="channel_id" style="width:200px" onchange="getLayer(this.value)">
<option value=""><?php echo ALL_CHANNELS;?></option>
<?php
$tquery1w = "select distinct channel_id from  dgps_survey_data where cat_name ='$cat_name'";
$tresult1w = mysql_query($tquery1w);

while($tdataw=mysql_fetch_array($tresult1w))
{
$channel_id=$tdataw['channel_id'];


?>
<option value="<?php echo $tdataw['channel_id']; ?>"><?php echo $tdataw['channel_id']; ?></option>
<?php

}
?>
</select>
<?php
	  }
	  else
	  {
		  ?>
<select name="channel_id" id="channel_id"  style="width:200px">
<option value=""><?php echo ALL_CHANNELS;?></option>

</select>
<?php
	  }
	  ?>





		</div>
     
</td>
	
	      <td width="30%" >
      <strong><?php echo SEL_LAYER;?>:</strong>
      <div id="layer"  >
      <?php if($channel_id!=""){?>
<select name="layer" id="layer" style="width:200px" >
<option value=""><?php echo ALL_LAYERS;?></option>
<?php
$tquery1w = "select distinct layer from  dgps_survey_data where channel_id ='$channel_id'";
$tresult1w = mysql_query($tquery1w);

while($tdataw=mysql_fetch_array($tresult1w))
{
$layer=$tdataw['layer'];


?>
<option value="<?php echo $tdataw['layer']; ?>"><?php echo $tdataw['layer']; ?></option>
<?php

}
?>
</select>
<?php
	  }
	  else
	  {
		  ?>
<select name="layer" id="layer"  style="width:200px">
<option value=""><?php echo ALL_LAYERS;?></option>

</select>
<?php
	  }
	  ?>





		</div>
     
</td>
			 

</tr>

<tr>
         <td colspan="4">&nbsp;
         </td>
       </tr>   
	    
   <tr>
         <td colspan="4">
          <input type="button" onclick="advSearch(project_name.value,component_name.value,sub_component_name.value,ws_name.value,cat_name.value,channel_id.value,layer.value)" value="<?php echo GO?>" /></td>
       </tr>
     </table>
   </form>
</div>
	</div> </div>
    <div id="advsearch"></div>
   
  </body>
  
</html>