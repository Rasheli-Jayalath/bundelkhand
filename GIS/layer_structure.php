<?php 
require_once("config/config.php");
$objCommon 		= new Common;
$objMenu 		= new Menu;
$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objProduct 	= new Product;
$objValidate 	= new Validate;
$objOrder 		= new Order;
$objLog 		= new Log;
require_once('rs_lang.admin.php');
//require_once('rs_lang.website.php');
?><?php 
$defaultLang='en'; 
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.eng.php');

}
else
{
	require_once('rs_lang.rus.php');

}
if($objAdminUser->is_login== false){
	header("location: index.php");
}
$component=$_GET['component_name'];
$layer_name=$_GET['layer_name'];
if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['Cancel']=='Cancel'){
	redirect('layer_structure.php');
}

if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['Save']=='Save'){
	$component_name 	= trim($_POST['component_name']);
	$layer_name 	= trim($_POST['layer_name']);
	
	$sql_y="Select distinct layer_name from layers_template where component_name='$component_name'";
			$res3_y=mysql_query($sql_y);
			while($row3_y=mysql_fetch_array($res3_y))
			{
				if($layer_name==$row3_y['layer_name'])
				{
					$info=1;
					
				$objCommon->setMessage("Layer template already Added. Please edit and update its template",'Info');
				
				//header("Location: layer_structure.php");
				}
				else
				{
				}
			}
	if($info!=1)
	{
	
	$sdelete= "Delete from layers_template where layer_name='$layer_name' and component_name='$component_name'";
	   mysql_query($sdelete);
				
			$cat_title_text1=	$_POST['cat_title_text'];
			$cat_title_text1_rus=	$_POST['cat_title_text_rus'];
			$cat_field_name1=	$_POST['cat_field_name'];
			//$orderr=$_POST['order'];
			
		
		echo $counttt= count($cat_field_name1);
		
		for($h=0;$h<$counttt; $h++)
		{
		$orderr=$_POST['order'][$h];
		
		//echo $cat_id=$category_cd;
		 $cat_field_name=$cat_field_name1[$h];
		 $cat_title_text= $cat_title_text1[$h];
		 $cat_title_text_rus= $cat_title_text1_rus[$h];
		if($cat_title_text!="" && $cat_title_text_rus!="")
		{
		
	echo	$sqlIn="INSERT INTO layers_template SET
			component_name = '$component_name',
			layer_name = '$layer_name',	
			cat_temp_order = '$orderr',
			cat_field_name = '".addslashes($cat_field_name)."',
			cat_title_text = '".addslashes($cat_title_text)."',
			cat_title_text_rus = '".addslashes($cat_title_text_rus)."'";
	
mysql_query($sqlIn);

					
		}
		else if($cat_title_text!="" && $cat_title_text_rus=="")
		{
			$cat_title_text_rus=$cat_title_text;
			$sqlIn="INSERT INTO layers_template SET
			component_name = '$component_name',
			layer_name = '$layer_name',	
			cat_temp_order = '$orderr',
			cat_field_name = '".addslashes($cat_field_name)."',
			cat_title_text = '".addslashes($cat_title_text)."',
			cat_title_text_rus = '".addslashes($cat_title_text_rus)."'";
	
mysql_query($sqlIn);
		}
		else if($cat_title_text=="" && $cat_title_text_rus!="")
		{
			$cat_title_text=$cat_title_text_rus;
			$sqlIn="INSERT INTO layers_template SET
			component_name = '$component_name',
			layer_name = '$layer_name',	
			cat_temp_order = '$orderr',
			cat_field_name = '".addslashes($cat_field_name)."',
			cat_title_text = '".addslashes($cat_title_text)."',
			cat_title_text_rus = '".addslashes($cat_title_text_rus)."'";
	
mysql_query($sqlIn);
		}
	
		
}
	$objCommon->setMessage("Layer template Added successfully",'Info');
	}

	redirect('layer_structure.php');
}

