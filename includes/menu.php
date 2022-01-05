<?php
$superadmin 	= $_SESSION['ne_sadmin'];
$news_flag 		= $_SESSION['ne_news'];
$newsadm_flag 	= $_SESSION['ne_newsadm'];
$newsentry_flag = $_SESSION['ne_newsentry'];
$strusername 	= $_SESSION['ne_username'];

?>
<div id="navcontainer" class="menu" >
		<ul>
			
			<li><a href="index.php" <? if($sCurPage=='index.php') echo 'class="sel"' ; ?>  class="current">Home</a></li>
			
		<li> <?php if ($news_flag == 1) { ?> 
		<a href="./?p=news_mgmt" <? if($sCurPage=='./?p=news_mgmt') echo 'class="sel"' ; ?> class="current" target="_blank">News and Events</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" >News and Events</a>
		<?php
		}
		?>
		
		</li>
		
		<li> <?php if ($news_flag == 1) { ?> 
		<a href="./?p=dailyreports_mgmt" <? if($sCurPage=='./?p=dailyreports_mgmt') echo 'class="sel"' ; ?> class="current" target="_blank">Daily Reports</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" >Daily Project Reports</a>
		<?php
		}
		?>
		
		</li>
        <li> <?php if ($news_flag == 1) { ?> 
		<a href="./?p=pmcdailyreports_mgmt" <? if($sCurPage=='./?p=pmcdailyreports_mgmt') echo 'class="sel"' ; ?> class="current" target="_blank">Daily PMC Reports</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" >Daily PMC Reports</a>
		<?php
		}
		?>
		
		</li>
           
	 	<li><a href="PMIS/home.php" <? if($sCurPage=='PMIS/home.php') echo 'class="sel"' ; ?> class="current" target="_blank">PMIS</a></li>
		
		<li>
		<a href="https://india-sdms.smecnet.com/bundelkhand/DMS/index.php" <? if($sCurPage=='https://india-sdms.smecnet.com/bundelkhand/DMS/index.php') echo 'class="sel"' ; ?>  target="_blank" class="current">DMS</a></li>
        <li>
		<a href="GIS/index.php" <? if($sCurPage=='GIS/index.php') echo 'class="sel"' ; ?>  target="_blank" class="current">GIS Dashbaord</a></li>
		<?php /*?><li><a href="#" <? if($sCurPage=='Dashboard/index.php') echo 'class="sel"' ; ?>   class="current">Strategic Dashboard</a></li><?php */?>
	 <?php if ($superadmin == 1) { ?> 
	 <li><a href="./?p=user_mgmt" style="color:">Superadmin</a></li>
	 <?php
	 }
	 ?>
    <li><a href="./?p=logout" style="color:">Logout</a></li>
 </ul>
</div>

