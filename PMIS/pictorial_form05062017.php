<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
$uname			= $_SESSION['uname'];
$admflag		= $_SESSION['admflag'];
/*$superadmflag	= $_SESSION['superadmflag'];
$payrollflag	= $_SESSION['payrollflag'];
$petrolflag		= $_SESSION['petrolflag'];
$petrolEntry	= $_SESSION['petrolEntry'];
$petrolVerify	= $_SESSION['petrolVerify'];
$petrolApproval	= $_SESSION['petrolApproval'];
$petrolPayment	= $_SESSION['petrolPayment'];*/
if ($uname==null  ) {
header("Location: index.php?init=3");
} 
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";

$file_path="pictorial_data/";
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
function getExtention($type){
	if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
		return "jpg";
	elseif($type == "image/png")
		return "png";
	elseif($type == "image/gif")
		return "gif";
	elseif($type == "application/pdf")
		return "pdf";
	elseif($type == "application/msword")
		return "doc";
	elseif($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		return "docx";
	elseif($type == "text/plain")
		return "doc";
		
}
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
if(isset($_REQUEST['phid']))
{
$phid=$_REQUEST['phid'];
$pdSQL1="SELECT phid, pid, al_file, ph_cap FROM  project_photos  WHERE pid= ".$pid." and  phid = ".$phid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);
$al_file=$pdData1['al_file'];
$ph_cap=$pdData1['ph_cap'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['phid'])&$_REQUEST['phid']!="")
{
@unlink($al_file.$al_file);
 mysql_query("Delete from  project_photos where phid=".$_REQUEST['phid']);
 header("Location: pictorial_form.php");
}
//$size=50;
//$max_size=($size * 1024 * 1024);
if(isset($_REQUEST['save']))
{ 
    $ph_cap=$_REQUEST['ph_cap'];
	$date_p=date("Y-m-d",strtotime($_REQUEST['date_p']));
	//echo $name_array = $_FILES['al_file']['name'];
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	$file_name=genRandom(5)."-".$pid. ".".$extension;
   
	if(($_FILES["al_file"]["type"] == "application/pdf")|| ($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
	$sql_pro=mysql_query("INSERT INTO  project_photos(pid, al_file,ph_cap,date_p) Values(".$pid.", '".$file_name."', '".$ph_cap."', '".$date_p."' )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	} else {
    $message= mysql_error($db);
	}
	}
	}
	}
	$al_file='';
	
	header("Location: pictorial_form.php");
	
}

if(isset($_REQUEST['update']))
{
$ph_cap=$_REQUEST['ph_cap'];
$pdSQL = "SELECT a.phid, a.pid, a.al_file,a.date_p FROM  project_photos a WHERE a.pid = ".$pid." and a.phid=".$phid." order by phid";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
$date_p=$pdData["date_p"];
$phid=$_REQUEST['phid'];
$old_al_file= $pdData["al_file"];
$date_p= $_REQUEST["date_p"];
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path . $old_al_file);
			}
					
				}
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
		$extension=getExtention($_FILES["al_file"]["type"]);
		$file_name=genRandom(5)."-".$pid. ".".$extension;
  
	if(
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png")&&($_FILES["al_file"]["size"] < $max_size))
	{ 
	
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
    $sql_pro="UPDATE  project_photos SET ph_cap='$ph_cap', al_file='$file_name' , date_p='$date_p' where phid=$phid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}
	}
	}
	else
	{
	echo "Invalid File Format";
	}
	}
	else
	{
	 $sql_pro="UPDATE  project_photos SET ph_cap='$ph_cap' where phid=$phid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}
	}
header("Location: pictorial_form.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<!--<link rel="stylesheet" type="text/css" href="css/style.css">-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>
<script>
function showResult(strmodule,strstage,stritemcode,stritemname,strweight,strisentry) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
      document.getElementById("search").innerHTML=xmlhttp.responseText;
      document.getElementById("search").style.border="1px solid #A5ACB2";
	   document.getElementById("without_search").style.display="none";
	  document.getElementById("without_search").disabled=true;
	// document.getElementById("without_search").removeClass("checkbox").addClass("");
	  var nodes = document.getElementById("without_search").getElementsByTagName('*');
			for(var i = 0; i < nodes.length; i++){
			 $("#cvcheck").attr( "class", "" ); 
				 nodes[i].disabled = true;
			}
	 
    }
  }

  xmlhttp.open("GET","search.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&weight="+strweight+"&isentry="+strisentry,true);
  xmlhttp.send();
}

