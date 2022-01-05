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


	$project_name = $_REQUEST['project_name'];
//$category = $_REQUEST['category'];
$component_name = $_REQUEST['component_name'];
 $sub_component_name = $_REQUEST['sub_component_name'];
if($sub_component_name!="")
{
$array_subcomp=explode("_",$sub_component_name);
$subcomp_name=$array_subcomp[1];
}
else
{
$subcomp_name="";
}

$wss_name = $_REQUEST['ws_name'];

if($wss_name!="")
{
$array_wss=explode("_",$wss_name);
$ws_name=$array_wss[2];
}
else
{
$ws_name="";
}


$category_name = $_REQUEST['cat_name'];
if($category_name!="")
{
$array_cat=explode("_",$category_name);
$cat_name=$array_cat[3];
}
else
{
$cat_name="";
}

$channel_name = $_REQUEST['channel_id'];
$array_chanl=explode("_",$channel_name);

//echo count($array_chanl);
if($channel_name!="" && count($array_chanl)>4)
{
 $channel_id=$array_chanl[4];
}
else if($channel_name!="" && count($array_chanl)==4)
{
$channel_id=$array_chanl[3];
}
else{

 $channel_id=$channel_name;
}
 $layer_name = $_REQUEST['layer'];

//$valuei = date('Y-m-d',strtotime($valueidate));

$now = new DateTime();
$nowyear = $now->format("Y");


$sCondition = '';

if($project_name!="")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (project_name LIKE '%".$project_name."%')";
	}
	else
	{
	$sCondition=" (project_name LIKE '%".$project_name."%')";
	}
//	echo $sCondition;
}


if($component_name!="0")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (component_name LIKE '%".$component_name."%')";
	}
	else
	{
	$sCondition=" (component_name LIKE '%".$component_name."%')";
	}
//	echo $sCondition;
}


if($subcomp_name!="0")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (sub_component_name LIKE '%".$subcomp_name."%')";
	}
	else
	{
	$sCondition=" (sub_component_name LIKE '%".$subcomp_name."%')";
	}
//	echo $sCondition;
}



if($ws_name!="0")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (ws_name LIKE '%".$ws_name."%')";
	}
	else
	{
	$sCondition=" (ws_name LIKE '%".$ws_name."%')";
	}
//	echo $sCondition;
}
if($cat_name!="0")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (cat_name LIKE '%".$cat_name."%')";
	}
	else
	{
	$sCondition=" (cat_name LIKE '%".$cat_name."%')";
	}
//	echo $sCondition;
}
if($channel_id!="0")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (channel_id LIKE '%".$channel_id."%')";
	}
	else
	{
	$sCondition=" (channel_id LIKE '%".$channel_id."%')";
	}
//	echo $sCondition;
}
if($layer_name!="")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (layer LIKE '%".$layer_name."%')";
	}
	else
	{
	$sCondition=" (layer LIKE '%".$layer_name."%')";
	}
//	echo $sCondition;
}



/*if(($lease_start!="") && ($lease_end!=""))
{

$lease_start1 = date('Y-m-d',strtotime($lease_start));
$lease_end1 = date('Y-m-d',strtotime($lease_end));
	if($sCondition!="")
	{
	$sCondition.=" AND ((lease_start>='$lease_start1') AND (lease_end<='$lease_end1'))";
	}
	else
	{
	$sCondition=" ((lease_start>='$lease_start1') AND (lease_end<='$lease_end1'))";
	}
//	echo $sCondition;
}
else if(($lease_start!="") && ($lease_end==""))
{
$lease_start1 = date('Y-m-d',strtotime($lease_start));
$current_date=date('Y-m-d');
	if($sCondition!="")
	{
	$sCondition.=" AND ((lease_start>='$lease_start1') AND (lease_end<='$current_date'))";
	}
	else
	{
	$sCondition=" ((lease_start>='$lease_start1') AND (lease_end<='$current_date'))";
	}
//	echo $sCondition;
}
else if(($lease_start=="") && ($lease_end!=""))
{
$lease_end1 = date('Y-m-d',strtotime($lease_end));
	if($sCondition!="")
	{
	$sCondition.=" AND  ((lease_start>'0000-00-00') AND(lease_end<='$lease_end1'))";
	}
	else
	{
	$sCondition=" ((lease_start>'0000-00-00') AND(lease_end<='$lease_end1'))";
	}
//	echo $sCondition;
}*/


 $sql361="Select * from layers_template where layer_name='$layer_name' order by cat_temp_order asc";
$res361=mysql_query($sql361);
$total_rows=mysql_num_rows($res361);


$orderby = " order by id asc";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
    <!-- This page is copyright Elated Communications Ltd. (www.elated.com) -->

    <title>Canal Assets Monitoring Dashboard</title>

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
<body>
<?php


 $sSQL1 = "SELECT * FROM dgps_survey_data WHERE ".$sCondition.$orderby;
$sSQL12=mysql_query($sSQL1);
$iCount = mysql_num_rows($sSQL12);


