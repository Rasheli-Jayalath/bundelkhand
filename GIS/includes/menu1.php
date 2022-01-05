<style>
#menu, #menu ul {
    margin: 0;
    padding: 0;
    list-style: none;
}
#menu {
    width: 1347px;
    border: 1px solid #06F;
    background-color: #00C;
    background-image: linear-gradient(#06F, #069);
    border-radius: 6px;
    box-shadow: 0 1px 1px #09F;
}
#menu:before,
#menu:after {
    content: "";
    display: table;
}

#menu:after {
    clear: both;
}

#menu {
    zoom:1;
}
#menu li {
    float: left;
    border-right: 1px solid #FFF;
    box-shadow: 1px 0 0 #EBEBEB;
    position: relative;
}

#menu a {
    float: left;
    padding: 12px 40px;
    color: #FFF;
    text-transform: uppercase;
    font: bold 12px Arial, Helvetica;
    text-decoration: none;
    text-shadow: 0 1px 0 #CCC;
}

#menu li:hover > a {
    color: #fafafa;
}

*html #menu li a:hover { /* IE6 only */
    color: #fafafa;
}
#menu ul {
    margin: 20px 0 0 0;
    _margin: 0; /*IE6 only*/
    opacity: 0;
    visibility: hidden;
    position: absolute;
    top: 38px;
    left: 0;
    z-index: 1;    
    background: #444;   
    background: linear-gradient(#00A3F0, #005BB7);
    box-shadow: 0 -1px 0 rgba(255,255,255,.3);  
    border-radius: 3px;
    transition: all .2s ease-in-out;
}

#menu li:hover > ul {
    opacity: 1;
    visibility: visible;
    margin: 0;
}

#menu ul ul {
    top: 0;
    left: 150px;
    margin: 0 0 0 20px;
    _margin: 0; /*IE6 only*/
    box-shadow: -1px 0 0 rgba(255,255,255,.3);      
}

#menu ul li {
    float: none;
    display: block;
    border: 0;
    _line-height: 0; /*IE6 only*/
    box-shadow: 0 1px 0 #FFF, 0 2px 0 #CCC;
}

#menu ul li:last-child {   
    box-shadow: none;    
}

#menu ul a {    
    padding: 10px;
    width: 200px;
    _height: 10px; /*IE6 only*/
    display: block;
    white-space: nowrap;
    float: none;
    text-transform: none;
}

#menu ul a:hover {
    background-color: #0186ba;
    background-image: linear-gradient(#04acec, #0186ba);
}

</style>
<?php
 $gmc_flag 		= $_SESSION['ne_gmc'];
$gmcadm_flag 	= $_SESSION['ne_gmcadm'];
$gmcentry_flag = $_SESSION['ne_gmcentry'];

