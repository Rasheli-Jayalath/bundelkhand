<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,600italic,400italic,800,700' rel='stylesheet' type='text/css'>    
<style>
h1, h2, h3, h4, h5, h6 { margin: 5px 0px 15px 0px; clear: both; font-weight: lighter; }
h1 { font-size: 36px; }
h2 { font-size: 30px; }
h3 { font-size: 24px; }
h4 { font-size: 20px; }
h5 { font-size: 18px; }
h6 { font-size: 14px; }
p {font-size: 13px; margin: 5px 0px 15px 0px; }

img { -ms-interpolation-mode: bicubic; border: 0; height: auto; max-width: 100%; vertical-align: middle; display: block;  }
figure { margin: 0; }
::-webkit-input-placeholder { color: rgba(51, 51, 51, 0.7); }
:-moz-placeholder { color: rgba(51, 51, 51, 0.7); }
::-moz-placeholder { color: rgba(51, 51, 51, 0.7); opacity: 1; /* Since FF19 lowers the opacity of the placeholder by default */ }
:-ms-input-placeholder { color: rgba(51, 51, 51, 0.7); }
input:focus, textarea:focus { background-color: #fff; border: 1px solid #c1c1c1; border: 1px solid rgba(51, 51, 51, 0.3); color: #333; }
input:focus, select:focus { outline: 2px solid #c1c1c1; outline: 2px solid rgba(51, 51, 51, 0.3); }
.hide { display: none;}

.clear { clear: both; height: 0px; overflow: hidden; }

/* <<< Design Holder >>> */
.DesignHolder { position: relative; display: block; width: 100%; min-height: 100%; }

/* <<< Layout Frame >>> */
.LayoutFrame { margin: 0 auto; width: 100%; display: block; }

	/* <<< Container >>> */
	#Container { overflow: hidden; width: 100%; }

	/* <<< About Section >>> */
	.About_sec { padding: 0px 0px 88px 0px ; width: 100%; overflow: hidden; }
	.About_sec .Center { max-width: 1100px; margin: auto; overflow: hidden; text-align: center; }
	.About_sec h2 { font-size: 56px; color: #000; font-family: 'Oswald', sans-serif; font-weight: 400; margin: 0px; text-transform: uppercase; line-height: 60px; letter-spacing: -0.4px; }
	.About_sec p { padding: 24px 0px 35px 0px; font-size: 14px; color: #979797; margin: 0px; font-family: 'Open Sans', sans-serif; line-height: 25px; font-weight: 400; }
	.About_sec .Line { border: solid 1px #ff9408; height: 2px; width: 252px; margin: auto; }
	.About_sec .Tabside { padding: 90px 0px; width: 100%;}
	.About_sec .Tabside ul { list-style: none; margin: 0px; padding-bottom: 59px; }
	.About_sec .Tabside li { float: none; padding: 0px; margin: 0px -2px; display: inline-block;}
	.About_sec .Tabside li a { padding: 14px 40px 13px 40px; font-size: 18px; color: #989898; font-family: 'Open Sans', sans-serif; font-weight: 400; text-decoration: none; text-transform: uppercase; border: solid 1px #d5d5d5; display: block; transition: all 0.3s ease; }
	.About_sec .Tabside li a:hover, .About_sec .Tabside li a.activeLink { border: solid 1px #ff9408; background: #ff9408; color: #fff;}
	.About_sec .Tabside .TabImage { width: 43.63%; float: left; position: relative; }
	.About_sec .Tabside .TabImage .img1 { position: absolute; top: 0px; left: 42px; height: 260px; background: url(images/about-shadow.png) no-repeat; background-position: 25px 223px; }
	.About_sec .Tabside .TabImage .img1 img { padding: 5px; border: solid 1px #ececec; background: #fff;  }
	.About_sec .Tabside .TabImage .img2 { position: absolute; top: 40px; left: 2px; height: 260px; background: url(images/about-shadow.png) bottom center no-repeat; background-position: 0px 223px; }
	.About_sec .Tabside .TabImage .img2 img { padding: 5px; border: solid 1px #ececec; background: #fff;  }
	.About_sec .Tabside .Description { width: 54.3%; float: right; text-align: left; margin-top: -6px;}
	.About_sec .Tabside .Description h3 { font-size: 24px; color: #000; margin: 0px; text-transform: uppercase; font-family:'Open Sans'; line-height: 29px; }
	.About_sec .Tabside .Description h3 span { padding-left: 3px; font-size: 14px; color: #ff9000; display: block; }
	.About_sec .Tabside .Description p { padding: 21px 0px 4px 0px; font-size: 14px; color: #979797; margin: 0px; font-family:'Open Sans'; line-height: 25px; }
	.About_sec .Tabside .Description p .cyan { font-size: 16px; color: #08c2ff; 
	}
		footer { overflow: hidden; width: 100%; text-align: center; background: rgba(0, 0, 0, 0.6); }
		footer .Cntr {}
		footer .Cntr p { padding: 0px; font-size: 13px; color: #a9abad; font-family:'Open Sans'; margin: 0px; }
		footer .Cntr a { color: #a9abad; text-decoration: none; }
		footer .Cntr a:hover { color: #fff; }	
</style>
</head>
<body>
<div id="wrapperPRight">

<div style="text-align:right; padding:10px; text-decoration:none">
<a  style="text-align:right; padding:10px; text-decoration:none" href="./?p=my_profile" title="header=[My Profile] body=[&nbsp;] fade=[on]">
<?php
echo  WELCOME." <b>".$objAdminUser->fullname_name."</b> ";?>
 
<?php 
echo   " [" ;
			if($objAdminUser->user_type==1)  
			echo "SuperAdmin";
			elseif($objAdminUser->user_type==2&&$objAdminUser->member_cd==0)
			echo "SubAdmin";
			else
			echo "User";
			echo "]";

	?> 
   </a></div>
   
            <div class="About_sec" id="about">
                <div class="Center">            	
                    <!-- \\ Begin Tab side \\ -->
                    <div class="Tabside">
                            <div class="TabImage">
                                <div class="img1">
                                    <figure><img src="images/11050-39.jpg" alt="image"></figure>	
                                </div>
                                <div class="img2">
                                    <figure><img src="images/423-Kazirrigationdrainage765x305-1.jpg" alt="image"></figure>
                                </div>
                            </div>
                            <div class="Description">
                                <h3><?php echo INTRO;?><span><?php echo HOME_MAIN_TITLE;?></span></h3>
                                <p><?php echo PARA;?></p>
                                <p><?php echo PARA2;?></p>
                            </div>
                        </div>
                        </div>
	                    	
                    </div>                   

   
   
   
   
<?php /*?><div class="About_sec" id="about">
			<?php $sql_cms="Select * from rs_tbl_cms where cms_cd=1";
			$sql_cms_q=mysql_query($sql_cms);
			$sql_cms_r=mysql_fetch_array($sql_cms_q);
			 ?>
                <div class="Center">            	
                    <!-- \\ Begin Tab side \\ -->
                    <div class="Tabside">
                            <div class="TabImage">
                                <div class="img1">
                                    <figure><img src="images/about-img1.jpg" alt="image"></figure>	
                                </div>
                                <div class="img2">
                                    <figure><img src="<?php echo CMS_URL; ?>/<?php echo $sql_cms_r['cmsfile'];?>" style="height:180px; width:400px" /></figure>
                                </div>
                            </div>
                            <div class="Description">
                                <h3><?php echo $sql_cms_r['title'];?><span>GIS Survey & Geo Database Development for Entire NHA Network</span></h3>
                                <p><?php echo $sql_cms_r['details'];?></p>
                                
                            </div>
                        </div>
                        </div>
	                    	
                    </div>     
<?php */?>   

    
<?php include ("includes/footer.php"); ?>
    
    </body>
    </html>