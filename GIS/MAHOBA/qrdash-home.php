<?php 
include("top.php");
if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}

?>
<?php 
 //echo $component_name = $_REQUEST['channel_id'];
//echo $sub_component_name = $_REQUEST['chainage_id'];

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
	
	function getChainages_analysis(channel_id,lang) {

					
			var strURL="sel_channel_chainages.php?channel_id="+channel_id+"&language="+lang;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("from_chang").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			getChanigeTo(channel_id,lang);
			//getKMto(road_name);
	}
	
	
		function getChainages_analysis_pu(channel_id_pu,lang) {

					
			var strURL="sel_channel_chainages_pu.php?channel_id="+channel_id_pu+"&language="+lang;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("from_chang_pu").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			getChanigeTo_pu(channel_id_pu,lang);
			//getKMto(road_name);
	}
	function getChanigeTo(channel_id,lang) {

					
			var strURL="sel_channel_chainages_to.php?channel_id="+channel_id+"&language="+lang;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("to_chang").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			
			//getKMto(road_name);
	}
	
function getChanigeTo_pu(channel_id_pu,lang) {

					
			var strURL="sel_channel_chainages_to_pu.php?channel_id="+channel_id_pu+"&language="+lang;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("to_chang_pu").innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			
			//getKMto(road_name);
	}

	
</script>
<style type="text/css">
 body { font: normal 10pt Helvetica, Arial; }
 #map { width: 100%; height: 350px; border: 0px; padding: 0px;  }
 </style>
 <script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>

<script type="text/javascript" src="includes/map_load.js"></script>

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
  width: 93%;
  height: 165px;  
  padding: 10px;
  border: 1px solid #006;
  background-color: #FAFAFA;
  border-radius:5px;
  margin-top: -55px;
}
.boxsize_km {
  width: 89%;
  height: 200px;  
  padding: 10px;
  border: 1px solid #006;
  background-color: #FAFAFA;
  border-radius:5px;
  margin-top: -55px;
}

.boxsize_uphoto {
  width: 89%;
  height: 200px;  
  padding: 10px;
  border: 1px solid #006;
  background-color: #FAFAFA;
  border-radius:5px;
  margin-top: -55px;
}
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
  right: 10px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>

<div style="background-color:#046b99; z-index:1; position: absolute; left: 1%; top: 20%; width: 3.5%; transform: translate(0px, 0px);
border-radius: 10px; <?php if(($_SESSION['ne_gmcentry']== 1) && ($_SESSION['ne_gmcadm']== 1)){ ?>height:150px<?php }else {?>height:200px<?php }?>">
<span style="cursor:pointer;margin-left:6px;line-height: 3em;" onclick="openNav()"><img src="../images/map_layers.jpg" alt="<?php echo THEMATIC_LAYERS?>" title="<?php echo THEMATIC_LAYERS?>" /></span>&nbsp;&nbsp;
<span style="cursor:pointer;margin-left:6px" onclick="opensearch()"><img src="../images/buffer.png" title="<?php echo BUFFER_ANALYSIS?>" /></span>&nbsp;&nbsp;
<a href="search_detail_all.php" target="_blank"><span style="cursor:pointer;margin-left:6px; margin-top:5px"><img src="../images/search.png" title="<?php echo QUICK_SEARCH ?>" />
</span></a>&nbsp;&nbsp;
</div>