?>

   
	<table class="reference" style="width:100%" >
    <tr  style=" color:#CCC; background:#046b99">
   <?php  if($layer_name!="" && $total_rows>=1)
{
	 $sql36="Select * from layers_template where component_name='$componentName' and layer_name='$layer_name' order by cat_temp_order asc";
$res36=mysql_query($sql36);
	while($row36=mysql_fetch_array($res36))
			{	
			 $field_name=$row36["cat_field_name"];

	?>
	<td  width="5%"  style="text-align:center; font-weight:bold"><?php
if($_SESSION["lang"]=='en')
{
	 echo $row36['cat_title_text'];
}
else
{
	 echo $row36['cat_title_text_rus'];
}

 ?></td>
<?php }}
else
{?>
    
    
    
      <th align="center" width="2%"><strong><?php echo SrNO ?></strong></th>
	  <th  width="5%"  style="text-align:center"><strong><?php echo CHANNEL ?></strong></th>
      <th  width="6%"  style="text-align:center"><strong><?php echo COMP_NAME ?></strong></th>
       <th width="6%"  style="text-align:center"><strong><?php echo SUBCOMP_NAME ?></strong></th>
      <th  width="6%"  style="text-align:center"><strong><?php echo WORKSTAGE ?></strong></th>
	  <th  width="6%"  style="text-align:center"><strong><?php echo CAT_TYPE ?></strong></th>
       <th  width="6%"  style="text-align:center"><strong><?php echo LAYER ?></strong></th>
      <th  width="6%"  style="text-align:center"><strong><?php echo CHAINAGE ?></strong></th>
        <th width="6%"  style="text-align:center"><strong><?php echo CODE ?></strong></th>
      <th  width="6%"  style="text-align:center"><strong><?php echo ELEVATION ?></strong></th>
	  <th  width="6%"  style="text-align:center"><strong><?php echo LABEL ?></strong></th>
      <th  width="6%"  style="text-align:center"><strong><?php echo SHP_LENGTH ?></strong></th>
	  <th  width="6%"  style="text-align:center"><strong><?php echo SHP_AREA ?></strong></th>
     
      
      <th width="6%"  style="text-align:center"><strong><?php echo ISSUE_DATE ?></strong></th>
      <th width="3%"  style="text-align:center"><strong><?php echo SA_DEPTH ?></strong></th>
      <th  width="3%"  style="text-align:center"><strong><?php echo SB_DEPTH ?></strong></th>
	  <th  width="3%"  style="text-align:center"><strong><?php echo SC_DEPTH ?></strong></th>
	  <th  width="3%"  style="text-align:center"><strong><?php echo T_DEPTH ?></strong></th>
	 
    
	 

    <?php 
}
?>
    </tr>
    <?php
/*?><tr  style=" color:#CCC; background:#046b99">
    <?php if($sub_component_name=="Polygon")
		{?>
      <th align="center" width="2%"><strong>Sr. No.</strong></th>
	 	
       <th width="3%"  style="text-align:center"><strong>Road Name</strong></th>
      <th  width="5%"  style="text-align:center"><strong>Road Type</strong></th>
	  <th  width="7%"  style="text-align:center"><strong>component_name</strong></th>
      <th  width="5%"  style="text-align:center"><strong>Attribute Type</strong></th>
	  <th  width="5%"  style="text-align:center"><strong>KMPost</strong></th>
	  <th  width="8%"  style="text-align:center"><strong>Detail</strong></th>
      <th  width="8%"  style="text-align:center"><strong>cat_name</strong></th>
      
        <th width="5%"  style="text-align:center"><strong>DGPS ID</strong></th>
      <th  width="7%"  style="text-align:center"><strong>Chainage</strong></th>
	  <th  width="8%"  style="text-align:center"><strong>Range</strong></th>
      <th  width="7%"  style="text-align:center"><strong>Reference</strong></th>
	  <th  width="5%"  style="text-align:center"><strong>Direction</strong></th>
     
      
      <th width="5%"  style="text-align:center"><strong>Distance From ROW</strong></th>
      <th width="3%"  style="text-align:center"><strong>No. of Units</strong></th>
      <th  width="5%"  style="text-align:center"><strong>ROW Status</strong></th>
	  <th  width="6%"  style="text-align:center"><strong>Lease Start Date</strong></th>
	  <th  width="6%"  style="text-align:center"><strong>Lease End Date</strong></th>
	          
       
      
      <?php
		}
		else if($sub_component_name=="Line")
		{?>
      <th align="center" width="2%"><strong>Sr. No.</strong></th>
	 	
       <th width="3%"  style="text-align:center"><strong>Road Name</strong></th>
      <th  width="5%"  style="text-align:center"><strong>Road Type</strong></th>
	  <th  width="10%"  style="text-align:center"><strong>component_name</strong></th>
      <th  width="10%"  style="text-align:center"><strong>Attribute Type</strong></th>
	  <th  width="5%"  style="text-align:center"><strong>KMPost</strong></th>
	  <th  width="12%"  style="text-align:center"><strong>Detail</strong></th>
      <th  width="13%"  style="text-align:center"><strong>cat_name</strong></th>
      
        <th width="5%"  style="text-align:center"><strong>DGPS ID</strong></th>
       <th  width="10%"  style="text-align:center"><strong>Range</strong></th>
      <th  width="10%"  style="text-align:center"><strong>Reference</strong></th>
      <th  width="10%"  style="text-align:center"><strong>Length</strong></th>
	
	          
       
      
      <?php
		}
		else if($sub_component_name=="Point")
		{?>
      <th align="center" width="2%"><strong>Sr. No.</strong></th>
	 	
       <th width="3%"  style="text-align:center"><strong>Road Name</strong></th>
      <th  width="5%"  style="text-align:center"><strong>Road Type</strong></th>
	  <th  width="10%"  style="text-align:center"><strong>component_name</strong></th>
      <th  width="10%"  style="text-align:center"><strong>Attribute Type</strong></th>
	  <th  width="5%"  style="text-align:center"><strong>KMPost</strong></th>
	  <th  width="12%"  style="text-align:center"><strong>Detail</strong></th>
      <th  width="13%"  style="text-align:center"><strong>cat_name</strong></th>
      
        <th width="5%"  style="text-align:center"><strong>DGPS ID</strong></th>
       <th  width="10%"  style="text-align:center"><strong>Range</strong></th>
      <th  width="10%"  style="text-align:center"><strong>Reference</strong></th>
      <th  width="10%"  style="text-align:center"><strong>Direction</strong></th>
	
	          
       
      
      <?php
		}
		
		?>
	 
    </tr><?php */?>
  


