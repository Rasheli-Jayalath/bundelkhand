<?php
include("top.php");
if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}

?>
<!--<div id="maincol" style="margin-left:13px; background-color:#ebebeb;">-->

<div class="boxsize1" style="min-height:300px">
<div id="wrapper_MemberLogin" style="margin-top:10px; ">

  <div class="clear"></div>

 
<?php
$lat = $_REQUEST['lati'];
$lng = $_REQUEST['lngi'];
$d_in_km = $_REQUEST['dis_km'];
//echo $p2=6371 * acos(cos(radians($lat))* cos(radians(latitude))*cos(radians( longitude )-radians($lng))+ sin(radians($lat) )* sin(radians( latitude ) ) );

 $sql="SELECT code,label_f, count(label_f) as total FROM dgps_survey_data
Where component_name='$componentName' and (6371 * acos(cos(radians($lat) )* cos(radians(latitude))*cos(radians( longitude )-radians($lng))+ sin(radians($lat) )* sin(radians( latitude ) ) ) ) < $d_in_km group by layer order by layer";
//echo $query;
$query=mysql_query($sql);
?>
    <link rel="stylesheet" href="css/table_contents.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    
<div style=" background-color:#046b99;border-radius: 10px; height:35px; width:25%; margin-left:480px;">
<h2 style="color:#FFF; font-size:20px; margin-top:4px; line-height:1.6em; letter-spacing:-1px; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif; margin: 5px 0px 15px 0px; clear: both;"><?php echo ASSETS_STATS?></h2>        
</div> 

<div class="container" style="">
<table class="table table-bordered table-striped table-hover" style="width:60%; margin-top:5px; margin-left:260px">

  <tr style="background: url(images/table_headingBG.png) repeat-x;">
      <th style="text-align:center"><?php echo ATTRIBUTES?></th>
      <th style="text-align:center"><?php echo TOTAL?></th>      
  </tr>
<?php
while($res=mysql_fetch_array($query))
{

 $details=$res['label_f'];
 $total=$res['total'];
 $code=$res['code'];

?>
  
  <tr>
      <td style="text-align:center"><?php echo $details;?></td>
      <td style="text-align:center"><a href="detail_all_buffer.php?label_f=<?php echo $details; ?>&latitude=<?php echo $lat ?>&longitude=<?php echo $lng ?>&d_in_km=<?php echo $d_in_km?>&language=<?php echo $_SESSION['lang']; ?>" target="_blank" style="text-decoration:none"><?php echo $total; ?></a></td>
</tr>
<?php
}
?>
</table>
</div>
</div>
</div>		