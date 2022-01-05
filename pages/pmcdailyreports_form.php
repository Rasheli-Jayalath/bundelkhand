<?php
if ($strusername==null  )
	{
		header("Location: ./index.php?init=3");
	}
else if ($newsadm_flag==0  and $newsentry_flag==0)
	{
		header("Location: ./index.php?init=3");
	}


include("./fckeditor/fckeditor.php");
$report_path=DAILYPMCREPORT_PATH;
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST")
{

		 $did		= trim($_POST['did']);
		 $ws_id 		= trim($_POST['ws_id']);
		 $title 		= trim($_POST['title1']);
		 $reportdate 		= date('Y-m-d',strtotime($_POST['reportdate']));
		
		 $reportfile      = $_FILES['reportfile'];
		 $old_report_file =trim($_POST['old_report_file']);
		
		$report_cd = ($_POST['mode'] == "U") ? $_POST['report_cd'] : $objAdminUser->genCode("rs_tbl_dailyReportspmc", "report_cd");		
		$objNews->setProperty("report_cd", $report_cd);
		$objNews->setProperty("did", $did);
		$objNews->setProperty("ws_id", $ws_id);
		$objNews->setProperty("title", $title);
		$objNews->setProperty("reportdate", $reportdate);
		$objNews->setProperty("ordering", 1);		
		if(isset($_FILES["reportfile"]["name"])&&$_FILES["reportfile"]["name"]!="")
		{
		/* Upload the image File */
		import("Image");
		$objImage = new Image($report_path);
		$objImage->setImage($reportfile);
		if(($_FILES["reportfile"]["type"] == "application/pdf")|| ($_FILES["reportfile"]["type"] == "application/msword") || 
	($_FILES["reportfile"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["reportfile"]["type"] == "text/plain") || ($_FILES["reportfile"]["type"] == "image/jpg")|| 
		($_FILES["reportfile"]["type"] == "image/jpeg")|| 
		($_FILES["reportfile"]["type"] == "image/gif") || 
		($_FILES["reportfile"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_report_file){
					@unlink(DAILYPMCREPORT_PATH . $old_report_file);
						
					}
			if($objImage->uploadImage($report_cd)){
				
					$reportfile = $objImage->filename;
					$objNews->setProperty("reportfile",$reportfile);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		
		
		
		if($objNews->actPMCReport($_POST['mode'])){
			$objCommon->setMessage('Daily PMC Report is saved successfully.','Info');
			redirect('./?p=pmcdailyreports_mgmt');
		}
	
	extract($_POST);
}
else
{
	if(isset($_GET['report_cd']) && !empty($_GET['report_cd']))
		$report_cd = $_GET['report_cd'];
	else if(isset($_POST['report_cd']) && !empty($_POST['report_cd']))
		$report_cd = $_POST['report_cd'];
	if(isset($report_cd) && !empty($report_cd))
	{
		$objNews->setProperty("report_cd", $report_cd);
		$objNews->lstPMCReport();
		$data = $objNews->dbFetchArray(1);
		$mode	= "U";
		extract($data);
	}
}
?>
<script>
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	/*var invid=frm.invid.value;
	var id_inv='paymentdate_'+invid;
	alert(id_inv);
	alert(invid);*/
	if(frm.title1.value == ""){
		msg = msg + "\r\n<?php echo "Report Title is required field";?>";
		flag = false;
	}
	if(frm.newsdate.value == ""){
		msg = msg + "\r\n<?php echo "Date is required field";?>";
		flag = false;
	}
	
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
<script language="javascript" type="text/javascript">
function getXMLHTTP2() { //fuction to return the xml http object
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
function doDeleteNewsFile(news_cd,image,name) {

		
			var strURL="<?php echo SITE_URL; ?>delete_image.php?news_cd="+news_cd+"&image="+image+"&name="+name;
		
			var req = getXMLHTTP2();
				
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
						    document.getElementById('delete_'+name).innerHTML=req.responseText;	
						   						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			
		
	}
</script>
<div id="wrapperPRight">
		<div id="pageContentName" class="shadowWhite"><?php echo ($mode == "U") ? 'Application &raquo; Edit Report' : 'Application &raquo; Add PMC Report';?></div>
		<div id="pageContentRight">
		</div>
		<div class="clear"></div>
		<?php echo $objCommon->displayMessage();?>
		<div class="clear"></div>
		<div class="NoteTxt"><?php echo _NOTE;?></div>
		<div id="tableContainer">
		<script type="text/javascript">
		  $(function() {
			$( "#reportdate" ).datepicker();
		  });
		</script>
		<div class="clear"></div>			
	  	    <form name="frmNews" id="frmNews" action="" method="post" onSubmit="return frmValidate(this);" enctype="multipart/form-data">
			
			<input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        	<input type="hidden" name="report_cd" id="report_cd" value="<?php echo $report_cd;?>" />
            
  			<div class="formfield b shadowWhite"><?php echo 'District';?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue">
        <select id="did" name="did" onchange="getDates(this.value)" style="width:242px">
     	<option value="0" selected="selected"><?php echo "Select District"; ?></option>
  		<?php $pdSQL = "SELECT * FROM  tbl_district";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;?>
  <option value="<?php echo $pdData["did"];?>" <?php if($did==$pdData["did"]) {?> selected="selected" <?php }?>><?php echo $pdData["dname"];?></option>
   <?php } 
   }?>
  </select></div>
			<div class="clear"></div>
            <div class="formfield b shadowWhite"><?php echo 'Water Scheme';?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue">
            <select id="ws_id" name="ws_id" onchange="getDates(this.value)" style="width:242px">
     		<option value="0" selected="selected"><?php echo "Select Water Scheme" ?></option>
  		<?php $pdSQL = "SELECT * FROM  rs_tbl_waterschm";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;?>
  <option value="<?php echo $pdData["ws_id"];?>" <?php if($ws_id==$pdData["ws_id"]) {?> selected="selected" <?php }?>><?php echo $pdData["ws_name"];?></option>
   <?php } 
   }?>
  </select></div>
			<div class="clear"></div>
       		<div class="formfield b shadowWhite"><?php echo 'Title';?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue"><input class="rr_input" size="60" type="text" name="title1" id="title1" value="<?php echo $title;?>" /></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'PMC Report Date';?> <span style="color:#FF0000;">*</span>:</div>
			<div class="formvalue">
			<input type="text" class="rr_input" id="reportdate" name="reportdate" value="<?php if($reportdate!="")
			echo date('Y-m-d',strtotime($reportdate));?>" />
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'Upload File';?>:</div>
			<div class="formvalue">
			<input type="file" name="reportfile" id="reportfile" size="25" />
            <input type="hidden" name="old_report_file" value="<?php echo $reportfile;?>" />
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite">&nbsp;</div>
			<div class="formvalue">							
			<?php /*?><div id="delete_newsfile">
                        <?php if($newsfile!="") {?>
                        <a href="<?php echo NEWS_URL.$newsfile ;?>"  target="_blank"><img src="<?php echo NEWS_URL.$newsfile ;?>" width="40px" height="40px" /></a>
                       <a   onClick="doDeleteNewsFile(<?php echo $news_cd;?>,'<?php echo $newsfile;?>','newsfile');" href="javascript:void(null)">Remove Image?</a>
					   
					 
                        <?php }?>
						</div><?php */?>
			</div>
			<div class="clear"></div>
			
			
			<div class="clear"></div>		
					
			<div id="submit" style="margin-left:164px;"><input type="submit" class="SubmitButton" value="Save" /></div>
					  <div id="submit2">
					  <input type="button" class="SubmitButton" value=" Cancel " onclick="javascript: history.back(-1);" />
					  </div>
			<div class="clear"></div>
		    </form>
			<div class="clear"></div>
  	    </div>
	</div>







<!--<div class="title_div">
	<div style="float:left;padding-top:3px;"><?php echo ($mode == "U") ? 'Application &raquo; News Edit' : 'Application &raquo; News Add';?></div>
    <div style="float:right; padding:0px 2px 2px; *padding: 0 4px 2px 2px;">
        <a href="javascript:void(null);" onclick="history.go(-1);" class="lnkButton"><?php echo _BTN_BACK;?></a>
    </div>
</div>
<div align="left" style="padding-left:6px;"><?php echo _NOTE;?></div>
<div class="rr_form">
	<?php echo $objCommon->displayMessage();?>
	<br />
	<div id="divUpdate">
    <form name="frmContent" id="frmContent" action="" method="post">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="news_cd" id="news_cd" value="<?php echo $news_cd;?>" />
		
		<div class="frmCaption"><?php echo 'Language';?> <span style="color:#FF0000;">*</span> </div><div class="frmDot">:</div>
        <div class="frmElement">
        <select name="language_cd" id="language_cd" class="rr_select" style="width:200px;">
			<option value="" selected>--- Language ---</option>
			<?php echo $objCommon->langCombo($language_cd);?>
		</select>
        </div>
		<br />
		<?php if($vResult['language_cd']){?>
		<div class="frmCaption">&nbsp;</div><div class="frmDot">&nbsp;</div><div class="frmElement">
		<div class="msgError"><?php echo $vResult['language_cd'];?></div></div>
		<br />
		<?php }?>
		
		<div class="frmCaption"><?php echo 'Title';?> <span style="color:#FF0000;">*</span></div><div class="frmDot">:</div>
        <div class="frmElement"><input class="rr_input" size="60" type="text" name="title" id="title" value="<?php echo $title;?>" /></div>
		<br />
        <?php if($vResult['title']){?>
        <div class="frmCaption">&nbsp;</div><div class="frmDot">&nbsp;</div><div class="frmElement">
		<div class="msgError"><?php echo $vResult['title'];?></div></div>
		<br />
		<?php }?>
		
		<div class="frmCaption"><?php echo 'Short';?> <span style="color:#FF0000;">*</span></div><div class="frmDot">:</div>
        <div>&nbsp;</div>
        <div style="clear:both;">
        <textarea name="short" id="short" cols="70" rows="15"><?php echo stripslashes($short);?></textarea>
        <script type="text/javascript">
		//<![CDATA[
			CKEDITOR.replace( 'short',{toolbar : toolBarSet});
		//]]>
		</script>
		</div>
		<br />
		<?php if($vResult['short']){?>
        <div class="frmCaption">&nbsp;</div><div class="frmDot">&nbsp;</div><div class="frmElement">
		<div class="msgError"><?php echo $vResult['short'];?></div></div>
		<br />
		<?php }?>
		
		<div class="frmCaption"><?php echo 'Details';?> <span style="color:#FF0000;">*</span></div><div class="frmDot">:</div>
        <div>&nbsp;</div>
        <div style="clear:both;">
        <textarea name="details" id="details" cols="70" rows="15"><?php echo stripslashes($details);?></textarea>
        <script type="text/javascript">
		//<![CDATA[
			CKEDITOR.replace( 'details',{toolbar : toolBarSet});
		//]]>
		</script>
		</div>
		<br />
		<?php if($vResult['details']){?>
        <div class="frmCaption">&nbsp;</div><div class="frmDot">&nbsp;</div><div class="frmElement">
		<div class="msgError"><?php echo $vResult['details'];?></div></div>
		<br />
		<?php }?>
		
		<div class="frmCaption"><?php echo 'Status';?> <span style="color:#FF0000;">*</span> </div><div class="frmDot">:</div>
        <div class="frmElement">
        <input type="radio" name="status" checked="checked" value="Y" /> Active 
        <input type="radio" name="status" value="N" <?php echo ($status == "N") ? "checked" : "";?> /> Inactive
        </div>
		<br />
		
        <div id="div_button">
            <input type="submit" class="rr_button" value="<?php echo _BTN_SAVE;?>" />
            <input type="button" class="rr_button" value="<?php echo _BTN_CANCEL;?>" onClick="document.location='./?p=news_mgmt';" />
        </div>
        </form>
    </div>
</div>-->