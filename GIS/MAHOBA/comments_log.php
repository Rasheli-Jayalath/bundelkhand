<?php
include("top.php");
$component_name=$componentName;
if($objAdminUser->is_login== false){
	header("location: ../index.php");
}
if($_SESSION['ne_gmc']== 0){
	header("location: ../index.php");
}
 if(isset($_REQUEST['unique_id']))
  {
	  $unique_id=$_REQUEST['unique_id'];
  }
   
   
   if(isset($_REQUEST['cid']))
  {
	 $cid=$_REQUEST['cid'];
  }?>

<?php
 $user_cd	= $objAdminUser->user_cd;
 
 $objAdminUser->setProperty("user_cd", $user_cd);
$objAdminUser->lstAdminUser();
$data = $objAdminUser->dbFetchArray(1);
 $user_type= $data['user_type'];
 //$oid = $_REQUEST['oid'];
 if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Add'])){
//	$layer_name 	= trim($_POST['layer_name']);
	
		 $unique_id = $_REQUEST['unique_id'];
			
			$comments = trim($_POST['comments']);
	
	$sql_upd= "INSERT INTO comments_log(oid,component_name, comment, userid) VALUES ('$unique_id','$component_name', '$comments', '$user_cd')";
	  mysql_query($sql_upd);

			//$orderr=$_POST['order'];
		
//$objCommon->setMessage("Layer attributes Updated successfully",'Info');
  $response = array(
                "type" => "success",
                "message" => "Comments added successfully.");
	
}
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Update'])){
//	$layer_name 	= trim($_POST['layer_name']);
	
		 $unique_id = $_REQUEST['unique_id'];
		
			
			$comments = trim($_POST['comments']);
	
	$sql_upd= "Update comments_log
	set
	component_name='$component_name', 
	comment='$comments',
	userid=$user_cd where oid=$unique_id and cid=$cid and component_name='$component_name'";
	  mysql_query($sql_upd);

			//$orderr=$_POST['order'];
		
//$objCommon->setMessage("Layer attributes Updated successfully",'Info');
  $response = array(
                "type" => "success",
                "message" => "Comments updated successfully.");
	
}


if(isset($_GET['mode']) && $_GET['mode'] == "delete"){
//	$layer_name 	= trim($_POST['layer_name']);
	
		 $unique_id = $_REQUEST['unique_id'];
		$sdelete= "Delete from comments_log where cid=$cid and oid=$unique_id and component_name='$component_name'";
	   mysql_query($sdelete);
	

			//$orderr=$_POST['order'];
		
//$objCommon->setMessage("Layer attributes Updated successfully",'Info');
  /*$response = array(
                "type" => "success",
                "message" => "Comments deleted successfully.");*/
				
				redirect('update_attribute.php?unique_id='.$unique_id);
	
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo HOME_MAIN_TITLE?></title>
<head>

<link href="../css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../menu/chromestyle.css"/>
<?php 
# JS file
importJs("Menu");
importJs("Common");
importJs("Ajax");
importJs("Calendar");
importJs("Lang-EN");
importJs("ShowCalendar");?>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<?php importCss("Login");?>
<?php importCss("Messages");
if($objAdminUser->is_login == true){
	importCss("PjStyles");
}?>
<link rel="stylesheet" type="text/css" media="all" href="../datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="../datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="../datepickercode/jquery-ui.js"></script>
  
  
  <style>
#frm-image-upload{
    padding: 0px;
	margin-left:px;
    background-color: lightblue;
	text-align:center;
}

.form-row {
    padding: 20px;
    border-top: #8aacb7 1px solid;
}

.button-row {
    padding: 10px 20px;
    border-top: #8aacb7 1px solid;
}

#btn-submit {
    padding: 10px 40px;
    background: #586e75;
    border: #485c61 1px solid;
    color: #FFF;
    border-radius: 2px;
}

.file-input {
    background: #FFF;
    padding: 5px;
    margin-top: 5px;
    border-radius: 2px;
    border: #8aacb7 1px solid;
}

.response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
}

.error {
    background: #fdcdcd;
    border: #ecc0c1 1px solid;
}

.success {
    background: #c5f3c3;
    border: #bbe6ba 1px solid;
}
</style>
  
  
	<!---// load jQuery from the GoogleAPIs CDN //--->
	<?php /*?><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script><?php */?>
</head>
<body>
 <?php  include 'includes/headerMainHome.php'; ?> 


 <script>
  $(function() {
    $( "#doc_issue_date" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
	
  });
   $(function() {
    $( "#doc_closing_date" ).datepicker({ dateFormat:'yy-mm-dd'}).val();
	
  });
   $(function() {
    $( "#doc_upload_date" ).datepicker({ dateFormat:'yy-mm-dd'}).val();
	
  });
   $(function() {
    $( "#received_date" ).datepicker({ dateFormat:'yy-mm-dd'}).val();
	
  });
  </script>
  
 
<div style="font-family: Arial; width:1100px; margin-left:20px; margin-top:10px; font-size:24px; font-weight:bold">
<?php echo COMMENTS;?>
 </div>  
<div id="tableContainer" class="table" style="border-left:1px;">
 <a href="detail_link.php?unique_id=<?php echo $unique_id?>" style="float:right; text-decoration:underline; font-weight:bold"> <?php echo BACK?></a>
		<table  width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      
       <td style="width:60%; font-weight:bold; background:#ededed; text-align:center" class="clsleft"><?php echo COMMENTS;?></td>
       <td style="width:10%; font-weight:bold; background:#ededed;text-align:center" class="clsleft"><?php echo "Comment By";?></td>  
       <td style="width:10%; font-weight:bold; background:#ededed; text-align:center" class="clsleft"><?php echo "Date";?></td>     
     
    </tr>
    <?php
	$query4 = "SELECT * FROM comments_log where oid=$unique_id and component_name='$component_name' order by datetime desc";
	//echo $query4;
	 $result4=mysql_query($query4);
	 mysql_num_rows($result4);
 if (mysql_num_rows($result4) > 0) {
	 $i=0;
while($row4 = mysql_fetch_assoc($result4))
{
	$userid=$row4['userid'];
	$cid=$row4['cid'];
	$i=$i+1;
$objAdminUser->setProperty("user_cd", $userid);
$objAdminUser->lstAdminUser();
$data = $objAdminUser->dbFetchArray(1);
 $first_name= $data['first_name'];
  $last_name= $data['last_name'];
 $name= $first_name." ".$last_name;	
		
		
	
		?>
    		<tr bgcolor="<?php echo $bgcolor;?>">
                <td class="clsleft"><a name="<?php echo $cid; ?>"><?php echo $row4['comment'];?></a></td>
                <td class="clsleft">
				<?php 
				 echo $name;?>
                </td>
                <td class="clsleft">
				<?php 
				 echo $row4['datetime'];?>
                </td>
              
    		</tr>

    <?php
		
	
		
	
	}	
 }
 

	?>
  </table>
		</div>

</body>
</html>
        