</script>
<script>
function add_data(id) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtcode = document.getElementById('txtcode').value;
var txtscheduleid = document.getElementById('txtscheduleid').value;
var txtstartdate = document.getElementById('txtstartdate').value;
var txtenddate = document.getElementById('txtenddate').value;
var txtastartdate = document.getElementById('txtastartdate').value;
var txtaenddate = document.getElementById('txtaenddate').value;
var txtorder = document.getElementById('txtorder').value;
var txtbaseline = document.getElementById('txtbaseline').value;
var txtweight = document.getElementById('txtweight').value;
var txtremarks = document.getElementById('txtremarks').value;

  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	document.getElementById("abc"+id).innerHTML=xmlhttp1.responseText;
		 document.getElementById("addnew"+id).style.display="block";
		
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	  
	
	 
    }
  }

  xmlhttp1.open("GET","adddata.php?itemid="+id+"&code="+txtcode+"&secheduleid="+txtscheduleid+"&startdate="+txtstartdate+"&enddate="+txtenddate+"&actualstartdate="+txtastartdate+"&actualenddate="+txtaenddate+"&aorder="+txtorder+"&baseline="+txtbaseline+"&remarks="+txtremarks+"&weight="+txtweight,true);
  xmlhttp1.send();
}

</script>


<script>
function edit_data(id,itemid) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }


  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
	
      document.getElementById("abc"+itemid).innerHTML=xmlhttp1.responseText;
	   document.getElementById("addnew"+itemid).style.display="none";
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	  
	
	 
    }
  }
var url="editdata.php?aid="+id+"&itemid="+itemid;

  xmlhttp1.open("GET","editdata.php?aid="+id+"&itemid="+itemid,true);
  xmlhttp1.send();
}

</script>
<script>
function update_data(aid) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtitemid = document.getElementById('itemid').value;
var txtcode = document.getElementById('txtcode').value;
var txtscheduleid = document.getElementById('txtscheduleid').value;
var txtstartdate = document.getElementById('txtstartdate').value;
var txtenddate = document.getElementById('txtenddate').value;
var txtastartdate = document.getElementById('txtastartdate').value;
var txtaenddate = document.getElementById('txtaenddate').value;
var txtorder = document.getElementById('txtorder').value;
var txtbaseline = document.getElementById('txtbaseline').value;
var txtweight = document.getElementById('txtweight').value;
var txtremarks = document.getElementById('txtremarks').value;

  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+txtitemid).innerHTML=xmlhttp4.responseText;
	  document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }

  xmlhttp4.open("GET","updatedata.php?aid="+aid+"&itemid="+txtitemid+"&code="+txtcode+"&secheduleid="+txtscheduleid+"&startdate="+txtstartdate+"&enddate="+txtenddate+"&actualstartdate="+txtastartdate+"&actualenddate="+txtaenddate+"&aorder="+txtorder+"&baseline="+txtbaseline+"&remarks="+txtremarks+"&weight="+txtweight,true);
  xmlhttp4.send();
}

</script>
<script>
function cancel_data(id) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	document.getElementById("abc"+id).innerHTML=xmlhttp1.responseText;
		 document.getElementById("addnew"+id).style.display="block";
		
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	  
	
	 
    }
  }

  xmlhttp1.open("GET","canceldata.php?itemid="+id,true);
  xmlhttp1.send();
}

</script>
<script type="text/javascript">
	
   $(function() {
    $( "#date_p" ).datepicker();
  });

</script>
<script>