<script>
function opensearch_km() {
  document.getElementById("search_km").style.width = "30%";
  document.getElementById("search").style.width = "0";
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("photos_upload").style.width = "0";
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
  document.getElementById("photos_upload").style.width = "0";
}
function openphotosupload() {
	 document.getElementById("photos_upload").style.width = "30%";
  document.getElementById("search").style.width = "0";
document.getElementById("mySidenav").style.width = "0";  
  document.getElementById("search_km").style.width = "0";
 
}
function closephotosupload() {
  document.getElementById("photos_upload").style.width = "0";
}
function closesearch() {
  document.getElementById("search").style.width = "0";
}
function openNav() {
  document.getElementById("mySidenav").style.width = "27%";
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

function pu_kmpost(lang) {
var channel_id = document.getElementById('channel_id_pu').value;		
var from_kmpost = parseInt(document.getElementById('from_kmpost_pu').value);	
var to_kmpost = parseInt(document.getElementById('to_kmpost_pu').value);
var queryString = "?channel_id=" + channel_id + "&from_kmpost=" + from_kmpost + "&to_kmpost=" + to_kmpost+ "&language=" + lang;
window.open ("photos_upload_range.php" + queryString, '_blank');
 //window.open('qrdash-home-km.php?from_kmpost='+from_kmpost+'to='+to_kmpost, '_blank');	
}


	
</script>

<div id="search" class="sidenav" style="background-color:; margin-top:180px; margin-left:65px; height:240px;border-radius: 10px;">
<form>
    <div class="boxsize" style="height:275px; width:92%; margin-top:-59px;">
       <div style="color:#000; font-weight:bold; font-size:16px; margin-bottom:4px; margin-top:10px"><?php echo BUFFER_ANALYSIS?> </div>

       <strong><?php echo WITHIN_RADIUS?></strong>
       <br/> <br/>
       <input type="text" id="mapdistance" value="500" /><br/><br/>
        <input type="text" id="maplat" value="<?php if($latbf!="")
				{echo $latbf;
				}
				else
				{
				echo "";
				}?>" placeholder="<?php echo LATITUDE?>"   /><br/><br/>
                <input type="text" id="maplng" value=
					"<?php if($lngbf!="")
				{
				echo $lngbf;
				}
				else
				{
				echo "";
				}?>"
				  placeholder="<?php echo LONGITUDE?>"/><br/>
    
		<div style="background-color:; height:24px; width:200px; margin-top:10px">
        <input type="submit" id="drawpoint" value="<?php echo SELECT?>" onclick="drawByLocation(); return false;"/> 
		<input type="submit" id="bufferof" value="<?php echo UNSELECT?>" onclick="bufferoff(); return false;"/> 
        </div>
         <div style="color:#000;  font-size:10px"> <?php echo CLICK_ON_MAP ?></div>
         <a href="javascript:void(0)" class="closebtn" onclick="closesearch()" 
         style="padding:0px 0px 0px 0px;position: absolute; top: 0; right: 20px; font-size: 36px;">
         <img src="../images/close.png" title="<?php echo CLOSE?>" /></a>
</div></form>      
   </div>



<div id="search_km" class="sidenav" style="background-color:; margin-left:65px; height:170px;border-radius: 10px; margin-top:225px">
         <a href="javascript:void(0)" class="closebtn" onclick="closesearch_km()" style="padding: 0px 0px 0px 0px;
         position: absolute; top: 0; right: 10px; font-size: 36px;">
         <img src="../images/close.png" title="Close" />
         </a>
<form>   
<div class="boxsize_km" style="width:94%">
       <div style="color:#000; font-weight:bold; font-size:16px; margin-bottom:4px; margin-top:10px"><?php echo CHAINAGE_WISE?> </div>

<div style="margin-top:20px"><?php echo SELECT_CHANNEL?>: 
       <select name="channel_id" id="channel_id" onchange="getChainages_analysis(this.value,'<?php echo $_SESSION['lang'];?>')">
              <option value="0"><?php echo SELECT_CHANNEL?></option>
              <?php
$cquery = "select distinct channel_id as  channel_id from dgps_survey_data where component_name='$componentName' and  channel_id !='ELV' and channel_id!='OTH' and channel_id!='LGMK'";

$cresult = mysql_query($cquery);
while ($cdata = mysql_fetch_array($cresult)) {
?>
              <option value="<?php echo $cdata['channel_id']; ?>" ><?php echo $cdata['channel_id'];?></option>
              <?php
}
?>
            </select>
		    
		</div>



        <div style="margin-top:20px" id="from_chang" ><?php echo FROM_CHAINAGE?>: 
       <select name="from_kmpost" id="from_kmpost" 
	   <?php if($_SESSION['lang']=="rus")	{?>    style="margin-left: 33px;"    <?php } else {	 ?>	 <?php }		 ?>
       >
              <option value="0"><?php echo SELECT_CHAINAGE?></option>
                </select>
		    
		</div>
        <div style="margin-top:20px" id="to_chang" ><?php echo TO_CHAINAGE?>:<select name="to_kmpost" id="to_kmpost"
        <?php if($_SESSION['lang']=="rus")	{?>    style="margin-left: 45px;"    <?php } else {	 ?>	  style="margin-left: 22px;"	<?php }	?>
        >
              <option value="0"><?php echo SELECT_CHAINAGE?></option>
             
            </select>
		</div>    
		<input type="submit" id="select" value="<?php echo SELECT?>" onclick="range_kmpost('<?php echo $_SESSION['lang'];?>'); return false;"/> 
	



        
         </div>
         
</form>

</div>
<div id="photos_upload" class="sidenav" style="background-color:; margin-left:65px; height:170px;border-radius: 10px; margin-top:225px">
         <a href="javascript:void(0)" class="closebtn" onclick="closephotosupload()" style="padding: 0px 0px 0px 0px;
         position: absolute; top: 0; right: 10px; font-size: 36px;">
         <img src="../images/close.png" title="Close" />
         </a>
<form>   
<div class="boxsize_uphoto" style="width:94%">
       <div style="color:#000; font-weight:bold; font-size:16px; margin-bottom:4px; margin-top:10px"><?php echo "Upload Photos";?> </div>

<div style="margin-top:20px"><?php echo SELECT_CHANNEL?>: 
       <select name="channel_id_pu" id="channel_id_pu" onchange="getChainages_analysis_pu(this.value,'<?php echo $_SESSION['lang'];?>')">
              <option value="0"><?php echo SELECT_CHANNEL?></option>
              <?php
$cquery = "select distinct channel_id as  channel_id from dgps_survey_data where component_name='$componentName' and  channel_id !='ELV' and channel_id!='OTH' and channel_id!='LGMK'";

$cresult = mysql_query($cquery);
while ($cdata = mysql_fetch_array($cresult)) {
?>
              <option value="<?php echo $cdata['channel_id']; ?>" ><?php echo $cdata['channel_id'];?></option>
              <?php
}
?>
            </select>
		    
		</div>



        <div style="margin-top:20px" id="from_chang_pu" ><?php echo FROM_CHAINAGE?>: 
       <select name="from_kmpost_pu" id="from_kmpost_pu" 
	   <?php if($_SESSION['lang']=="rus")	{?>    style="margin-left: 33px;"    <?php } else {	 ?>	 <?php }		 ?>
       >
              <option value="0"><?php echo SELECT_CHAINAGE?></option>
                </select>
		    
		</div>
        <div style="margin-top:20px" id="to_chang_pu" ><?php echo TO_CHAINAGE?>:
         <select name="to_kmpost_pu" id="to_kmpost_pu"
        <?php if($_SESSION['lang']=="rus")	{?>    style="margin-left: 45px;"    <?php } else {	 ?>	  style="margin-left: 22px;"	<?php }	?>
        >
              <option value="0"><?php echo SELECT_CHAINAGE?></option>
             
            </select>
		</div>    
		<input type="submit" id="select" value="<?php echo SELECT?>" onclick="pu_kmpost('<?php echo $_SESSION['lang'];?>'); return false;"/> 
	



        
         </div>
         
</form>

</div>



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
<div id="legends" style="float:left;font-size:14px; color:#006; margin-left:; margin-top:-30px"><strong style="margin-top:10px">
</strong>
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
	$image_name_point='<span><svg style="margin-left:6px;" height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
		if($file_name=="road.kml")
		{
			$checked='checked="checked"';
		}
		else
		{
			$checked="";
		}
		
	
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

	<td width="11%">	<h3><?php echo "Layers"?></h3>
    
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
	$image_name_point='<span><svg style="margin-left:6px;" height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
		if($file_name=="road.kml")
		{
			$checked='checked="checked"';
		}
		else
		{
			$checked="";
		}
		
	
	$image_name_point='<span><svg style="margin-left:6px;" width="10" height="10">
  <rect width="10" height="10" style="fill:'.$color_lp.'";stroke-width:3;fill-opacity:0.1;stroke-opacity:0.9;stroke:'.$color_1p.'" />
</svg></span>';
	
	}
	
	$i=$i+1;
	if($i==1)
	{
		?>
    <tr>

	<td width="11%">	<h3><?php echo DESIGN_LAYERS?></h3>
    
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



<div id="legends" style="font-size:14px; color:#006;"><strong style="margin-top:10px">
</strong>
<?php $kmlsql="select * from kmls_add where type = 4 and component_name='$componentName'";
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
		if($file_name=="road.kml")
		{
			$checked='checked="checked"';
		}
		else
		{
			$checked="";
		}
		
	
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

	<td width="11%">	<h3><?php echo SURVEY_LAYERS?></h3>
    
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
	$image_name_point='<span><svg style="margin-left:6px;" height="6" width="20">
  <line x1="0" y1="0" x2="10" y2="" style="stroke:'.$color_lp.'";stroke-width:10;" /></span>';
	
	}
	else if($attribute_type=="polygon")
	{
		if($file_name=="road.kml")
		{
			$checked='checked="checked"';
		}
		else
		{
			$checked="";
		}
		
	
	$image_name_point='<span><svg style="margin-left:6px;" width="10" height="10">
  <rect width="10" height="10" style="fill:'.$color_lp.'";stroke-width:3;fill-opacity:0.1;stroke-opacity:0.9;stroke:'.$color_1p.'" />
</svg></span>';
	
	}
	
	$i=$i+1;
	if($i==1)
	{
		?>
    <tr>

	<td width="11%">	<h3><?php echo DESIGN_LAYERS?></h3>
    
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

<!--<div style="background-color:; z-index:1; position: absolute; left: 85%; top: 0%; width: 14.5%; transform: translate(0px, 0px);
border-radius: 10px; height:230px">
<img src="images/Legend.png" style="height:230px; width:100%" />
</div>
-->
<?php include("includes/maps.php"); ?>


<div id="buffer_detail"></div>
<div class="clear"></div>
	<?php //include("includes/footer.php");?>
	<div class="clear"></div>

</body>
</html>