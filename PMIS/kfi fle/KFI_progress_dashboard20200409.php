<?php //include('kfi-top-cache.php'); ?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($kfid_flag==0)
{
	header("Location: index.php?init=3");
}
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
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg	= "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/styleNew.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
<script>
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
	
function getNextLevel(val,id)
{
	var idv=id;
	var res =idv.split("_");
	var div_id=parseInt(res[1])+1;
	var div_name="str_obj_div_"+div_id;
	if (val!=0) {
			var strURL="findnextlevel.php?parentcd="+val+"&div_id="+div_id;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById(div_name).innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 

}
function GetNextLevel(value,div_name)
{
	/*alert(div_name);
	alert(value);*/
	var str=div_name;
	var div_id=str.substr(7, 8);
	
	 var nextlevel;
	
	  if(value==0)
	  {
	   document.getElementById("str_obj_div_"+div_id).innerHTML=xmlhttp.responseText;
	  document.getElementById("str_obj_div_"+div_id).style.display="none";
	  document.getElementById("str_obj_div_"+div_id).style.visibility="hidden";
	  document.getElementById("lab_"+div_id).style.display="none";
	  document.getElementById("lab_"+div_id).style.visibility="hidden";
	  }
	  else
	  {
		    div_id=parseInt(div_id)+1;
	   if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttpN=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttpN=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttpN.onreadystatechange=function() {
    if (xmlhttpN.readyState==4 && xmlhttpN.status==200) {
		
		 document.getElementById("level_count").value=xmlhttpN.responseText;
	}
  }
	
  xmlhttpN.open("GET","findnextlevelboqcount.php?parentgroup="+value+"&div_id="+div_id,true);
  xmlhttpN.send();
	/////////////////////////////////////
	
	nextlevel= document.getElementById('level_count').value;
	
	if(nextlevel>0)
	{
	 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
      document.getElementById("str_obj_div_"+div_id).innerHTML=xmlhttp.responseText;
	  document.getElementById("str_obj_div_"+div_id).style.display="";
	  document.getElementById("str_obj_div_"+div_id).style.visibility="visible";
	  document.getElementById("lab_"+div_id).style.display="";
	  document.getElementById("lab_"+div_id).style.visibility="visible";
      
	 
    }
  }


  xmlhttp.open("GET","findnextlevelboq.php?parentgroup="+value+"&div_id="+div_id,true);
  xmlhttp.send();
	}
	  }
}
</script>
</head>
<body>
<div style="display: inline-block; height:110px; background-color:#f8f8f8;">
<div style="width:auto;">
<a href="./index.php"><img src="images/logo.png"   height="106" title="Home"  align="left" style="border-color:#ccc; border-radius:1px; padding:2px" /></a>
<div style="width:auto; padding-top:10px">
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:305px" ><?php echo ADMIN_SITE_TITLE;?></span><br/>
<span style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#333; font-weight:bold; padding-left:297px" ><?php echo KFI_DASHBOARD;?></span>
</div>
</div>
<table cellpadding="4px" cellspacing="0px" align="center" width="100%" style="border: solid 1px #ccc;" > 
<tr> 
<td width="20%" align="left" valign="top" style="border-right: solid 1px #ccc;"><div id="wrapper_MemberLogin" style="width:400px;margin:10px;">
  <h1 style="color:#000;"><?php echo KFI_MN_DASHBOARDS;?> </h1>
  <div class="clear"></div>
  <div id="LoginBox" class="borderRound borderShadow" style="padding:10px">
    <form action="KFI_progress_dashboard.php" method="get" name="main_dash" id="main_dash" >
    <input type="hidden" id="level_count" name="level_count" value="1" />
      <table border="0px" cellpadding="0px" cellspacing="0px" align="center"  >
      <?php $mquery = "select max(activitylevel) as max_activitylevel from boqdata ";
				$mresult = mysql_query($mquery);
				$mdata = mysql_fetch_array($mresult); 
				$max_activitylevel=$mdata["max_activitylevel"]+1;
				$i=0;
				$levl="";
				while( $i<=$max_activitylevel)
				{
					if($i==0) $level="Project / проект ";
					elseif($i==1) $level="Component|Package / Компонент|пакет";
					elseif($i==2) $level="Sub Component / Подкомпонент ";
					else $level=" Activity / Мероприятия";
				?>
                <?php if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!=""&&$_GET["itemid_".$i]!=0) { 
				 echo $_GET["itemid_".$i]; }?>
        <tr>
          <td ><strong>
           <label id="lab_<?php echo $i;?>" style="<?php if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!=""&&$_GET["itemid_".$i]!=0) { ?> display:block; visibility:visible <?php } elseif($i!=0){?> display:none; visibility:hidden <?php } ?>"  > <?php echo $level;?>: </label>
          </strong></td>
          <td><div id="str_obj_div_<?php echo $i;?>" style="<?php if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!=""&&$_GET["itemid_".$i]!=0) { ?> display:block; visibility:visible <?php } elseif($i!=0){?> display:none; visibility:hidden <?php } ?>" >
            <select name="itemid_<?php echo $i;?>" id="itemid_<?php echo $i;?>" onchange="GetNextLevel(this.value,this.name)">
             <option value="0"><?php echo $level;?> <?php  ?> Level </option>
              <?php
			     $str_lenght=strlen($_GET["itemid_".$i]);
			     if(isset($_GET["itemid_".$i]) && $_GET["itemid_".$i]!="" && $str_lenght<6)
				 {
			      
				 if($str_lenght<6)
				 {
					 $str_g_query = "select * from boq ";
					  if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!="")
				 {
					 $substr_g_query = "select * from boq where boqid=".$_GET["itemid_".$i];
					 $subres=mysql_query($substr_g_query);
					 $subrows=mysql_fetch_array($subres);
					 if(isset($subrows["itemid"])&&$subrows["itemid"]!="")
					 {
					$str_g_query .=" where itemid='".$subrows["itemid"]."'";
					 }
				 }
				 }
				 }
				 else
				 {
				   $str_g_query = "select * from boqdata where  activitylevel=".$i;
				 if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!="")
				 {
					//$str_g_query .=" and parentgroup='".$_GET["itemid_".$i]."'";
				 }
				 }
				//echo $str_g_query;
				$str_g_result = mysql_query($str_g_query);
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
					if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!=""&&$str_lenght<6)
				 {
					
					$code=$str_g_data['boqcode'];
					$itemname=$str_g_data['boqitem'];
					$value=$str_g_data['boqid'];
					
				 }
					else
					{
					$code=$str_g_data["itemcode"];
					$itemname=$str_g_data["itemname"];
					$value=$str_g_data["parentgroup"];	
					}
					
				?>
		    <option value="<?php echo $value; ?>"  <?php if(isset($_GET["itemid_".$i])&&$_GET["itemid_".$i]!=""&&$_GET["itemid_".$i]==$value)
			{?> selected="selected" <?php }?>>
								<?php echo $code."-".$itemname; ?>
								</option>
							  <?php
				}
				?>
            </select>
          </div></td>
        </tr>
        <?php
		$i++ ; 
		}?>
        
         <tr >
          <td style="padding-top:20px" align="center" colspan="2">
            <input type="submit" value="<?php echo REPORT_BTN;?>"  id="uLogin2"/>
            </td>
            <td></td>
            </tr>
      </table>
     
    </form>
  </div>