function closediv(id)
{
$('div[class^="msg_body"]').hide(); 
}
function atleast_onecheckbox(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
}
</script>
<script>
function group_checkbox2()
{
	var select_all = document.getElementById("txtChkAll2"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox2"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.with_search .checkbox2:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}
</script>
<script>
function group_checkbox()
{
	var select_all = document.getElementById("txtChkAll"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}

function target_popup() {
   var myForm = document.getElementById('stgt_goal').value;

}

function add_sd(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  function add_ed(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  function add_asd(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  function add_aed(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
</script>

<style type="text/css">
<!--
.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
-->
</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 


<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	position: relative;
    display: inline-block;
	cursor:pointer;
   /* border-bottom: 1px dotted black;*/

}
.msg_head .tooltiptext {
	cursor:pointer;
    visibility: hidden;
    width: 80px;
    background-color: gray;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.msg_head:hover .tooltiptext {
    visibility: visible;
}
.msg_body{
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}
</style>

</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
<h1> Pictorial Analysis Control Panel</h1>
<table style="width:100%; height:100%">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Photos/Videos</span><span style="float:left">
    <form action="location_form.php" method="post"><input type="submit" name="back" id="back" value="Locations" /></form>
    </span><span style="float:right"><form action="analysis.php" method="post"><input type="submit" name="ana" id="ana" value="Analysis" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="pictorial_form.php" target="_self" method="post"  enctype="multipart/form-data">
  <?php if(isset($_REQUEST['phid'])&&$_REQUEST['phid']!="")
         {$ppdSQL = "SELECT a.phid, a.pid, a.al_file,a.date_p FROM  project_photos a WHERE a.pid = ".$pid." and a.phid=".$_REQUEST['phid']." order by phid";
		$ppdSQLResult = mysql_query($ppdSQL);
		$sql_num=mysql_num_rows($ppdSQLResult);
		$ppdData = mysql_fetch_array($ppdSQLResult);
		$date_p=$ppdData["date_p"];
		 }
?>
  <table border="1" width="100%" height="100%">
  <tr><td><label><?php echo "Location:";?></label></td>
  <td><select id="ph_cap" name="ph_cap">
     <option value="0">Select Location</option>
  		<?php $pdSQL = "SELECT lid, pid, title FROM  locations WHERE pid=".$pid." order by lid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;?>
  <option value="<?php echo $pdData["lid"];?>" <?php if($ph_cap==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
   <?php } 
   }?>
  </select></td>
  </tr>
  <tr><td><label><?php echo "Date:";?></label></td>
  <td><input type="text" name="date_p" id="date_p" value="<?php 
  if(isset($date_p)&&$date_p!=""&&$$date_p!="0000-00-00"&&$date_p!="1970-01-01")
						  {
							  echo date('d-m-Y',strtotime($date_p));
						  }?>"   size="100"/></td>
  </tr>
  <tr><td><label><?php echo "Photo:";?></label></td>
  <td><input  type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>" /></td>
  </tr>
  <tr><td colspan="2"> <?php if(isset($_REQUEST['phid']))
	 {
		 
	 ?>
     <input type="hidden" name="phid" id="phid" value="<?php echo $_REQUEST['phid']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" />
	 <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	
  </form> 
  </td></tr>
  <tr>
  <td>
   <div style="overflow-y: scroll; height:360px;">
  <table class="reference" style="width:100%" > 

    
                              <thead>
                                   <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="30%" style="text-align:left">Location</th>
                                  <th width="30%" style="text-align:center">Photo</th>
								 <th width="25%" style="text-align:left">Date</th>
								  <th width="10%" style="text-align:center">Action</th>
								
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						
						$pdSQL = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title FROM  project_photos a inner join locations b on(a.ph_cap=b.lid) WHERE a.pid=".$pid." order by phid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="left"><?php echo $pdData['title'];?></td>
                          <td align="center"><img src="<?php echo $file_path.$pdData["al_file"];?>"  width="50" height="50"/></td>
                          <td align="left"><?php 
						  if(isset($pdData["date_p"])&&$pdData["date_p"]!=""&&$pdData["date_p"]!="0000-00-00"&&$pdData["date_p"]!="1970-01-01")
						  {
							   echo date('d-m-Y',strtotime($pdData["date_p"]));
						  }?></td>
                       
						   <td align="right"><span style="float:left"><form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
                        </div>
                        </td>
                        </tr>
  </table>
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