if(isset($_Session['lang']))
{
	$lang=$_Session['lang'];
  $eng_url=str_replace("lang=".$_Session['lang'], "", $str);
}
else
{
	$lang="en";
	$eng_url=$str."?";
}
?>
<div style="height:50px; margin-top:15px;">
		<ul id="menu">
			<li><a href="./index.php" style="color:"><?php echo HOME ?></a></li>
			<?php
	if($objAdminUser->user_type==3)
	{ 
	$objMenu->setProperty("user_cd", $objAdminUser->user_cd);
	$objMenu->setProperty("parent_cd", "0");
  //  $objMenu->lstUserMenu();
  $objMenu->lstMenu();
	}
	else
	{
	$objMenu->setProperty("parent_cd", "0");
    $objMenu->lstMenu();
	}
	if($objMenu->totalRecords() >= 1){
		$counter = 100000;
		$counter++;
		# Print parent menus
		while($rows_p = $objMenu->dbFetchArray(1)){
	
			/*echo '<li  id="' . $rows_p['menu_cd'] . '">
			
			<a href="' . str_replace("USER_TYPE", $objAdminUser->user_type, $rows_p['menu_link']). ' " >'; */
			
			echo '<li  id="' . $rows_p['menu_cd'] . '"><a ';
						
						echo 'href="'  . str_replace("USER_TYPE", $objAdminUser->user_type, $rows_p['menu_link']).'"'; 
						if($rows_p['menu_cd']==20 || $rows_p['menu_cd']==18)
						{						 
					
		echo $target="target='_blank'";
		}
						else
						{
						}
						echo '>' ; 
						
			
			if(($rows_p['menu_cd']==84) && (($objAdminUser->user_type)!=1))
	{
	}
	else
	{
	if($_SESSION['lang']=="rus")
						{
						echo $rows_p['menu_title_rus'];
						
						}
						else
						{
						echo $rows_p['menu_title'];
						}
	} 
	echo '</a>' . "\n";
				
			$objMenuNew = new Menu;
			$objMenuNew->setProperty("parent_cd", $rows_p['menu_cd']);
			$objMenuNew->lstMenu();
			if($objMenuNew->totalRecords() >= 1){
				
				echo '<ul>' . "\n";
				while($rows = $objMenuNew->dbFetchArray(1)){
					if($rows['menu_cd']==23)
						{
						
						echo '<li  id="' . $rows['menu_cd'] . '">';
						if($gmc_flag==1)
						{
						echo '<a ';
						
						echo 'href="' . $rows['menu_link'] ;
						if($rows_p['menu_cd']!=5)
						{
						 "&menu_cd=".$rows_p['menu_cd'];
						}
						echo '" ';
					/*if($rows['menu_cd']==20 || $rows['menu_cd']==2 || $rows['menu_cd']==4 || $rows['menu_cd']==81)
		{*/
		echo $target="target='_blank'";
		//}
						echo '>' ;
						if($_SESSION['lang']=="rus")
						{
						echo $rows['menu_title_rus'];
						}
						else
						{
						echo $rows['menu_title'];
						}
						 echo  '</a>';	
						}
						else
						{
							?>
                            <a href="javascript:void(0);" style="opacity: 0.5;" ><?php if($_SESSION['lang']=="rus")
						{
						echo $rows['menu_title_rus'];
						}
						else
						{
						echo $rows['menu_title'];
						}?></a>
                            <?php
						}
						//echo '</li>';
						}
						else if(($rows['menu_cd']==80) && (($objAdminUser->user_type)!=1))
						{
						}
						else if(($rows['menu_cd']==87) && (($objAdminUser->user_type)!=1))
						{
						}
						else if(($rows['menu_cd']==39) && (($objAdminUser->user_type)!=1))
						{
						}
						else if(($rows['menu_cd']==22) && (($objAdminUser->user_type)==1))
						{
						}
						
						else{
						echo '<li  id="' . $rows['menu_cd'] . '"><a ';
						
						echo 'href="' . $rows['menu_link'] ;
						if($rows_p['menu_cd']!=5)
						{
						 "&menu_cd=".$rows_p['menu_cd'];
						}
						echo '" ';
					/*if($rows['menu_cd']==20 || $rows['menu_cd']==2 || $rows['menu_cd']==4 || $rows['menu_cd']==81)
		{*/
		echo $target="target='_blank'";
		//}
						echo '>' ;
						if($_SESSION['lang']=="rus")
						{
						echo $rows['menu_title_rus'];
						}
						else
						{
						echo $rows['menu_title'];
						}
						 echo  '</a>';
					/*$objMenu1 = new Menu;
					$objMenu1->setProperty("parent_cd", $rows['menu_cd']);
					$objMenu1->lstMenu();
					if($objMenu1->totalRecords() >= 1){
						echo '<ul >' . "\n";
						while($rows1 = $objMenu1->dbFetchArray(1)){
							
				echo '<li  id="' . $rows1['menu_cd'] . '"><a href="' . $rows1['menu_link'] . '" ';
				
				if($rows1['menu_cd']==1 || $rows1['menu_cd']==2 || $rows1['menu_cd']==4 || $rows1['menu_cd']==81)
		{
		echo $target="target='_blank'";
		}
								echo '>';
						if($_SESSION['lang']=="rus")
						{
						echo $rows_p['menu_title_rus'];
						
						}
						else
						{
						echo $rows_p['menu_title'];
						} 
								echo  '</a></li>' . "\n";
						}
						echo '</ul>' . "\n";
						echo '</li>' . "\n";
					}*/
					}
				}
				echo '</ul>' . "\n";
			}
			echo '</li>' . "\n";
				
			$counter++;
		}
	}
	?> 
<li align-text="right" style="float:right; "><a href="<?php echo $eng_url; ?>language=en"><img src="images/english.png" title="English" alt="English" "/></a></li>

<li align-text="right" style="float:right; "><a href="<?php echo $eng_url; ?>language=rus"><img src="images/russian.png" title="Russian" alt="Russian" /></a></li>
 </ul>
  
</div>

