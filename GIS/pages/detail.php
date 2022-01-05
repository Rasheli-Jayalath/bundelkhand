<div id="wrapperPRight">
		<div id="pageContentName" style="background-color: #09AFFF;  background-image: -webkit-gradient(linear, 0% 100%, 0% 0%, from(#09AFFF), to(#046b99)); color: #FFF;"><?php echo "Details";?></div>
		<?php /*?><div id="pageContentRight">
			<div class="menu1">
				<ul>
				<li><a href="./?p=cms_form" class="lnkButton"><?php echo "Add New Page";?>
					</a></li>
					</ul>
				<br style="clear:left"/>
			</div>
		</div><?php */?>
		<div class="clear"></div>
		<br />
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
        
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/detail.css">

    
			<div class="wrap-table100">
				<div class="table100 ver1 m-b-110" style=" margin-left:20px">

					<div class="table100-body js-pscroll" style="background-color:; margin-top:-58px;">
						<table>
							<tbody>
  <?php
  if(isset($_REQUEST['attrib_gid']))
  {
	  $attrib_gid=$_REQUEST['attrib_gid'];
	
  $query = "SELECT * FROM image_data where attrib_gallery_id='$attrib_gid'";
  }
$result=mysql_query($query);
 if (mysql_num_rows($result) > 0) {
$row = mysql_fetch_assoc($result);
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$i++;
?>
                            
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Latitude Start</td>
									<td class="cell100 column2"><?php echo $row['lat_start']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Lognitude Start</td>
									<td class="cell100 column2"><?php echo $row['long_start']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Latitude End</td>
									<td class="cell100 column2"><?php echo $row['lat_end']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Lognitude End</td>
									<td class="cell100 column2"><?php echo $row['long_end']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Date of Survey</td>
									<td class="cell100 column2"><?php echo $row['date_of_survey']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">GPS Data</td>
									<td class="cell100 column2"><?php echo $row['gps_data']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Attribute Type</td>
									<td class="cell100 column2"><?php echo $row['attrib_name']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Property Type</td>
									<td class="cell100 column2"><?php echo $row['property_Type']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Direction</td>
									<td class="cell100 column2"><?php echo $row['direction']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Surveyor</td>
									<td class="cell100 column2"><?php echo $row['username']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Road Mileage</td>
									<td class="cell100 column2"><?php echo $row['road_mileage']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Name</td>
									<td class="cell100 column2"><?php echo $row['name']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Description</td>
									<td class="cell100 column2"><?php echo $row['description']; ?></td>
								<tr class="row100 body">
									<td class="cell100 column1" style="line-height: 0.4;">Remarks</td>
									<td class="cell100 column2"><?php echo $row['ownership_comments']; ?></td>
 <?php
  
 }
 ?>
							</tbody>
						</table>
					</div>
		</div>
	</div>
        
<div style="background-color:; float:left; margin-left:600px; margin-top:-530px">
    <?php if($row['item_type']=="photo"){
		 $image = file_get_contents('E:/dataserver/nha_gis/geo_photos/'.$row['item_name']);
		$image_codes = base64_encode($image);
		?>
    <?php /*?> <a  href="photos/<?php echo $row['item_name']?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none" ><?php */?><image src="data:image/jpg;charset=utf-8;base64,<?php echo $image_codes; ?>" width="700px" style="height: 530px;" />  <!--</a> -->
	
		    
   
    <?php
	}
	else
	{
		
    
function custom_copy($src, $dst, $filen) {  
   
    // open the source directory 
    $dir = opendir($src);  
   
    // Make the destination directory if not exist 
    @mkdir($dst);  
   
    // Loop through the files in source directory 
    foreach (scandir($src) as $file) {  
   
        if ($file == $filen) {  
            if ( is_dir($src . '/' . $file) )  
            {  
   
                // Recursively calling custom copy function 
                // for sub directory  
                custom_copy($src . '/' . $file, $dst . '/' . $file);  
   
            }  
            else {  
                copy($src . '/' . $file, $dst . '/' . $file);  
            }  
        }  
    }  
   
    closedir($dir); 
}   
  
$src = "E:/dataserver/nha_gis/geo_photos"; 
  
$dst = "C:/xampp/htdocs/GeoDashboard/videos"; 


custom_copy($src, $dst,$row['item_name']);

		
		
		
		
		?>
        <video width="620" height="340" controls autoplay>
 <source src="videos/<?php echo $row['item_name']; ?>" type="video/mp4">
  Sorry, your browser doesn't support the video element.
</video>
        <?php
	}
	?>    </div>        
        
        
        
        
        
	  </form>
	</div>