if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['Update']=='Update'){
		
	 $component_name 	= trim($_POST['component_name']);
	$layer_name 	= trim($_POST['layer_name']);
	$sdelete= "Delete from layers_template where layer_name='$layer_name' and component_name='$component_name'";
	   mysql_query($sdelete);
				
			$cat_title_text1=	$_POST['cat_title_text'];
			
			$cat_field_name1=	$_POST['cat_field_name'];
			$cat_title_text1_rus=	$_POST['cat_title_text_rus'];
			//$orderr=$_POST['order'];
			
		
		echo $counttt= count($cat_field_name1);
		
		for($h=0;$h<$counttt; $h++)
		{
		$orderr=$_POST['order'][$h];
		
		//echo $cat_id=$category_cd;
		 $cat_field_name=$cat_field_name1[$h];
		 $cat_title_text= $cat_title_text1[$h];
		  $cat_title_text_rus= $cat_title_text1_rus[$h];
		if($cat_title_text!="" && $cat_title_text_rus!="")
		{
		
	echo	$sqlIn="INSERT INTO layers_template SET
			component_name = '$component_name',
			layer_name = '$layer_name',	
			cat_temp_order = '$orderr',
			cat_field_name = '".addslashes($cat_field_name)."',
			cat_title_text = '".addslashes($cat_title_text)."',
			cat_title_text_rus = '".addslashes($cat_title_text_rus)."'";
	
mysql_query($sqlIn);

					
		}
		else if($cat_title_text!="" && $cat_title_text_rus=="")
		{
			$cat_title_text_rus=$cat_title_text;
			$sqlIn="INSERT INTO layers_template SET
			component_name = '$component_name',
			layer_name = '$layer_name',	
			cat_temp_order = '$orderr',
			cat_field_name = '".addslashes($cat_field_name)."',
			cat_title_text = '".addslashes($cat_title_text)."',
			cat_title_text_rus = '".addslashes($cat_title_text_rus)."'";
	
mysql_query($sqlIn);
		}
		else if($cat_title_text=="" && $cat_title_text_rus!="")
		{
			$cat_title_text=$cat_title_text_rus;
			$sqlIn="INSERT INTO layers_template SET
			component_name = '$component_name',
			layer_name = '$layer_name',	
			cat_temp_order = '$orderr',
			cat_field_name = '".addslashes($cat_field_name)."',
			cat_title_text = '".addslashes($cat_title_text)."',
			cat_title_text_rus = '".addslashes($cat_title_text_rus)."'";
	
mysql_query($sqlIn);
		}
	
	
		
}
$objCommon->setMessage("Layer template Updated successfully",'Info');
redirect('layer_structure.php');
	
}
if(isset($_GET['mode']) && $_GET['mode'] == "delete"){
				$layer_name = $_GET['layer_name'];
				$component_name = $_GET['component_name'];
					$sdelete= "Delete from layers_template where layer_name='$layer_name' and component_name='$component_name'";
	   mysql_query($sdelete);
	   $info=4;
					$objCommon->setMessage("Layer template Deleted successfully",'Info');
				
						redirect('layer_structure.php');
					}				
	

