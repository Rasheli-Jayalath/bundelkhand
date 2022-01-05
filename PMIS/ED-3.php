<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Key Performance Indicators (KPI)";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($kpid_flag==0)
{
	header("Location: index.php?init=3");
}
$kpi_temp_id			= $_GET['kpi_temp_id'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg	= "";
//This is the default language. We will use it 2 places, so i am put it 
//into a varaible.
$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
    //Based on the lowecase $_GET['language'] value, we will decide,
    //what lanuage do we use
    switch (strtolower($_GET["language"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang'] = 'en';
            break;
        case "rus":
            //If the string is tr or TR
            $_SESSION['lang'] = 'rus';
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang'] = $defaultLang;
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.admin.php');

}
else
{
	require_once('rs_lang.admin_rus.php');

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ED-3 Dashboard</title>
<link rel="stylesheet" type="text/css" href="css/styleNew.css">
<style>
.search_box
{
	width:100%;
	height:60px;
	background-color:#9CF;
	
	margin-top:35px;
	padding-top:30px;
	padding-left:15px;
}
</style>
<script>
function doFilter(frm){
	var qString = '';
	if(frm.district_id.value != ""){
		qString += 'district_id=' + escape(frm.district_id.value);
	}
	if(frm.ws_id.value != ""){
		qString += '&ws_id=' + escape(frm.ws_id.value);
	}
	if(frm.wsrc_id.value != ""){
		qString += '&wsrc_id=' + escape(frm.wsrc_id.value);
	}
	
	document.location = 'ED-3.php?' + qString;
}


</script>
</head>
<body>
<div style="display: inline-block; height:110px;  background-color:#f8f8f8;">
<div style="width:auto; text-align:center">
<a href="./index.php"><img src="images/logo.png"   height="106" title="Home"  align="left" style="border-color:#ccc; border-radius:1px; padding:2px" /></a> 
<div style="width:auto; padding-top:10px">
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:305px" ><?php echo ADMIN_SITE_TITLE;?></span><br/>
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:300px" ><?php echo "ED-3 Dashboard" ;?></span>
</div>
</div>
<br/>
<form action="" target="_self" method="post"  enctype="multipart/form-data">
<div class="search_box">
<strong>District:</strong> <select id="district_id" name="district_id" >
<option value="">Select District</option>
<?php $pdSQLc = "SELECT * FROM  rs_tbl_district  order by district_id";
						 $pdSQLResultc = mysql_query($pdSQLc);
						$i=0;
							  if(mysql_num_rows($pdSQLResultc)>=1)
							  {
							  while($pdDatac = mysql_fetch_array($pdSQLResultc))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatac["district_id"];?>" <?php if($_REQUEST['district_id']==$pdDatac["district_id"]) {?> selected="selected" <?php }?>><?php echo $pdDatac["district_name"];?></option>
   <?php } 
   }?>
</select>
&nbsp;&nbsp;
 <strong>Water Supply Scheme :</strong> <select id="ws_id" name="ws_id" >
  <option value=""> Select Water Supply Scheme</option>
  		<?php $pdSQLc = "SELECT * FROM  rs_tbl_waterschm  order by ws_id";
						 $pdSQLResultc = mysql_query($pdSQLc);
						$i=0;
							  if(mysql_num_rows($pdSQLResultc)>=1)
							  {
							  while($pdDatac = mysql_fetch_array($pdSQLResultc))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatac["ws_id"];?>" <?php if($_REQUEST['ws_id']==$pdDatac["ws_id"]) {?> selected="selected" <?php }?>><?php echo $pdDatac["ws_name"];?></option>
   <?php } 
   }?>
  
  </select>
  &nbsp;&nbsp;<strong>Water Source :</strong> <select id="wsrc_id" name="wsrc_id" >
  <option value=""> Select Water Source</option>
  		<?php $pdSQLd = "SELECT * FROM rs_tbl_watersrc order by wsrc_id";
						 $pdSQLResultd = mysql_query($pdSQLd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultd)>=1)
							  {
							  while($pdDatad = mysql_fetch_array($pdSQLResultd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatad["wsrc_id"];?>" <?php if($_REQUEST['wsrc_id']==$pdDatad["wsrc_id"]) {?> selected="selected" <?php }?>><?php echo $pdDatad["wsrc_name"];?></option>
   <?php } 
   }?>
  
  </select>
  <input type="button"  onclick="doFilter(this.form);" class="SubmitButton" name="Submit" id="Submit" value=" <?php echo VIEW; ?> " />
</div>
</form>
<?php
$sql = "SELECT a.ws_id, a.ed_format_id,(SELECT district_name from rs_tbl_district b where b.district_id=a.district_id) as district_name,(SELECT ws_name from rs_tbl_waterschm c where c.ws_id=a.ws_id) as ws_name, (SELECT wsrc_name from rs_tbl_watersrc d where d.wsrc_id=a.wsrc_id) as wsrc_name, a.noffcr_name, a.noffcr_number, a.dpr_agn_name, a.dpr_nom_name, a.dpr_nom_number, a.pmc_name, a.pmc_address, a.swsmrep_name, a.swsmrep_number, a.contr_name, a.contrnom_name, a.contrnom_number, a.nit_number, a.nit_date, a.nitcr_capex, a.nitcr_opex, a.nitcr_total, a.contawdcr_capex, a.contawdcr_opex, a.contawdcr_total, a.boqupd_status, a.dprst_subm_date, a.dprst_rev_date, a.dprst_vetiit_date, a.dprst_apr_date, a.pmc_cont_date, a.cont_dpr_date, a.techbdo_date, a.finbdo_date, a.remarks, a.fps_advance, a.fps_uptodate_bill, a.dprcost_cr, a.efccost_cr, a.tndbdcost_cr, a.aggrm_date, a.intwtp_noc_date, a.iittovet_date
FROM rs_tbl_edformat a where 1=1 ";
 if(isset($_REQUEST['district_id'])&&$_REQUEST['district_id']!="")
 {
	  $sql .= " AND a.district_id=".$_REQUEST['district_id'];
 }
  if(isset($_REQUEST['ws_id'])&&$_REQUEST['ws_id']!="")
 {
	   $sql .= " AND a.ws_id=".$_REQUEST['ws_id'];
 }
  if(isset($_REQUEST['wsrc_id'])&&$_REQUEST['wsrc_id']!="")
 {
	   $sql .= " AND a.wsrc_id=".$_REQUEST['wsrc_id'];
 }
 $result =mysql_query($sql);
$district_name="";
$distname1="";
?>
<div id="result1" style="margin-top:10px">

<table  cellpadding="0px" cellspacing="0px"   width="110%" align="center"  class="reference" style="border-left:1px #000000 solid; border-top:1px #000000 solid">
<tr style="background:images/table_headingBG.png; padding-bottom:0px; margin-bottom:0px" align="center"><th rowspan="2">EDID</th>
  <th rowspan="2">PMC Alloted Zone /District</th>
  <th rowspan="2">Scheme Name</th>
  <th rowspan="2">Source Name</th>
  <th rowspan="2">Name of Nodal Officer</th>
  <th rowspan="2">DPR Agency Nominated Person</th>
  <th rowspan="2">PMC Name & Address</th>
  <th rowspan="2">PMC Site Engineer & Address</th>
  <th rowspan="2">SWSM Representative</th>
  <th rowspan="2">Contractor & Nominated Person</th>
  <th colspan="3">INR in Crore</th>
  <th rowspan="2">Aggrement Date</th>
  <th rowspan="2">NOC Date</th>
  <th rowspan="2">IIT to Vet Date</th>
  <th rowspan="2">Financial Progress Advance</th>
  <th rowspan="2">Financial Progress UPtoDateBill</th>
  <th rowspan="2">Physical Progress
    </th>
  <th rowspan="2">Land Details</th>
  </tr>
<tr align="center">
  <th>DPR </th>
  <th>EFC</th>
  <th>Tender Bid Cost</th>
  </tr>
  <tr style="vertical-align:middle" align="center">
     <td align="center" style="vertical-align:middle">1</td>
     <td>2</td>
     <td>3</td>
     <td>4</td>
     <td>5</td>
     <td>6</td>
     <td>7</td>
     <td>8</td>
     <td>9</td>
     <td>10</td>
     <td>11</td>
     <td>12</td>
     <td>13</td>
     <td>14</td>
     <td>15</td>
     <td>16</td>
     <td>17</td>
     <td>18</td>
     <td>19</td>
     <td>20</td>
     </tr>
<?php if (mysql_num_rows($result) > 0) {
 $distname1="";
 $i=1;
  // output data of each row
  while($row =mysql_fetch_array($result)) {
	 $district_name=$row['district_name'];
     
	  if($row["ws_id"]!=0)
	  {
	  $sub_query="SELECT * from rs_tbl_sedetails where ws_id=".$row["ws_id"];
	  $eng_rows=mysql_query($sub_query);
	  }
	  
	  $distname=$district_name;
	  $dist_color_code="#ffffff";
	 ?>
   
   <tr style="vertical-align:middle" align="center">
   <td align="center" style="vertical-align:middle"><?php echo $i++; ?></td>
   <td  bgcolor="<?php echo $dist_color_code; ?>" <?php echo (($distname == $distname1 || $distname == "") ? "style='border-top:hidden';" : ""); ?>><?php echo ($distname == $distname1 ? "" : $distname); ?></td>
   <td><?php echo $row["ws_name"]; ?></td>
   <td><?php echo $row["wsrc_name"]; ?></td>
   <td><?php echo $row["noffcr_name"]."<br/>".$row["noffcr_number"]; ?></td>
   <td><?php echo $row["dpr_agn_name"]."<br/>".$row["dpr_nom_name"]."<br/>".$row["dpr_nom_number"]; ?></td>
   <td><?php echo $row["pmc_name"]."<br/>".$row["pmc_address"]; ?></td>
    <td><?php while($sub_rows=mysql_fetch_array($eng_rows))
	{ echo $sub_rows["se_name"]."(".$sub_rows["se_number"].") <br/>"; 
	}?></td>
   <td><?php echo $row["swsmrep_name"]."<br/>".$row["swsmrep_number"]; ?></td>
   <td><?php echo $row["contr_name"]."<br/>".$row["contrnom_name"]."<br/>".$row["contrnom_number"]; ?></td>
  
   <td><?php echo $row["dprcost_cr"]; ?></td>
	 <td><?php echo $row["efccost_cr"]; ?></td>
	 <td><?php echo $row["tndbdcost_cr"]; ?></td>
	 <td><?php echo $row["aggrm_date"];?></td>
	 <td><?php echo $row["intwtp_noc_date"];?></td>
	 <td><?php echo $row["iittovet_date"];?></td>
	 <td><?php echo $row["fps_advance"]; ?></td>
	 <td><?php echo $row["fps_uptodate_bill"]; ?></td>
	 <td style="padding:0; margin:0;"><table width="100%" class="reference">
	 <?php  $act_quey="SELECT a.aid, a.itemid, a.startdate, a.enddate, a.rid, a.baseline, a.temp_id, a.ws_id, a.act_type, b.itemname, c.unit, c.quantity FROM activity a inner join maindata b on(a.itemid=b.itemid) inner join baseline c on (a.rid=c.rid) where a.ws_id=".$row["ws_id"]." AND a.act_type=1";
	 			$act_res=mysql_query($act_quey);
				$act_num=mysql_num_rows($act_res);
				if($act_num>0)
				{?>
      <tr><th>Activities</th>
  <th>Start    Date</th>
  <th>Unit</th>
  <th>Planned</th>
  <th>Achieved</th>
  <th>%    Completed</th></tr>
     <?php while($act_rows=mysql_fetch_array($act_res))
	 {
		 ?><tr height="100.5px">
     <td><?php echo $act_rows["itemname"];?></td>
     <td><?php echo date('d-m-Y', strtotime($act_rows["startdate"]));?></td>
     <td><?php echo $act_rows["unit"];?></td>
     <td><?php echo $act_rows["baseline"];?></td>
     <td><?php echo $act_rows["baseline"];?></td>
     <td><?php if($act_rows["baseline"]!=0&&$act_rows["baseline"]!="")
	 echo number_format($act_rows["baseline"]/$act_rows["baseline"]*100,2);?></td>
     </tr>
     <?php } }?>
     </table></td>
     <td style="padding:0; margin:0;"><table cellpadding="0" cellspacing="0" width="100%" class="reference">
	 <?php  
$work_itemname="";
$workitemname1="";
$act_quey="SELECT a.aid, a.itemid, a.startdate, a.enddate, a.rid, a.baseline, a.temp_id, a.ws_id, a.act_type, b.itemname, c.unit, c.quantity FROM activity a inner join maindata b on(a.itemid=b.itemid) inner join baseline c on (a.rid=c.rid) where a.ws_id=".$row["ws_id"]." AND a.act_type=2";
	 			$act_res=mysql_query($act_quey);
				$act_num=mysql_num_rows($act_res);
				if($act_num>0)
				{?>
      <tr><th>Detail of Work</th>
  <th>Item</th>
  <th>Unit</th>
  <th>Scope</th>
  <th>Achieved</th>
  <th>Balance</th>
  <th>%Completed</th></tr>
     <?php while($act_rows=mysql_fetch_array($act_res))
	 {
		  $sql_progress="SELECT sum(progressqty) as progress from progress where itemid=".$act_rows["itemid"];
		 $prog_res=mysql_query($sql_progress);
		 $prog_row=mysql_fetch_array($prog_res);
		 $sql_p="SELECT parentcd from maindata where itemid=".$act_rows["itemid"];
		 $p_res=mysql_query($sql_p);
		 $prow=mysql_fetch_array($p_res);
		 $parent_cd=$prow["parentcd"];
		 $sql_n="SELECT itemname from maindata where itemid=". $parent_cd;
		 $n_res=mysql_query($sql_n);
		 $nrow=mysql_fetch_array($n_res);
		 $work_itemname=$nrow["itemname"];
		  $workitemname= $work_itemname;
		 ?><tr>
      <td bgcolor="#FFFFFF" <?php echo (($workitemname == $workitemname1 || $workitemname == "") ? "style='border-top:hidden';" : ""); ?>><?php echo ($workitemname == $workitemname1 ? "" : $workitemname); ?></td>
     <td><?php echo $act_rows["itemname"];?></td>
     <td><?php echo $act_rows["unit"];?></td>
     <td><?php echo $act_rows["baseline"];?></td>
     <td><?php echo $prog_row["progress"];?></td>
     <td><?php if($act_rows["baseline"]!=0&&$act_rows["baseline"]!="")
	 echo number_format($act_rows["baseline"]-$prog_row["progress"],2);?></td>
     <td><?php if($act_rows["baseline"]!=0&&$act_rows["baseline"]!="")
	 echo number_format($prog_row["progress"]/$act_rows["baseline"]*100,2);?></td>
     </tr>
     <?php $workitemname1=$workitemname;
	 } }?>
     </table></td>
     

	</tr>
    <?php
							
							$distname1 = $distname;
							?>
  <?php }
  
} else {
  echo '</tr><td colspan="50" >No results</td></tr>';
}

?> 
</table>

</div>
</div>
</body>
</html>