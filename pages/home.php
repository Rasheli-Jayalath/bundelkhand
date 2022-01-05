<div id="wrapperPRight">
<div style="text-align:right; padding:5px; text-decoration:none"><a  style="text-align:right; padding:10px; text-decoration:none" href="./?p=my_profile" title="header=[My Profile] body=[&nbsp;] fade=[on]">
<?php 
echo  "Welcome"." ".$objAdminUser->ne_fullname_name;   ?>
 
<?php 
echo   " [" ;
			if($objAdminUser->ne_user_type==1)  
			echo "SuperAdmin";
			elseif($objAdminUser->ne_user_type==2&&$objAdminUser->ne_member_cd==0)
			echo "SubAdmin";
			else
			echo "User";
			echo "]";

	?> 
   </a> <?php /*?> <a href="./?language=en">English</a> | <a href="./?language=rus">Russian</a><?php */?> </div>
		<div id="tableContainer">		 
			<table width="100%"  align="center" border="0" >
   <tr>
     <td height="20" colspan="5" align="left" style="color:#0E0989; font-size:21px" ><?php echo "Introduction";?></td>
   </tr>
   <tr>
     <td  colspan="5"  style="line-height:18px; text-align:justify"><p>Project Monitoring and Management Information System (PMIS) provides unified platform and tools to SMEC Project Management Team, SMEC Country Management, Client and other stakeholders for effective and efficient Project Monitoring and Management for best services delivery. 
PMIS is Web based, online, real-time, 24/7 available from anywhere with secure access. Following are major features: 
<ul>

<li>Project Key Financial Indicators (KFIs) - Monitoring Dashboard</li>
<li>Project Bill of Quantities - Monitoring against overbilling and overuses</li>
<li>News and Events Website</li>
<li>Daily Progress Report</li>
<li>Document Management System</li>
<li>Project Pictorial Analysis (Store and compare pictures on specific dates side by side)</li>
<li>Maps and Drawing Management Tool</li>
<li>Project Issues</li>
<li>Non Conformity Notices Management</li>
</ul>

                                 </p>
   </td>
   </tr>
    <tr><td colspan="5" align="center"><img src="images/pmis.png"  width="400px" /></td></tr>
     
</table>
		
	  </div>
<div style="width:100%; height:10px; border:0px; background:#fecb00"></div>
<div style="width:100%; text-align:center;"><h3>Developed by: SJ-SMEC-EGC</h3><br />
<a href="http://www.egcpakistan.com/index.php?id=it" target="_blank"><img src="images/sj.png"  /></a>
</div>
	</div>
	<div class="clear"></div>