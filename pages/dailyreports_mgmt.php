<?php
if ($strusername==null  )
	{
		header("Location: ../index.php?init=3");
	}
else if ($news_flag==0)
	{
		header("Location: ../index.php?init=3");
	}

if($_GET['mode'] == 'delete'){
	$objNews->setProperty('report_cd', $_GET['report_cd']);
	 $sql_ii="SELECT * FROM `rs_tbl_dailyReports` where report_cd='$_GET[report_cd]'"; 
		$sql_newi=mysql_query($sql_ii);
		$sql_resnew=mysql_fetch_array($sql_newi);
		if($sql_resnew['reportfile']!="")
		{
		@unlink(REPORT_PATH . $sql_resnew['reportfile']);
		}
		
	$objNews->actReport('D');
	
	$objCommon->setMessage('Report deleted successfully!', 'Info');
	redirect('./?p=dailyreports_mgmt');
}

?>
<style>
table.issues_info
{
padding:0px;
border:1px solid #d4d4d4;
border-collapse:collapse;width:100%;

}
table.issues_info tr:nth-child(odd)	{background-color:#ffffff;}
table.issues_info tr:nth-child(even){background-color:#ffffff;}

table.issues_info tr.fixzebra	{background-color:#f1f1f1;}

table.issues_info th{
	color:#ffffff;background-color:#555555;border:1px solid #555555;padding:9px;vertical-align:top;text-align:left;
}

table.issues_info th a:link,table.reference th a:visited{
	color:#000000;
	border:1px solid #d4d4d4;
	
	padding:6px;
	margin:6px;
	width:120px;
}
table.issues_info th a:hover,table.reference th a:active{
	color:#EE872A;
	border:1px solid #d4d4d4;
	padding:6px;
	margin:6px;
	width:120px;
}
table.issues_info td{
	border:1px solid #d4d4d4;padding:5px;padding-top
	
	:7px;padding-bottom:7px;vertical-align:top;
}

table.issues_info td.example_code
{
vertical-align:bottom;
}

</style>
<div id="wrapperPRight">
		<div id="pageContentName"><?php echo "Reports Management";?></div>
		<?php /*if($_SESSION['ne_user_type']==1)
				{*/
				?>
		<div id="pageContentRight">
			<div class="menu1">
				<ul>
				
				<?php if($newsentry_flag==1 || $newsadm_flag==1)
				{
				?>
				<li><a href="./?p=dailyreports_form&amp;mode=add" class="lnkButton"><?php echo "Add New Report";?>
					</a></li>
				<?php
				}
				?>
					</ul>
				<br style="clear:left"/>
			</div>
		</div>
		<?php
		//}
		?>
		<div class="clear"></div>
			
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
        
		 <table class="issues_info" width="100%" style="background-color:#FFF; margin-top:10px" cellspacing="0" >
       
        <thead>
                                <tr>
                                  <th width="2%" style="text-align:center; font-size:13px; vertical-align:middle">Sr#</th>
                                  <th width="20%" style="text-align:center; font-size:13px;">Title</th>
                                  <th width="28%" style="text-align:center;font-size:13px;">Report Date</th>
                                  <th width="10%" style="text-align:center;font-size:13px;">File</th>
								 
								  <?php if($newsentry_flag==1 || $newsadm_flag==1)
								  {
								   ?>
								 <th width="10%" style="text-align:center;font-size:13px;" colspan="2">Action</th>
								  <?php
								 }
								  ?>
								 
								  
								  
                                </tr>
                              </thead>
       		
 <?php
 	
	$objNews->setProperty("orderby", "reportdate desc");
	//$objNews->setProperty("limit", PERPAGE);
	$objNews->lstReport();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objNews->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
            
            <tr>
                          <td align="center" style="font-size:13px"><?php echo $sno;?></td>
                          <td align="left" style="font-size:13px"><?php echo $rows['title'];?></td>
                          <td align="center" style="font-size:13px"><?php echo $rows['reportdate'];?></td>
                          <td align="center" style="text-align:center">
                          <a href="<?php echo REPORT_URL.$rows['reportfile'];?>" target="_blank">
                          <img src="images/pdf.png" width="30" height="30"/></a></td>
                         				 
						    
						   <td align="center" style="font-size:13px; text-align:center">
                           <?php if($newsentry_flag==1 || $newsadm_flag==1)
								 {
								   ?>
						    <a href="./?p=dailyreports_form&mode=edit&report_cd=<?php echo $rows['report_cd'];?>" style="text-decoration:none"title="Edit">Edit</a>
						  
						   
						   <?php  
								 }
							if($newsadm_flag==1)
								  {
								   ?>
								    | <a onClick="return doConfirm('Are you sure to delete this report?');" href="./?p=dailyreports_mgmt&mode=delete&report_cd=<?php echo $rows['report_cd'];?>" style="text-decoration:none" title="Delete">Delete</a>
						   <?php
						   }
						   ?>
						 </td> 
                        </tr>
                        
			
			
			
    		<?php
			$sno++;
		}
    }
	else{
	?>
    <tr>
    	<td colspan="6" align="center"><?php echo 'No Report found.';?></td>
    </tr>
    <?php
	}
	?>
	
		 </table>
	  </form>
	</div>

	