/*$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$layer_name 	= trim($_POST['layer_name']);
	
	$category_name 	= trim($_POST['category_name']);
	 $category_status1= trim($_POST['category_status']);
	if($category_status1=="")
	{
	 $category_status=0;
	}
	else
	{
	 $category_status=$category_status1;
	}
	$parent_cd 		= trim($_POST['parent_cd']);
	$cid 		= trim($_POST['cid']);
	
	
	

	
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("layer_name", PRD_FLD_MSG_CATNAME, "S");
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
		$category_cd = ($_POST['mode'] == "U") ? $_POST['category_cd'] : $objAdminUser->genCode("rs_tbl_category", "category_cd");
		
		$objProdctC = new Product;
		$objProdctC->setProperty("category_name", $category_name);
		$objProdctC->setProperty("parent_cd", $parent_cd);
		$objProdctC->setProperty("cid", $cid);
		if($category_cd){
			$objProdctC->setProperty("category_cd", $category_cd);
		}
		if($objProdctC->checkCategory()){
			$objCommon->setMessage('Category name already exits. Please enter another category.', 'Error');
		}
		else{
		if($parent_cd==0)
	{
	//$parent_group=$category_cd;
	if(strlen($category_cd)==1)
		{
		$parent_group="00".$category_cd;
		}
		else if(strlen($category_cd)==2)
		{
		$parent_group="0".$category_cd;
		}
		else
		{
		$parent_group=$category_cd;
		}
	}
	else
	{
	$parent_group1=$parent_cd."_".$category_cd;
	$sql="select parent_group from rs_tbl_category where category_cd='$parent_cd'";
	$sqlrw=mysql_query($sql);
	$sqlrw1=mysql_fetch_array($sqlrw);
	if(strlen($category_cd)==1)
		{
		$category_cd_pg="00".$category_cd;
		}
		else if(strlen($category_cd)==2)
		{
		$category_cd_pg="0".$category_cd;
		}
		else
		{
		$category_cd_pg=$category_cd;
		}
	
	$parent_group=$sqlrw1['parent_group']."_".$category_cd_pg;
	}
			$objProduct->setProperty("category_cd", $category_cd);
			$objProduct->setProperty("parent_cd", $parent_cd);
			$objProduct->setProperty("category_name", $category_name);
			$objProduct->setProperty("parent_group", $parent_group);
			$objProduct->setProperty("category_status", $category_status);
			$objProduct->setProperty("cid", $cid);
			
			if($objProduct->actCategory($_POST['mode'])){
			
			
			$sdelete= "Delete from rs_tbl_category_template where cat_id='$category_cd'";
	   mysql_query($sdelete);
				
			$cat_title_text1=	$_POST['cat_title_text'];
			
			$cat_field_name1=	$_POST['cat_field_name'];
			//$orderr=$_POST['order'];
			
		
		echo $counttt= count($cat_field_name1);
		
		for($h=0;$h<$counttt; $h++)
		{
		$orderr=$_POST['order'][$h];
		
		echo $cat_id=$category_cd;
		echo $cat_field_name=$cat_field_name1[$h];
		echo $cat_title_text= $cat_title_text1[$h];
		if($cat_title_text!="")
		{
		
		$sqlIn="INSERT INTO rs_tbl_category_template SET
			cat_id = '$cat_id',	
			cat_temp_order = '$orderr',
			cat_field_name = '".addslashes($cat_field_name)."',
			cat_title_text = '".addslashes($cat_title_text)."'";
	
mysql_query($sqlIn);
		}
		else
		{
		}
		}
		
			
				if($_POST['mode'] == "U"){
					$objCommon->setMessage(PRD_FLD_UP_MSG_SUCCESS,'Info');
					$activity="Category has been updated";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
				}
				else{
					$objCommon->setMessage(PRD_FLD_MSG_SUCCESS,'Info');
					$activity="Category has been added";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
				}
				
				redirect('./?p=category');
			}
		}
	}
	extract($_POST);
}
else{
	if(isset($_GET['category_cd']) && !empty($_GET['category_cd']))
		$category_cd = $_GET['category_cd'];
	else if(isset($_POST['category_cd']) && !empty($_POST['category_cd']))
		$category_cd = $_POST['category_cd'];
	if(isset($category_cd) && !empty($category_cd)){
		$objProduct->resetProperty();
		$objProduct->setProperty("category_cd", $category_cd);
		$objProduct->lstCategory();
		$data = $objProduct->dbFetchArray(1);
		$mode	= "U";
		extract($data);
	}
}*/




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

    <link href="css/CssAdminStyle.css" rel="stylesheet" type="text/css" />
<link href="css/CssLogin2.css" rel="stylesheet" type="text/css" />
<link href="css/CssMessages.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css_map/index.css"/>
<link rel="stylesheet" type="text/css" href="css_map/map.css"/>