<?php


if($iCount>0)
{
$i=0;
	while($sSQL3=mysql_fetch_array($sSQL12))
	{
	if($layer_name!="" && $total_rows>=1)
		{	
		?>
        <tr <?php echo $style; ?>>
        <?php				
		 $sql36="Select * from layers_template where component_name='$componentName' and layer_name='$layer_name' order by cat_temp_order asc";
		$res36=mysql_query($sql36);
		while($row36=mysql_fetch_array($res36))
					{	
					 $field_name=$row36["cat_field_name"];
					 ?>
                     <td  style="text-align:left; padding-left:5px;font-size:14px">
<?php echo $sSQL3[$field_name]; ?></td>
                     <?php
					 
					 
					}
					?>
                    </tr>
                    <?php
		}
	else
	{
				
		
		
		$unique_id 					= $sSQL3['oid'];
		$project_name 			= $sSQL3['project_name'];
		$component_name 		= $sSQL3['component_name'];
		$sub_component_name 	= $sSQL3['sub_component_name'];
		$ws_name  				= $sSQL3['ws_name'];
		$cat_name  				= $sSQL3['cat_name'];
		$channel_id  			= $sSQL3['channel_id'];
		$chainage_id  			= $sSQL3['chainage_id'];
		$layer  				= $sSQL3['layer'];
		$code  					= $sSQL3['code'];
		$label  				= $sSQL3['label'];
		$elevation  			= $sSQL3['elevation'];
		$shape_length  			= $sSQL3['shape_length'];
		$shape_area  			= $sSQL3['shape_area'];
		$issue_date  			= $sSQL3['issue_date'];
		$soil_a_depth  			= $sSQL3['soil_a_depth'];
		$soil_b_depth  			= $sSQL3['soil_b_depth'];
		$soil_c_depth  			= $sSQL3['soil_c_depth'];
		$total_depth  			= $sSQL3['total_depth'];
		//$channel_id="No";
			
		?>
		<tr <?php echo $style; ?>>
     
		
<td ><center> <?php echo $i=$i+1;?> </center> </td>

<td style="text-align:left"><a href="detail_link.php?unique_id=<?php echo $unique_id; ?>" style="text-decoration:none" target="_blank">
<?=$channel_id;?></a></td>


<td style="text-align:left" ><?=$component_name;?></td>
<td style="text-align:left"><?=$sub_component_name;?></td>
<td style="text-align:left"><?=$ws_name;?></td>
<td style="text-align:left"><?=$cat_name;?></td>
<td style="text-align:left"><?=$layer;?></td>
<td style="text-align:left"><?=$chainage_id;?></td>
<td style="text-align:left"><?=$code;?></td>
<td style="text-align:left"><?=$elevation;?></td>
<td style="text-align:left"><?=$label;?></td>
<td style="text-align:left"><?=$shape_length;?></td>
<td style="text-align:left"><?=$shape_area;?></td>
			
<td style="text-align:left"><?=$issue_date;?></td>
<td style="text-align:left"><?=$soil_a_depth;?></td>
<td style="text-align:left"><?=$soil_b_depth;?></td>
<td style="text-align:left"><?=$soil_c_depth;?></td>
<td style="text-align:left"><?=$total_depth;?></td>

</tr>

		<?php
		
	}
		      
	}
}
else
{
	?>
    <tr><td colspan="18"><strong><center> No Record Found..... </center></strong> </td></tr>
    <?php
}

?>
</table>



</body>
</html>



