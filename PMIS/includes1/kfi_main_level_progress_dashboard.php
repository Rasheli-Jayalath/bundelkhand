<?php 
if(isset($_REQUEST["obj"])&&$_REQUEST["obj"])
{
	$itemid=$_REQUEST["obj"];
}
else
{
$itemid=650;
}
//SELECT DATE_SUB(max(ipcmonth),INTERVAL 1 MONTH) as ipcmonth from ipc
if(isset($itemid)&& $itemid!="" && $data_level_id==0)
{
function SECLAST_LastIPcNO()
{
	$data2="";
$sql="select (SELECT MAX(ipcmonth) FROM ipc) as maxmonth, (SELECT MAX(ipcmonth) FROM ipc WHERE ipcmonth NOT IN (SELECT MAX(ipcmonth) FROM ipc )) as secipcmonth";
$amountresult = mysql_query($sql);
$data=mysql_fetch_array($amountresult);
if($data["secipcmonth"]!=""|| $data["secipcmonth"]!=NULL)
{
$sql2="SELECT ipcno FROM ipc where ipcmonth='".$data["secipcmonth"]."'";
$amountresult2 = mysql_query($sql2);
$data2=mysql_fetch_array($amountresult2);
}
return $data2;

}
function LastIPcNO()
{
$sql="SELECT ipcno FROM ipc where ipcmonth=(select max(ipcmonth) as ipcmonth  from ipc)";
$amountresult = mysql_query($sql);
$data=mysql_fetch_array($amountresult);
return $data;
}
$ipcnodatasec=SECLAST_LastIPcNO();
$ipcnodata=LastIPcNO();?>
<div id="result4">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >
<tr  id="title">
  <td colspan="12" align="center"></tr>
<tr id="tblHeading">
<th rowspan="2"> Sr. No. </th>
<th rowspan="2">Description </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th> As Per Bid</th>
<th>Paid Upto <?php echo $ipcnodatasec["ipcno"];?></th>
<th>Paid in <?php echo $ipcnodata["ipcno"];?> </th>
<th>Executed Upto <?php echo $ipcnodata["ipcno"];?> </th>
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<th>Amount (Rs.) </th>
<th> Amount(Rs.)</th>
<th> Amount(Rs.)</th>
<th> Amount(Rs.)</th>
</tr>
<?php

function getProgressAmount($itemid)
{
	$sum=0;
 if($itemid!=0&&$itemid!=0&&$itemid!='')
 {
	 $sql="Select * from boq where itemid=".$itemid;
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 while($data=mysql_fetch_array($pamountresult))
	 {
	 $sql2="SELECT * FROM `ipcv`  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"]*$data["boqrate"];
	 $sum=$sum+$amount;
	 }
 return $sum;
 }
}
function getThisProgressAmount($itemid,$ipcid)
{
	$sum=0;
 if($itemid!=0&&$itemid!=0&&$itemid!='')
 {
	 $sql="Select * from boq where itemid=".$itemid;
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 while($data=mysql_fetch_array($pamountresult))
	 {
	 $sql2="SELECT * FROM `ipcv`  WHERE boqid=".$data["boqid"]." AND ipcid=".$ipcid." GROUP BY boqid";
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"]*$data["boqrate"];
	 $sum=$sum+$amount;
	 }
 return $sum;
 }
}
function LastIPcMonth()
{
$sql="SELECT ipcid FROM ipc where ipcmonth=(select max(ipcmonth) as ipcmonth  from ipc)";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$ipciddata=LastIPcMonth();
$ipcid=$ipciddata["ipcid"];
$reportquery="SELECT b.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight, b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty ,sum(b.boqqty* b.boqrate) as total_amount, b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a INNER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=$itemid group by b.itemid";
$reportresult_act = mysql_query($reportquery)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) 
{
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$todate_amount=getProgressAmount($reportdata_act['itemid']);
$this_amount=getThisProgressAmount($reportdata_act['itemid'],$ipcid);
$uptolast_amount=$todate_amount-$this_amount;
$grand_last_amount+=$uptolast_amount;
$grand_this_amount+=$this_amount;
$grand_total+=$reportdata_act['total_amount'];
$total_month_total+=$todate_amount;
?>
<?php ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo $reportdata_act['itemcode']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['itemname']; ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['total_amount']),2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format (($uptolast_amount),2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format($this_amount,2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format (($todate_amount),2) ; ?></td>
<td style="text-align:right;"><?php  if($reportdata_act['total_amount']!=0 && $todate_amount!=0)
{
echo number_format((($todate_amount / $reportdata_act['total_amount'])*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>

<?php
}
?>
<tr align="right" id="grand_total">
<td style="text-align:right;" colspan="2"><strong><?php echo  "Grand Total:"; ?></strong></td>
<?php /*?><td style="text-align:center;"><?php echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:right;">&nbsp;</td><?php */?>
<td style="text-align:right;"><?php  
echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;"><?php  echo  number_format ($grand_last_amount,2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format (($grand_this_amount),2) ; ?></td>
<td style="text-align:right;"><?php  echo  number_format ($total_month_total,2) ; ?></td>
<td style="text-align:right;"><?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>

</table>
</div>



<div style="margin-top:20px;float:none">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center"  style="padding-top:40px">
<tr  id="title">
  <td colspan="200" align="center" style="background-color:#000066"><strong><span style="color:#FFF">IPC WISE Progress</span></strong></td>
 </tr>
<tr id="tblHeading">
<th rowspan="2"> Sr. No. </th>
<th rowspan="2">Description </th>
<th> As Per Bid</th>
<?php $query="SELECT * FROM ipc ";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{?>
    <th colspan="1"><?php echo date('F, Y',strtotime($rows["ipcmonth"]));?> </th>
    <?php
	}?>
<?php }?>
</tr>
<tr id="tblHeading">
<th>Amount (Rs.) </th>
<?php $query="SELECT * FROM ipc ";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{?>
<th>Amount (Rs.) </th>
    <?php
	}?>
<?php }?>
</tr>
<?php $reportquery="SELECT b.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight, b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty ,sum(b.boqqty* b.boqrate) as total_amount, b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a INNER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=$itemid group by b.itemid";
$reportresult_act = mysql_query($reportquery)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) 
{
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$todate_amount=getProgressAmount($reportdata_act['itemid']);
$this_amount=getThisProgressAmount($reportdata_act['itemid'],$ipcid);
$uptolast_amount=$todate_amount-$this_amount;
$grand_last_amount+=$uptolast_amount;
$grand_this_amount+=$this_amount;
$grand_total+=$reportdata_act['total_amount'];
$total_month_total+=$todate_amount;
?>
<?php ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:center;"><?php echo $reportdata_act['itemcode']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['itemname']; ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['total_amount']),2) ; ?></td>
<?php 
$query="SELECT * FROM ipc ";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{
$query2="
SELECT b.boqid , b.itemid, b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate, c.ipcid,c.ipcqty FROM boq b LEFT OUTER JOIN ipcv c ON (b.boqid = c.boqid) where b.boqid=".$reportdata_act['boqid']." AND c.ipcid=".$rows['ipcid'];
$queryresult2 = mysql_query($query2);
$numrows2=mysql_num_rows($queryresult2);
if($numrows2>0)
{
	while($rows2=mysql_fetch_array($queryresult2))
	{

$todate_amount=getProgressAmount($rows2['itemid']);
?>
   <td align="right"><?php echo number_format($todate_amount,2);?></td> 
 <?php $todate_amount=0;}}
 else
 {
 ?>
  <td align="right">0.00</td>
 <?php } ?>
 <?php
 
	}}?> 
</tr>

<?php
}
?>


</table>
</div>
<?php }?>