<!--<script src="lightbox/js/lightbox.min.js"></script>-->
<link rel="stylesheet" href="magnific-popup/magnific-popup.css">

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

<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.component_name.value == "0"){
		msg = msg + "\r\n<?php echo "Component Name is compulsory Field";?>";
		flag = false;
	}
	if(frm.layer_name.value == "0"){
		msg = msg + "\r\n<?php echo "Layer Name is compulsory Field";?>";
		flag = false;
	}
	
	if(flag == false){
		alert(msg);
		return false;
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

function get_layers(component_name) {
	
			var strURL="get_layers.php?component_name="+component_name;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("getlayers").innerHTML=req.responseText;
							
												
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

</script>
  </head>
  <body onload="init();">
<?php  include 'includes/headerMainHome.php'; ?>
<div id="navcontainer" class="menu"  style="  width:1348px; margin-top:3px;float: inherit;">
 <span style="float:left; font-size:20px; font-weight:bold; padding-top:4px;color:white; padding-left:6px;"><?php echo GIS_DASHBOARD?></span>
 <span style="float:right; font-size:12px; padding-top:5px; padding-right:3px;color:white; text-decoration:none"><a href="index.php"><img  src="images/home.png"/></a></span>
</div>
  <form name="frmCategory" id="frmCategory" action="" method="post" onSubmit="return frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="category_cd" id="category_cd" value="<?php echo $category_cd;?>" />
        
         <div id="tableContainer"  class="table" style="border-left:1px;">
        
          <table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
           <tr>
      
        <td>
	    <?php echo "Component Name";?> <span style="color:#FF0000;">*</span>:
        </td>
        <td>
        <div class="frmElement"><select name="component_name" id="component_name" class="rr_select" onchange="get_layers(this.value)">
			<option value="0" selected>--select---</option>
            <?php
			$tquery1 = "select distinct component_name from  dgps_survey_data";
			$tresult1 = mysql_query($tquery1);
			while($tdata=mysql_fetch_array($tresult1))
			{
			$component_name=$tdata['component_name'];
			
				
			
			?>
			<option value="<?php echo $component_name;?>" <?php if($component_name==$component) echo 'selected="selected"';?>><?php echo $component_name;?></option>
			<?php
			}
			?>
		</select></div>
		</td>
        </tr>
		   <tr>
      
        <td>
	    <?php echo "Select Layer";?> <span style="color:#FF0000;">*</span>:
        </td>
        <td>
        <div  id="getlayers" class="frmElement">
         <?php if($component_name!=""){?>
<select name="layer_name" id="layer_name" style="width:200px" >
<option value="">--<?php echo SELECT;?>--</option>
<?php
echo $tquery1 = "select distinct layer from  dgps_survey_data where component_name ='$component_name'";
$tresult1 = mysql_query($tquery1);

while($tdata=mysql_fetch_array($tresult1))
{
$layer=$tdata['layer'];


?>
<option value="<?php echo $layer;?>" <?php if($layer==$layer_name) echo 'selected="selected"';?>><?php echo $layer;?></option>
<?php

}
?>
</select>
<?php
	  }
	  else
	  {
		  ?>
        
        <select name="layer_name" id="layer_name"  style="width:200px">
<option value="">--<?php echo SELECT;?>--</option>

</select>
        
            <?php
	  }
	  ?>
			</div>
		</td>
        </tr>
		 
  
       
		 <tr>
      
        <td >
	    Template <span style="color:#FF0000;"></span>:
        </td>
        <td>
	<table>
	<tr><td>&nbsp;</td><td><strong>English</strong></td><td><strong>Russian</strong></td><td><strong>Order</strong></td></tr>	
		<?php
		
		
			
			
		$sqll="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbCfg[db_name]' AND TABLE_NAME = 'dgps_survey_data' limit 2,26";
$res=mysql_query($sqll);
while($ress=mysql_fetch_array($res))
{
?>
<tr>

<?php
 $column_name1=$ress['COLUMN_NAME'];
 if($column_name1=="hyperlink")
{
}
elseif($column_name1=="project_name")
{

}


else
{
 ?>
 <td>
 <?php
if($column_name1=="layer")
{
echo $column_name="Layer";
}

if($column_name1=="label")
{
echo $column_name="Label";
}
if($column_name1=="channel_id")
{
echo $column_name="Channel ID";
}

if($column_name1=="code")
{
echo $column_name="Code";
}
if($column_name1=="unique_id")
{
echo $column_name="Unique ID";
}
if($column_name1=="chainage_id")
{
echo $column_name="Chainage ID";
}
if($column_name1=="elevation")
{
echo $column_name="Elevation";
}

if($column_name1=="soil_a_depth")
{
echo $column_name="Soil A Depth";
}
if($column_name1=="soil_b_depth")
{
echo $column_name="Soil B Depth";
}
if($column_name1=="soil_c_depth")
{
echo $column_name="Soil C Depth";
}
if($column_name1=="total_depth")
{
echo $column_name="Total Depth";
}
if($column_name1=="direction_left")
{
echo $column_name="Direction Left";
}
if($column_name1=="direction_right")
{
echo $column_name="Direction Right";
}
if($column_name1=="shape_length")
{
echo $column_name="Shape Length";
}
if($column_name1=="shape_area")
{
echo $column_name="Shape Area";
}

if($column_name1=="issue_date")
{
echo $column_name="Issue Date";
}
if($column_name1=="remarks")
{
echo $column_name="Remarks";
}
if($column_name1=="ws_name")
{
echo $column_name="Workstage Name";
}
if($column_name1=="cat_name")
{
echo $column_name="Category Type";
}

if($column_name1=="component_name")
{
echo $column_name="Component Name";
}
if($column_name1=="sub_component_name")
{
echo $column_name="SubComponent Name";
}
if($column_name1=="latitude")
{
echo $column_name="Latitude";
}
if($column_name1=="longitude")
{
echo $column_name="Longitude";
}
if($column_name1=="feature_type")
{
echo $column_name="Feature Type";
}


?>	
</td>
<?php
}
 if($column_name1=="hyperlink")
{
}
elseif($column_name1=="project_name")
{

}

else
{
?>

		<td>
        <input class="rr_input" type="hidden" name="cat_field_name[]" id="cat_field_name[]" value="<?php echo $column_name1;?>" style="width:200px;" />
        
		<input class="rr_input" type="text" name="cat_title_text[]" id="cat_title_text[]" value="<?php
		if(isset($_GET['layer_name']) && isset($_GET['component_name']) )
		{
		$sql3="Select * from layers_template where layer_name='$layer_name' and component_name='$component'";
			$res3=mysql_query($sql3);
			while($row3=mysql_fetch_array($res3))
			{
			
			 $cat_fieldname=$row3['cat_field_name'];
			  $cat_titletext=$row3['cat_title_text'];
			if ($column_name1==$cat_fieldname)
		{
		echo $cat_titletext;
		} 
			
			
			}
			}
			else
			{
			}
		
		 ?>" style="width:200px;" />
		 
		</td>
        <td>
        <input class="rr_input" type="text" name="cat_title_text_rus[]" id="cat_title_text_rus[]" value="<?php
		if(isset($_GET['layer_name']))
		{
		$sql3="Select * from layers_template where layer_name='$layer_name' and component_name='$component'";
			$res3=mysql_query($sql3);
			while($row3=mysql_fetch_array($res3))
			{
			
			 $cat_fieldname=$row3['cat_field_name'];
			  $cat_titletext_rus=$row3['cat_title_text_rus'];
			if ($column_name1==$cat_fieldname)
		{
		echo $cat_titletext_rus;
		} 
			
			
			}
			}
			else
			{
			}
		
		 ?>" style="width:200px;" />
        </td>
		<?php
		}
 if($column_name1=="hyperlink")
{
}
elseif($column_name1=="project_name")
{

}
else
{
		?>
		<td>
		<input name="order[]" type="text" class="rr_input" id="order[]" tabindex="<?php echo $i;?>" value="<?php
		if(isset($_GET['layer_name']))
		{
		$sql3="Select * from layers_template where layer_name='$layer_name' and component_name='$component'";
			$res3=mysql_query($sql3);
			while($row3=mysql_fetch_array($res3))
			{
			
			 $cat_fieldname=$row3['cat_field_name'];
			  $cat_temporder=$row3['cat_temp_order'];
			if ($column_name1==$cat_fieldname)
		{
		echo $cat_temporder;
		} 
			
			
			}
			}
			else
			{
			}
		
		 ?>" style="width:40px" />
						
         <input name="field_name[]" type="hidden" id="field_name[]" value="<?php echo $column_name1;?>"  />
		</td>
		<?php
		}
		?>
		<!--<td>
		<input class="rr_input"  type="checkbox" name="check_id[]" id="check_id[]" value="<?php //$column_name1?>" style="width:10px;" />
		</td>-->
		</tr>
		
		
		<?php
		}
		?>
		
		</table>
        </td>
        </tr>
        <tr >
        <td colspan="2" align="center">
          
        <div id="div_button">
        
        <?php
			   if(isset($_GET['layer_name']) && $_GET['layer_name']!="" && $_GET['component_name']!=""){?>
			  <input type="submit" value="<?php echo UPDATE?>" name="Update" />
               &nbsp;&nbsp;<input type="button" value="<?php echo CANCEL?>" name="Cancel" onClick="parent.location='layer_structure.php'"  />
			  <?php } else { ?>
			  <input type="submit" value="<?php echo SAVE?>" name="Save" id="Save" />
              &nbsp;&nbsp;<input type="button" value="<?php echo CANCEL?>" name="Cancel" onClick="parent.location='layer_structure.php'" />
			 
			  <?php } ?>
        
           
            <!--<input type="button" class="rr_button" value="<?php //echo _BTN_CANCEL;?>" onClick="document.location='./?p=category';" />-->
        </div>
        </td>
        </tr>
        </table>
      
      </div>
	</form>

    <?php echo $objCommon->displayMessage();?>

<div id="tableContainer" class="table" style="border-left:1px;">
		<table  width="100%" border="0" cellspacing="0" cellpadding="0">
        
    <tr>
      
       <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo "Layer";?></td>
      <td colspan="2" style="width:20%; font-weight:bold; background:#ededed"><?php echo "Action";?></td>
      
    </tr>
    <?php
	
	$sql31="Select distinct component_name from layers_template";
			$res31=mysql_query($sql31);
			while($row31=mysql_fetch_array($res31))
	{
		$comp_name=$row31['component_name'];
		?>
		<tr>
      
      <td style="font-weight:bold; background: #E3B9B3" class="clsleft" colspan="3"><?php echo $row31['component_name'];?></td>
      
      
    </tr>
	<?php	
	$sql3="Select distinct layer_name from layers_template where component_name='$comp_name'";
			$res3=mysql_query($sql3);
			while($row3=mysql_fetch_array($res3))
	{
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
    		<tr bgcolor="<?php echo $bgcolor;?>">
                <td class="clsleft"><?php echo $row3['layer_name'];?></td>
                 
                <td><a href="layer_structure.php?component_name=<?php echo $comp_name;?>&layer_name=<?php echo $row3['layer_name'];?>" title="Edit"><img src="<?php echo SITE_URL;?>images/edit.gif" border="0" /></a></td>
                <td><a href="layer_structure.php?mode=delete&component_name=<?php echo $comp_name;?>&layer_name=<?php echo $row3['layer_name'];?>" onClick="return confirm('Are you sure you want to delete this layer?');" title="Delete"><img src="<?php echo SITE_URL;?>images/delete.gif" border="0" alt="Delete" title="Delete" /></a></td>
    		</tr>
    		<?php
			//getSub($rows['category_cd']);
		
    }
	}
	?>
  </table>
		</div>
  </body>
  
</html>