</div>
  <script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" />      
</td>
<td width="80%" align="left" valign="top">
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<script src="highcharts/js/modules/jquery.highchartTable.js"></script>

    <?php  

//////////Activity  Title here
$url=basename($_SERVER['REQUEST_URI']);
list($str1,$str2)=explode('?',$url);
$param=explode('&',$str2);
$temp_levels=explode('=',$param[0]);
$temp_id=$temp_levels[1];?>

<?php
$actlevel=1;
$parentgroup="";
$subquery="";
 $size=count($param);
if($size>1)
{
$para_count= count($param);
$j=$para_count;
$count=$size;
for($i=0; $i<=$para_count; $i++)
{
	
$data_levels=explode('=',$param[$i]);
$data_level_id=$data_levels[1];
$data_level_param=$data_levels[0];
if($data_level_id!=0)
{
	
	if($count<$size)
	{
	//$parentgroup.="_";	
	
	}
	$itemid=$data_level_id;
	$count--;
}
}
if($itemid!=""&&$itemid!=0)
{

  $gdetailq="SELECT itemid,itemname, isentry from boqdata where parentcd='".$itemid."'";
 $gdetailqresult = mysql_query($gdetailq);
  $gcount=mysql_num_rows($gdetailqresult);
  if($gcount>0)
  {
	
	$actlevel=0;
	
  }
  else
  {
	  $actlevel=1;
	 }
}
}

?>
<?php  include("includes/kfi_main_level_progress_dashboard.php");?>           
<?php  //include("includes/kfi_data_level_progress_dashboard.php");?>

</td>
</tr>
</table>
 
<?php //include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb ->close( );
?>
<?php //include('kfi-bottom-cache.php'); ?>