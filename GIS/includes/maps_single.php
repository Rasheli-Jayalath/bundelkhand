<?php

$lat =$latbf;  
$lng =$lngbf;
?>

<?php /*?><script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><?php */?>

<script type="text/javascript" src="./js_map/ProjectedOverlay.js"></script>
<script type="text/javascript" src="./js_map/geoxml3.js"></script>


<!--<script type="text/javascript" src="./js_map/map.js"></script>-->
<script>

	//create empty temp array
    var markersArray = [];
	var circlesArray = [];
	

	


    </script>
    
<script type="text/javascript">
var mapInstance;
var parser;
var placemarkMetadata = []; 

<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	
	var <?php echo $justname."Visible";?>=true;

 <?php
	
}
 ?>  

//
// Modified from php.js strcmp at http://phpjs.org/functions/strcmp
// Requires b1 and b2 have name fields
//
function placemarkcmp (b1, b2) {
return ((b1.name == b2.name) ? 0 : ((b1.name > b2.name) ? 1 : -1));
}


//
// Triggered by our parsecomplete event
//
function customAfterParse(docSet) {
	// placemarks is the collection of Geoxml3 placemark instances
	// We're collecting document 0, which we know is the placemarks KML
	var placemarks = docSet[0].placemarks;
	
	var markerIndex, placemarkIndex, loopEnd;

	// Create array of placemark metadata objects, containing name and index into the Geoxml3 document array
	for (markerIdx = 0, loopEnd = placemarks.length; markerIdx < loopEnd; markerIdx++) {
		var currentMetadata = {};

		currentMetadata.name = placemarks[markerIdx].name;
		currentMetadata.index = markerIdx;
		placemarkMetadata.push(currentMetadata);
	}

	// Sort alphabetically by name
	placemarkMetadata.sort(placemarkcmp);

	// Add list items with an HTML id attribute  p##, where ## is the index of the marker we want to trigger
	for (placemarkIndex = 0, loopEnd = placemarkMetadata.length; placemarkIndex < loopEnd; placemarkIndex++) {
		$('#placemarkList').append('<li id="p' + placemarkMetadata[placemarkIndex].index + '">' + placemarkMetadata[placemarkIndex].name + '</li>');
	}
}


//
// Triggered by the parsed event on our parser
//
function completeInit1() {
	
	<?php $kmlsqlp="select * from idip2_dashboard.kmls_add";
$kmlresultp=mysql_query($kmlsqlp);
while($kmldatap=mysql_fetch_array($kmlresultp))
{
	$file_name=$kmldatap['file_name'];
	$attribute_type=$kmldatap['attribute_type'];
	$kmlid=$kmldatap['kid'];
	$kid=$kmlid-1;
	if($file_name=="road.kml" || $file_name=="contour.kml" || $file_name=="canal_center.kml" || $file_name=="canal_center_sarybulak.kml"
	|| $file_name=="contour_sarybulak.kml"|| $file_name=="road_sarybulak.kml")
	{
		?>
		parser.hideDocument(parser.docs[<?php echo $kid;?>]);
		<?php
	}else
	{
	
	?>
	parser.showDocument(parser.docs[<?php echo $kid;?>]);

 <?php
	}
}
 ?>  
	
	
	
	<?php $kmlsqlt="select * from idip2_dashboard.kmls_add";
$kmlresultt=mysql_query($kmlsqlt);
while($kmldatat=mysql_fetch_array($kmlresultt))
{
	$file_namet=$kmldatat['file_name'];
	$attribute_typet=$kmldatat['attribute_type'];
	$arr_filet=explode(".",$file_namet);
	$justnamet=$arr_filet[0];
	if($file_namet=="road.kml" || $file_namet=="contour.kml" || $file_namet=="canal_center.kml" || $file_namet=="canal_center_sarybulak.kml" || 		    $file_namet=="contour_sarybulak.kml" || $file_namet=="road_sarybulak.kml")
	{
		?>
		<?php echo $justnamet."Visible";?>=false;
		<?php
	}else
	{
	
	?>
	<?php echo $justnamet."Visible";?>=true;

 <?php
	}
}
 ?> 
	
	

	// Add event handler for sidebar items
	// Because we're using jQuery 1.7.1, we use on.
	// If we were using previous versions, we'd use live
	$("#placemarkList li").on("click", function(e) {
		 
		// Get the id value, strip off the leading p
		var id = $(this).attr("id");
		id = id.substr(1);
		alert(id);

		// "Click" the marker
		
		google.maps.event.trigger(parser.docs[0].placemarks[id].marker, 'click');
		
		
	});
	
	// Add mouse events so users know when we're hovering on a sidebar elemnt
	$("#placemarkList li").on("mouseenter", function(e) {
			var textcolor = $(this).css("color");
			$(this).css({ 'cursor' : 'pointer', 'color' : '#FFFFFF', 'background-color' : textcolor });
		}).on("mouseleave", function(e) {
			var backgroundcolor = $(this).css("background-color");
			$(this).css({ 'cursor' : 'auto', 'color' : backgroundcolor, 'background-color' : 'transparent' });
		});

	// Highlight visible and invisible sidebar items
	// As user scrolls, the sidebar willreflect visible and invisible placemarks
	google.maps.event.addListener(mapInstance, 'click', function(e) {
		
	
			var distance = parseInt(document.getElementById('mapdistance').value);
		  		if( distance < 1 ){
				  	alert('Your distance is too small');
				}

				//clear map
		  		/*removeMarkersAndCircles();
		  		//draw marker with circle
	    		placeMarker(e.latLng, mapInstance, distance);*/
	    		//write actual position into inputs
	    		writeLabels(e.latLng);
		currentBounds = mapInstance.getBounds();
		for (i = 0; i < parser.docs[0].placemarks.length; i++) {
		
			var myLi = $("#p" + i);
			
			if (currentBounds.contains(parser.docs[0].placemarks[i].marker.getPosition())) {
				myLi.css("color","#000000");
			} else {
				myLi.css("color","#CCCCCC");
			}
			  //window.location.href = 'http://www.google.com';
		}
	});
	
	
	
	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	$("#<?php echo $justname."toggle"; ?>").on("click", function(e) {
		if (<?php echo $justname."Visible"; ?>) {
			parser.hideDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = false;
		} else {
			parser.showDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = true;
		}		
	});

 <?php
}
 ?> 
	
	// for Point
	
	
	
	$("#controls").show();
}
function placeMarker(position, mapInstance, distance) {
		// Create marker 
		var marker = new google.maps.Marker({
		  map: mapInstance,
		  position: position,
		  title: 'Center'
		});

		//center map after click
		/*var iscenteractive = document.getElementById("mapcenter").checked
		if( iscenteractive )
			map.setCenter(position);*/

		//add marker into temp array
		markersArray.push(marker);

		//Add circle overlay and bind to marker
		var circle = new google.maps.Circle({
		  	map: mapInstance,
		  	radius: distance,
		  	fillColor: '#AA0000'
		});
		circle.bindTo('center', marker, 'position');

		circlesArray.push(circle);
	}

	//remove all markers from map
	function removeMarkersAndCircles() {
	    if (markersArray) {
	        for (i=0; i < markersArray.length; i++) {
	            markersArray[i].setMap(null);
	            circlesArray[i].setMap(null);
	        }
	    markersArray.length = 0;
	    circlesArray.length = 0;
	    }
	}

	//write labels into inputs
	function writeLabels(position){
		document.getElementById('maplat').value = position.lat();
		document.getElementById('maplng').value = position.lng();
	}

	function AjaxObject()
	{
		if(window.ActiveXObject)		// For IE
		{
			Ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else if(window.XMLHttpRequest)
		{
			Ajax = new XMLHttpRequest();
		}
		else
			alert("Your Browser Did Not Support AJAX");
		return Ajax;
	}
	//draw marker and circle by location
	function drawByLocation(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		var dis_km1=distance/1000;
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;
		
		
	Ajax = AjaxObject();
		if(Ajax)
		{
			url = "<?php echo SITE_URL; ?>buffer_list.php";
			
			formdata= "lati="+lat+"&lngi="+lng+"&dis_km="+dis_km1;
			Ajax.open("POST",url);
			Ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			Ajax.onreadystatechange = outputdept;
			Ajax.send(formdata);
		}
		else
		{
			alert("Not Supported");
		}
		  
		
		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	placeMarker(position, mapInstance, distance);
    	writeLabels(position);
		
		

	}
	function outputdept()
	{
		if(Ajax.readyState == 4)
		{
		document.getElementById("buffer_detail").innerHTML=Ajax.responseText;
		}
	}
	function bufferoff(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;

		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	/*placeMarker(position, mapInstance, distance);
    	writeLabels(position);*/

	}


$(document).ready(function() {
	var latlng = new google.maps.LatLng('<?php echo $lat  ?>', '<?php echo $lng  ?>');
	var mapOptions = {
		zoom: 19,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.HYBRID
		/*mapTypeControlOptions: {
		style: google.maps.MapTypeControlStyle.DEFAULT
		}*/
	};
	mapInstance = new google.maps.Map(document.getElementById("map1"), mapOptions);

	// Create a new parser for all the KML
	// processStyles: true means we want the styling defined in KML to be what isrendered
	// singleInfoWindow: true means we only want 1 simultaneous info window open
	// zoom: false means we don't want torecenter/rezoom based on KML data
	// afterParse: customAfterparse is a method to add the sidebar once parsing is done
	//
	parser = new geoXML3.parser({
		map: mapInstance,
		processStyles: true,
		singleInfoWindow: true,
		zoom: false,
		afterParse: customAfterParse
		}
	);

	// Add an event listen for the parsed event on the parser
	// Thisrequires a Geoxml3 with the patch defined in Issue 40
	// http://code.google.com/p/geoxml3/issues/detail?id=40
	// We need this event to know when Geoxml3 has compltely defined the coument arrays
	google.maps.event.addListener(parser, 'parsed', completeInit1);

	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
$total=mysql_num_rows($kmlresult);
$file_name_kml="";
$file_kml="";
$i=0;
while($kmldata=mysql_fetch_array($kmlresult))
{
	$i=$i+1;
	if($i<$total)
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'".",";	
	}
	else
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'";		
	}
	
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
}
	?>

parser.parse([<?php echo $file_kml;?>]);
});

</script>

<?php

if ($_GET['map_id']==1)
{
?>
<script type="text/javascript">
var mapInstance;
var parser;
var placemarkMetadata = []; 

<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	
	var <?php echo $justname."Visible";?>=true;

 <?php
	
}
 ?>  

//
// Modified from php.js strcmp at http://phpjs.org/functions/strcmp
// Requires b1 and b2 have name fields
//
function placemarkcmp (b1, b2) {
return ((b1.name == b2.name) ? 0 : ((b1.name > b2.name) ? 1 : -1));
}


//
// Triggered by our parsecomplete event
//
function customAfterParse(docSet) {
	// placemarks is the collection of Geoxml3 placemark instances
	// We're collecting document 0, which we know is the placemarks KML


	var placemarks = docSet[0].placemarks;
	
	var markerIndex, placemarkIndex, loopEnd;

	// Create array of placemark metadata objects, containing name and index into the Geoxml3 document array
	for (markerIdx = 0, loopEnd = placemarks.length; markerIdx < loopEnd; markerIdx++) {
		var currentMetadata = {};

		currentMetadata.name = placemarks[markerIdx].name;
		currentMetadata.index = markerIdx;
		placemarkMetadata.push(currentMetadata);
	}

	// Sort alphabetically by name
	placemarkMetadata.sort(placemarkcmp);

	// Add list items with an HTML id attribute  p##, where ## is the index of the marker we want to trigger
	for (placemarkIndex = 0, loopEnd = placemarkMetadata.length; placemarkIndex < loopEnd; placemarkIndex++) {
		$('#placemarkList').append('<li id="p' + placemarkMetadata[placemarkIndex].index + '">' + placemarkMetadata[placemarkIndex].name + '</li>');
	}
}


//
// Triggered by the parsed event on our parser
//
function completeInit1() {
	
	<?php $kmlsqlp="select * from idip2_dashboard.kmls_add";
$kmlresultp=mysql_query($kmlsqlp);
while($kmldatap=mysql_fetch_array($kmlresultp))
{
	$file_name=$kmldatap['file_name'];
	$attribute_type=$kmldatap['attribute_type'];
	$kmlid=$kmldatap['kid'];
	$kid=$kmlid-1;
	if($file_name=="road.kml" || $file_name=="contour.kml" || $file_name=="canal_center.kml" || $file_name=="canal_center_sarybulak.kml"
	|| $file_name=="contour_sarybulak.kml"|| $file_name=="road_sarybulak.kml")
	{
		?>
		parser.hideDocument(parser.docs[<?php echo $kid;?>]);
		<?php
	}else
	{
	
	?>
	parser.showDocument(parser.docs[<?php echo $kid;?>]);

 <?php
	}
}
 ?>  
	
	
	
	<?php $kmlsqlt="select * from idip2_dashboard.kmls_add";
$kmlresultt=mysql_query($kmlsqlt);
while($kmldatat=mysql_fetch_array($kmlresultt))
{
	$file_namet=$kmldatat['file_name'];
	$attribute_typet=$kmldatat['attribute_type'];
	$arr_filet=explode(".",$file_namet);
	$justnamet=$arr_filet[0];
	if($file_namet=="road.kml" || $file_namet=="contour.kml" || $file_namet=="canal_center.kml" || $file_namet=="canal_center_sarybulak.kml" || 		    $file_namet=="contour_sarybulak.kml" || $file_namet=="road_sarybulak.kml")
	{
		?>
		<?php echo $justnamet."Visible";?>=false;
		<?php
	}else
	{
	
	?>
	<?php echo $justnamet."Visible";?>=true;

 <?php
	}
}
 ?> 
	
	

	// Add event handler for sidebar items
	// Because we're using jQuery 1.7.1, we use on.
	// If we were using previous versions, we'd use live
	$("#placemarkList li").on("click", function(e) {
		 
		// Get the id value, strip off the leading p
		var id = $(this).attr("id");
		id = id.substr(1);
		alert(id);

		// "Click" the marker
		
		google.maps.event.trigger(parser.docs[0].placemarks[id].marker, 'click');
		
		
	});
	
	// Add mouse events so users know when we're hovering on a sidebar elemnt
	$("#placemarkList li").on("mouseenter", function(e) {
			var textcolor = $(this).css("color");
			$(this).css({ 'cursor' : 'pointer', 'color' : '#FFFFFF', 'background-color' : textcolor });
		}).on("mouseleave", function(e) {
			var backgroundcolor = $(this).css("background-color");
			$(this).css({ 'cursor' : 'auto', 'color' : backgroundcolor, 'background-color' : 'transparent' });
		});

	// Highlight visible and invisible sidebar items
	// As user scrolls, the sidebar willreflect visible and invisible placemarks
	google.maps.event.addListener(mapInstance, 'click', function(e) {
		
	
			var distance = parseInt(document.getElementById('mapdistance').value);
		  		if( distance < 1 ){
				  	alert('Your distance is too small');
				}

				//clear map
		  		/*removeMarkersAndCircles();
		  		//draw marker with circle
	    		placeMarker(e.latLng, mapInstance, distance);*/
	    		//write actual position into inputs
	    		writeLabels(e.latLng);
		currentBounds = mapInstance.getBounds();
		for (i = 0; i < parser.docs[0].placemarks.length; i++) {
		
			var myLi = $("#p" + i);
			
			if (currentBounds.contains(parser.docs[0].placemarks[i].marker.getPosition())) {
				myLi.css("color","#000000");
			} else {
				myLi.css("color","#CCCCCC");
			}
			  //window.location.href = 'http://www.google.com';
		}
	});
	
	
	
	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	$("#<?php echo $justname."toggle"; ?>").on("click", function(e) {
		if (<?php echo $justname."Visible"; ?>) {
			parser.hideDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = false;
		} else {
			parser.showDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = true;
		}		
	});

 <?php
}
 ?> 
	
	// for Point
	
	
	
	$("#controls").show();
}
function placeMarker(position, mapInstance, distance) {
		// Create marker 
		var marker = new google.maps.Marker({
		  map: mapInstance,
		  position: position,
		  title: 'Center'
		});

		//center map after click
		/*var iscenteractive = document.getElementById("mapcenter").checked
		if( iscenteractive )
			map.setCenter(position);*/

		//add marker into temp array
		markersArray.push(marker);

		//Add circle overlay and bind to marker
		var circle = new google.maps.Circle({
		  	map: mapInstance,
		  	radius: distance,
		  	fillColor: '#AA0000'
		});
		circle.bindTo('center', marker, 'position');

		circlesArray.push(circle);
	}

	//remove all markers from map
	function removeMarkersAndCircles() {
	    if (markersArray) {
	        for (i=0; i < markersArray.length; i++) {
	            markersArray[i].setMap(null);
	            circlesArray[i].setMap(null);
	        }
	    markersArray.length = 0;
	    circlesArray.length = 0;
	    }
	}

	//write labels into inputs
	function writeLabels(position){
		document.getElementById('maplat').value = position.lat();
		document.getElementById('maplng').value = position.lng();
	}

	function AjaxObject()
	{
		if(window.ActiveXObject)		// For IE
		{
			Ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else if(window.XMLHttpRequest)
		{
			Ajax = new XMLHttpRequest();
		}
		else
			alert("Your Browser Did Not Support AJAX");
		return Ajax;
	}
	//draw marker and circle by location
	function drawByLocation(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		var dis_km1=distance/1000;
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;
		
		
	Ajax = AjaxObject();
		if(Ajax)
		{
			url = "<?php echo SITE_URL; ?>buffer_list.php";
			
			formdata= "lati="+lat+"&lngi="+lng+"&dis_km="+dis_km1;
			Ajax.open("POST",url);
			Ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			Ajax.onreadystatechange = outputdept;
			Ajax.send(formdata);
		}
		else
		{
			alert("Not Supported");
		}
		  
		
		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	placeMarker(position, mapInstance, distance);
    	writeLabels(position);
		
		

	}
	function outputdept()
	{
		if(Ajax.readyState == 4)
		{
		document.getElementById("buffer_detail").innerHTML=Ajax.responseText;
		}
	}
	function bufferoff(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;

		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	/*placeMarker(position, mapInstance, distance);
    	writeLabels(position);*/

	}


$(document).ready(function() {
	var latlng = new google.maps.LatLng('<?php echo $lat  ?>', '<?php echo $lng  ?>');
	var mapOptions = {
		zoom: 19,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
		/*mapTypeControlOptions: {
		style: google.maps.MapTypeControlStyle.DEFAULT
		}*/
	};
	mapInstance = new google.maps.Map(document.getElementById("map1"), mapOptions);

	// Create a new parser for all the KML
	// processStyles: true means we want the styling defined in KML to be what isrendered
	// singleInfoWindow: true means we only want 1 simultaneous info window open
	// zoom: false means we don't want torecenter/rezoom based on KML data
	// afterParse: customAfterparse is a method to add the sidebar once parsing is done
	//
	parser = new geoXML3.parser({
		map: mapInstance,
		processStyles: true,
		singleInfoWindow: true,
		zoom: false,
		afterParse: customAfterParse
		}
	);

	// Add an event listen for the parsed event on the parser
	// Thisrequires a Geoxml3 with the patch defined in Issue 40
	// http://code.google.com/p/geoxml3/issues/detail?id=40
	// We need this event to know when Geoxml3 has compltely defined the coument arrays
	google.maps.event.addListener(parser, 'parsed', completeInit1);

	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
$total=mysql_num_rows($kmlresult);
$file_name_kml="";
$file_kml="";
$i=0;
while($kmldata=mysql_fetch_array($kmlresult))
{
	$i=$i+1;
	if($i<$total)
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'".",";	
	}
	else
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'";		
	}
	
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
}
	?>

parser.parse([<?php echo $file_kml;?>]);
});

</script>
<?php
}
?>
<?php

if ($_GET['map_id']==2)
{
?>
<script type="text/javascript">
var mapInstance;
var parser;
var placemarkMetadata = []; 

<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	
	var <?php echo $justname."Visible";?>=true;

 <?php
	
}
 ?>  

//
// Modified from php.js strcmp at http://phpjs.org/functions/strcmp
// Requires b1 and b2 have name fields
//
function placemarkcmp (b1, b2) {
return ((b1.name == b2.name) ? 0 : ((b1.name > b2.name) ? 1 : -1));
}


//
// Triggered by our parsecomplete event
//
function customAfterParse(docSet) {
	// placemarks is the collection of Geoxml3 placemark instances
	// We're collecting document 0, which we know is the placemarks KML
	var placemarks = docSet[0].placemarks;
	
	var markerIndex, placemarkIndex, loopEnd;

	// Create array of placemark metadata objects, containing name and index into the Geoxml3 document array
	for (markerIdx = 0, loopEnd = placemarks.length; markerIdx < loopEnd; markerIdx++) {
		var currentMetadata = {};

		currentMetadata.name = placemarks[markerIdx].name;
		currentMetadata.index = markerIdx;
		placemarkMetadata.push(currentMetadata);
	}

	// Sort alphabetically by name
	placemarkMetadata.sort(placemarkcmp);

	// Add list items with an HTML id attribute  p##, where ## is the index of the marker we want to trigger
	for (placemarkIndex = 0, loopEnd = placemarkMetadata.length; placemarkIndex < loopEnd; placemarkIndex++) {
		$('#placemarkList').append('<li id="p' + placemarkMetadata[placemarkIndex].index + '">' + placemarkMetadata[placemarkIndex].name + '</li>');
	}
}


//
// Triggered by the parsed event on our parser
//
function completeInit1() {
	
	<?php $kmlsqlp="select * from idip2_dashboard.kmls_add";
$kmlresultp=mysql_query($kmlsqlp);
while($kmldatap=mysql_fetch_array($kmlresultp))
{
	$file_name=$kmldatap['file_name'];
	$attribute_type=$kmldatap['attribute_type'];
	$kmlid=$kmldatap['kid'];
	$kid=$kmlid-1;
	if($file_name=="road.kml" || $file_name=="contour.kml" || $file_name=="canal_center.kml" || $file_name=="canal_center_sarybulak.kml"
	|| $file_name=="contour_sarybulak.kml"|| $file_name=="road_sarybulak.kml")
	{
		?>
		parser.hideDocument(parser.docs[<?php echo $kid;?>]);
		<?php
	}else
	{
	
	?>
	parser.showDocument(parser.docs[<?php echo $kid;?>]);

 <?php
	}
}
 ?>  
	
	
	
	<?php $kmlsqlt="select * from idip2_dashboard.kmls_add";
$kmlresultt=mysql_query($kmlsqlt);
while($kmldatat=mysql_fetch_array($kmlresultt))
{
	$file_namet=$kmldatat['file_name'];
	$attribute_typet=$kmldatat['attribute_type'];
	$arr_filet=explode(".",$file_namet);
	$justnamet=$arr_filet[0];
	if($file_namet=="road.kml" || $file_namet=="contour.kml" || $file_namet=="canal_center.kml" || $file_namet=="canal_center_sarybulak.kml" || 		    $file_namet=="contour_sarybulak.kml" || $file_namet=="road_sarybulak.kml")
	{
		?>
		<?php echo $justnamet."Visible";?>=false;
		<?php
	}else
	{
	
	?>
	<?php echo $justnamet."Visible";?>=true;

 <?php
	}
}
 ?> 
	
	

	// Add event handler for sidebar items
	// Because we're using jQuery 1.7.1, we use on.
	// If we were using previous versions, we'd use live
	$("#placemarkList li").on("click", function(e) {
		 
		// Get the id value, strip off the leading p
		var id = $(this).attr("id");
		id = id.substr(1);
		alert(id);

		// "Click" the marker
		
		google.maps.event.trigger(parser.docs[0].placemarks[id].marker, 'click');
		
		
	});
	
	// Add mouse events so users know when we're hovering on a sidebar elemnt
	$("#placemarkList li").on("mouseenter", function(e) {
			var textcolor = $(this).css("color");
			$(this).css({ 'cursor' : 'pointer', 'color' : '#FFFFFF', 'background-color' : textcolor });
		}).on("mouseleave", function(e) {
			var backgroundcolor = $(this).css("background-color");
			$(this).css({ 'cursor' : 'auto', 'color' : backgroundcolor, 'background-color' : 'transparent' });
		});

	// Highlight visible and invisible sidebar items
	// As user scrolls, the sidebar willreflect visible and invisible placemarks
	google.maps.event.addListener(mapInstance, 'click', function(e) {
		
	
			var distance = parseInt(document.getElementById('mapdistance').value);
		  		if( distance < 1 ){
				  	alert('Your distance is too small');
				}

				//clear map
		  		/*removeMarkersAndCircles();
		  		//draw marker with circle
	    		placeMarker(e.latLng, mapInstance, distance);*/
	    		//write actual position into inputs
	    		writeLabels(e.latLng);
		currentBounds = mapInstance.getBounds();
		for (i = 0; i < parser.docs[0].placemarks.length; i++) {
		
			var myLi = $("#p" + i);
			
			if (currentBounds.contains(parser.docs[0].placemarks[i].marker.getPosition())) {
				myLi.css("color","#000000");
			} else {
				myLi.css("color","#CCCCCC");
			}
			  //window.location.href = 'http://www.google.com';
		}
	});
	
	
	
	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	$("#<?php echo $justname."toggle"; ?>").on("click", function(e) {
		if (<?php echo $justname."Visible"; ?>) {
			parser.hideDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = false;
		} else {
			parser.showDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = true;
		}		
	});

 <?php
}
 ?> 
	
	// for Point
	
	
	
	$("#controls").show();
}
function placeMarker(position, mapInstance, distance) {
		// Create marker 
		var marker = new google.maps.Marker({
		  map: mapInstance,
		  position: position,
		  title: 'Center'
		});

		//center map after click
		/*var iscenteractive = document.getElementById("mapcenter").checked
		if( iscenteractive )
			map.setCenter(position);*/

		//add marker into temp array
		markersArray.push(marker);

		//Add circle overlay and bind to marker
		var circle = new google.maps.Circle({
		  	map: mapInstance,
		  	radius: distance,
		  	fillColor: '#AA0000'
		});
		circle.bindTo('center', marker, 'position');

		circlesArray.push(circle);
	}

	//remove all markers from map
	function removeMarkersAndCircles() {
	    if (markersArray) {
	        for (i=0; i < markersArray.length; i++) {
	            markersArray[i].setMap(null);
	            circlesArray[i].setMap(null);
	        }
	    markersArray.length = 0;
	    circlesArray.length = 0;
	    }
	}

	//write labels into inputs
	function writeLabels(position){
		document.getElementById('maplat').value = position.lat();
		document.getElementById('maplng').value = position.lng();
	}

	function AjaxObject()
	{
		if(window.ActiveXObject)		// For IE
		{
			Ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else if(window.XMLHttpRequest)
		{
			Ajax = new XMLHttpRequest();
		}
		else
			alert("Your Browser Did Not Support AJAX");
		return Ajax;
	}
	//draw marker and circle by location
	function drawByLocation(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		var dis_km1=distance/1000;
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;
		
		
	Ajax = AjaxObject();
		if(Ajax)
		{
			url = "<?php echo SITE_URL; ?>buffer_list.php";
			
			formdata= "lati="+lat+"&lngi="+lng+"&dis_km="+dis_km1;
			Ajax.open("POST",url);
			Ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			Ajax.onreadystatechange = outputdept;
			Ajax.send(formdata);
		}
		else
		{
			alert("Not Supported");
		}
		  
		
		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	placeMarker(position, mapInstance, distance);
    	writeLabels(position);
		
		

	}
	function outputdept()
	{
		if(Ajax.readyState == 4)
		{
		document.getElementById("buffer_detail").innerHTML=Ajax.responseText;
		}
	}
	function bufferoff(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;

		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	/*placeMarker(position, mapInstance, distance);
    	writeLabels(position);*/

	}


$(document).ready(function() {
	var latlng = new google.maps.LatLng('<?php echo $lat  ?>', '<?php echo $lng  ?>');
	var mapOptions = {
		zoom: 19,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.HYBRID
		/*mapTypeControlOptions: {
		style: google.maps.MapTypeControlStyle.DEFAULT
		}*/
	};
	mapInstance = new google.maps.Map(document.getElementById("map1"), mapOptions);

	// Create a new parser for all the KML
	// processStyles: true means we want the styling defined in KML to be what isrendered
	// singleInfoWindow: true means we only want 1 simultaneous info window open
	// zoom: false means we don't want torecenter/rezoom based on KML data
	// afterParse: customAfterparse is a method to add the sidebar once parsing is done
	//
	parser = new geoXML3.parser({
		map: mapInstance,
		processStyles: true,
		singleInfoWindow: true,
		zoom: false,
		afterParse: customAfterParse
		}
	);

	// Add an event listen for the parsed event on the parser
	// Thisrequires a Geoxml3 with the patch defined in Issue 40
	// http://code.google.com/p/geoxml3/issues/detail?id=40
	// We need this event to know when Geoxml3 has compltely defined the coument arrays
	google.maps.event.addListener(parser, 'parsed', completeInit1);

	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
$total=mysql_num_rows($kmlresult);
$file_name_kml="";
$file_kml="";
$i=0;
while($kmldata=mysql_fetch_array($kmlresult))
{
	$i=$i+1;
	if($i<$total)
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'".",";	
	}
	else
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'";		
	}
	
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
}
	?>

parser.parse([<?php echo $file_kml;?>]);
});

</script>
<?php
}
?>
<?php

if ($_GET['map_id']==3)
{
?>
<script type="text/javascript">
var mapInstance;
var parser;
var placemarkMetadata = []; 

<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	
	var <?php echo $justname."Visible";?>=true;

 <?php
	
}
 ?>  

//
// Modified from php.js strcmp at http://phpjs.org/functions/strcmp
// Requires b1 and b2 have name fields
//
function placemarkcmp (b1, b2) {
return ((b1.name == b2.name) ? 0 : ((b1.name > b2.name) ? 1 : -1));
}


//
// Triggered by our parsecomplete event
//
function customAfterParse(docSet) {
	// placemarks is the collection of Geoxml3 placemark instances
	// We're collecting document 0, which we know is the placemarks KML
	var placemarks = docSet[0].placemarks;
	
	var markerIndex, placemarkIndex, loopEnd;

	// Create array of placemark metadata objects, containing name and index into the Geoxml3 document array
	for (markerIdx = 0, loopEnd = placemarks.length; markerIdx < loopEnd; markerIdx++) {
		var currentMetadata = {};

		currentMetadata.name = placemarks[markerIdx].name;
		currentMetadata.index = markerIdx;
		placemarkMetadata.push(currentMetadata);
	}

	// Sort alphabetically by name
	placemarkMetadata.sort(placemarkcmp);

	// Add list items with an HTML id attribute  p##, where ## is the index of the marker we want to trigger
	for (placemarkIndex = 0, loopEnd = placemarkMetadata.length; placemarkIndex < loopEnd; placemarkIndex++) {
		$('#placemarkList').append('<li id="p' + placemarkMetadata[placemarkIndex].index + '">' + placemarkMetadata[placemarkIndex].name + '</li>');
	}
}


//
// Triggered by the parsed event on our parser
//
function completeInit1() {
	
	<?php $kmlsqlp="select * from idip2_dashboard.kmls_add";
$kmlresultp=mysql_query($kmlsqlp);
while($kmldatap=mysql_fetch_array($kmlresultp))
{
	$file_name=$kmldatap['file_name'];
	$attribute_type=$kmldatap['attribute_type'];
	$kmlid=$kmldatap['kid'];
	$kid=$kmlid-1;
	if($file_name=="road.kml" || $file_name=="contour.kml" || $file_name=="canal_center.kml" || $file_name=="canal_center_sarybulak.kml"
	|| $file_name=="contour_sarybulak.kml"|| $file_name=="road_sarybulak.kml")
	{
		?>
		parser.hideDocument(parser.docs[<?php echo $kid;?>]);
		<?php
	}else
	{
	
	?>
	parser.showDocument(parser.docs[<?php echo $kid;?>]);

 <?php
	}
}
 ?>  
	
	
	
	<?php $kmlsqlt="select * from idip2_dashboard.kmls_add";
$kmlresultt=mysql_query($kmlsqlt);
while($kmldatat=mysql_fetch_array($kmlresultt))
{
	$file_namet=$kmldatat['file_name'];
	$attribute_typet=$kmldatat['attribute_type'];
	$arr_filet=explode(".",$file_namet);
	$justnamet=$arr_filet[0];
	if($file_namet=="road.kml" || $file_namet=="contour.kml" || $file_namet=="canal_center.kml" || $file_namet=="canal_center_sarybulak.kml" || 		    $file_namet=="contour_sarybulak.kml" || $file_namet=="road_sarybulak.kml")
	{
		?>
		<?php echo $justnamet."Visible";?>=false;
		<?php
	}else
	{
	
	?>
	<?php echo $justnamet."Visible";?>=true;

 <?php
	}
}
 ?> 
	
	

	// Add event handler for sidebar items
	// Because we're using jQuery 1.7.1, we use on.
	// If we were using previous versions, we'd use live
	$("#placemarkList li").on("click", function(e) {
		 
		// Get the id value, strip off the leading p
		var id = $(this).attr("id");
		id = id.substr(1);
		alert(id);

		// "Click" the marker
		
		google.maps.event.trigger(parser.docs[0].placemarks[id].marker, 'click');
		
		
	});
	
	// Add mouse events so users know when we're hovering on a sidebar elemnt
	$("#placemarkList li").on("mouseenter", function(e) {
			var textcolor = $(this).css("color");
			$(this).css({ 'cursor' : 'pointer', 'color' : '#FFFFFF', 'background-color' : textcolor });
		}).on("mouseleave", function(e) {
			var backgroundcolor = $(this).css("background-color");
			$(this).css({ 'cursor' : 'auto', 'color' : backgroundcolor, 'background-color' : 'transparent' });
		});

	// Highlight visible and invisible sidebar items
	// As user scrolls, the sidebar willreflect visible and invisible placemarks
	google.maps.event.addListener(mapInstance, 'click', function(e) {
		
	
			var distance = parseInt(document.getElementById('mapdistance').value);
		  		if( distance < 1 ){
				  	alert('Your distance is too small');
				}

				//clear map
		  		/*removeMarkersAndCircles();
		  		//draw marker with circle
	    		placeMarker(e.latLng, mapInstance, distance);*/
	    		//write actual position into inputs
	    		writeLabels(e.latLng);
		currentBounds = mapInstance.getBounds();
		for (i = 0; i < parser.docs[0].placemarks.length; i++) {
		
			var myLi = $("#p" + i);
			
			if (currentBounds.contains(parser.docs[0].placemarks[i].marker.getPosition())) {
				myLi.css("color","#000000");
			} else {
				myLi.css("color","#CCCCCC");
			}
			  //window.location.href = 'http://www.google.com';
		}
	});
	
	
	
	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	$("#<?php echo $justname."toggle"; ?>").on("click", function(e) {
		if (<?php echo $justname."Visible"; ?>) {
			parser.hideDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = false;
		} else {
			parser.showDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = true;
		}		
	});

 <?php
}
 ?> 
	
	// for Point
	
	
	
	$("#controls").show();
}
function placeMarker(position, mapInstance, distance) {
		// Create marker 
		var marker = new google.maps.Marker({
		  map: mapInstance,
		  position: position,
		  title: 'Center'
		});

		//center map after click
		/*var iscenteractive = document.getElementById("mapcenter").checked
		if( iscenteractive )
			map.setCenter(position);*/

		//add marker into temp array
		markersArray.push(marker);

		//Add circle overlay and bind to marker
		var circle = new google.maps.Circle({
		  	map: mapInstance,
		  	radius: distance,
		  	fillColor: '#AA0000'
		});
		circle.bindTo('center', marker, 'position');

		circlesArray.push(circle);
	}

	//remove all markers from map
	function removeMarkersAndCircles() {
	    if (markersArray) {
	        for (i=0; i < markersArray.length; i++) {
	            markersArray[i].setMap(null);
	            circlesArray[i].setMap(null);
	        }
	    markersArray.length = 0;
	    circlesArray.length = 0;
	    }
	}

	//write labels into inputs
	function writeLabels(position){
		document.getElementById('maplat').value = position.lat();
		document.getElementById('maplng').value = position.lng();
	}

	function AjaxObject()
	{
		if(window.ActiveXObject)		// For IE
		{
			Ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else if(window.XMLHttpRequest)
		{
			Ajax = new XMLHttpRequest();
		}
		else
			alert("Your Browser Did Not Support AJAX");
		return Ajax;
	}
	//draw marker and circle by location
	function drawByLocation(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		var dis_km1=distance/1000;
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;
		
		
	Ajax = AjaxObject();
		if(Ajax)
		{
			url = "<?php echo SITE_URL; ?>buffer_list.php";
			
			formdata= "lati="+lat+"&lngi="+lng+"&dis_km="+dis_km1;
			Ajax.open("POST",url);
			Ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			Ajax.onreadystatechange = outputdept;
			Ajax.send(formdata);
		}
		else
		{
			alert("Not Supported");
		}
		  
		
		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	placeMarker(position, mapInstance, distance);
    	writeLabels(position);
		
		

	}
	function outputdept()
	{
		if(Ajax.readyState == 4)
		{
		document.getElementById("buffer_detail").innerHTML=Ajax.responseText;
		}
	}
	function bufferoff(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;

		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	/*placeMarker(position, mapInstance, distance);
    	writeLabels(position);*/

	}


$(document).ready(function() {
	var latlng = new google.maps.LatLng('<?php echo $lat  ?>', '<?php echo $lng  ?>');
	var mapOptions = {
		zoom: 19,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.SATELLITE
		/*mapTypeControlOptions: {
		style: google.maps.MapTypeControlStyle.DEFAULT
		}*/
	};
	mapInstance = new google.maps.Map(document.getElementById("map1"), mapOptions);

	// Create a new parser for all the KML
	// processStyles: true means we want the styling defined in KML to be what isrendered
	// singleInfoWindow: true means we only want 1 simultaneous info window open
	// zoom: false means we don't want torecenter/rezoom based on KML data
	// afterParse: customAfterparse is a method to add the sidebar once parsing is done
	//
	parser = new geoXML3.parser({
		map: mapInstance,
		processStyles: true,
		singleInfoWindow: true,
		zoom: false,
		afterParse: customAfterParse
		}
	);

	// Add an event listen for the parsed event on the parser
	// Thisrequires a Geoxml3 with the patch defined in Issue 40
	// http://code.google.com/p/geoxml3/issues/detail?id=40
	// We need this event to know when Geoxml3 has compltely defined the coument arrays
	google.maps.event.addListener(parser, 'parsed', completeInit1);

	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
$total=mysql_num_rows($kmlresult);
$file_name_kml="";
$file_kml="";
$i=0;
while($kmldata=mysql_fetch_array($kmlresult))
{
	$i=$i+1;
	if($i<$total)
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'".",";	
	}
	else
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'";		
	}
	
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
}
	?>

parser.parse([<?php echo $file_kml;?>]);
});

</script>
<?php
}
?>
<?php

if ($_GET['map_id']==4)
{
?>
<script type="text/javascript">
var mapInstance;
var parser;
var placemarkMetadata = []; 

<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	
	var <?php echo $justname."Visible";?>=true;

 <?php
	
}
 ?>  

//
// Modified from php.js strcmp at http://phpjs.org/functions/strcmp
// Requires b1 and b2 have name fields
//
function placemarkcmp (b1, b2) {
return ((b1.name == b2.name) ? 0 : ((b1.name > b2.name) ? 1 : -1));
}


//
// Triggered by our parsecomplete event
//
function customAfterParse(docSet) {
	// placemarks is the collection of Geoxml3 placemark instances
	// We're collecting document 0, which we know is the placemarks KML
	var placemarks = docSet[0].placemarks;
	
	var markerIndex, placemarkIndex, loopEnd;

	// Create array of placemark metadata objects, containing name and index into the Geoxml3 document array
	for (markerIdx = 0, loopEnd = placemarks.length; markerIdx < loopEnd; markerIdx++) {
		var currentMetadata = {};

		currentMetadata.name = placemarks[markerIdx].name;
		currentMetadata.index = markerIdx;
		placemarkMetadata.push(currentMetadata);
	}

	// Sort alphabetically by name
	placemarkMetadata.sort(placemarkcmp);

	// Add list items with an HTML id attribute  p##, where ## is the index of the marker we want to trigger
	for (placemarkIndex = 0, loopEnd = placemarkMetadata.length; placemarkIndex < loopEnd; placemarkIndex++) {
		$('#placemarkList').append('<li id="p' + placemarkMetadata[placemarkIndex].index + '">' + placemarkMetadata[placemarkIndex].name + '</li>');
	}
}


//
// Triggered by the parsed event on our parser
//
function completeInit1() {
	
	<?php $kmlsqlp="select * from idip2_dashboard.kmls_add";
$kmlresultp=mysql_query($kmlsqlp);
while($kmldatap=mysql_fetch_array($kmlresultp))
{
	$file_name=$kmldatap['file_name'];
	$attribute_type=$kmldatap['attribute_type'];
	$kmlid=$kmldatap['kid'];
	$kid=$kmlid-1;
	if($file_name=="road.kml" || $file_name=="contour.kml" || $file_name=="canal_center.kml" || $file_name=="canal_center_sarybulak.kml"
	|| $file_name=="contour_sarybulak.kml"|| $file_name=="road_sarybulak.kml")
	{
		?>
		parser.hideDocument(parser.docs[<?php echo $kid;?>]);
		<?php
	}else
	{
	
	?>
	parser.showDocument(parser.docs[<?php echo $kid;?>]);

 <?php
	}
}
 ?>  
	
	
	
	<?php $kmlsqlt="select * from idip2_dashboard.kmls_add";
$kmlresultt=mysql_query($kmlsqlt);
while($kmldatat=mysql_fetch_array($kmlresultt))
{
	$file_namet=$kmldatat['file_name'];
	$attribute_typet=$kmldatat['attribute_type'];
	$arr_filet=explode(".",$file_namet);
	$justnamet=$arr_filet[0];
	if($file_namet=="road.kml" || $file_namet=="contour.kml" || $file_namet=="canal_center.kml" || $file_namet=="canal_center_sarybulak.kml" || 		    $file_namet=="contour_sarybulak.kml" || $file_namet=="road_sarybulak.kml")
	{
		?>
		<?php echo $justnamet."Visible";?>=false;
		<?php
	}else
	{
	
	?>
	<?php echo $justnamet."Visible";?>=true;

 <?php
	}
}
 ?> 
	
	

	// Add event handler for sidebar items
	// Because we're using jQuery 1.7.1, we use on.
	// If we were using previous versions, we'd use live
	$("#placemarkList li").on("click", function(e) {
		 
		// Get the id value, strip off the leading p
		var id = $(this).attr("id");
		id = id.substr(1);
		alert(id);

		// "Click" the marker
		
		google.maps.event.trigger(parser.docs[0].placemarks[id].marker, 'click');
		
		
	});
	
	// Add mouse events so users know when we're hovering on a sidebar elemnt
	$("#placemarkList li").on("mouseenter", function(e) {
			var textcolor = $(this).css("color");
			$(this).css({ 'cursor' : 'pointer', 'color' : '#FFFFFF', 'background-color' : textcolor });
		}).on("mouseleave", function(e) {
			var backgroundcolor = $(this).css("background-color");
			$(this).css({ 'cursor' : 'auto', 'color' : backgroundcolor, 'background-color' : 'transparent' });
		});

	// Highlight visible and invisible sidebar items
	// As user scrolls, the sidebar willreflect visible and invisible placemarks
	google.maps.event.addListener(mapInstance, 'click', function(e) {
		
	
			var distance = parseInt(document.getElementById('mapdistance').value);
		  		if( distance < 1 ){
				  	alert('Your distance is too small');
				}

				//clear map
		  		/*removeMarkersAndCircles();
		  		//draw marker with circle
	    		placeMarker(e.latLng, mapInstance, distance);*/
	    		//write actual position into inputs
	    		writeLabels(e.latLng);
		currentBounds = mapInstance.getBounds();
		for (i = 0; i < parser.docs[0].placemarks.length; i++) {
		
			var myLi = $("#p" + i);
			
			if (currentBounds.contains(parser.docs[0].placemarks[i].marker.getPosition())) {
				myLi.css("color","#000000");
			} else {
				myLi.css("color","#CCCCCC");
			}
			  //window.location.href = 'http://www.google.com';
		}
	});
	
	
	
	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
while($kmldata=mysql_fetch_array($kmlresult))
{
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
	
	?>
	$("#<?php echo $justname."toggle"; ?>").on("click", function(e) {
		if (<?php echo $justname."Visible"; ?>) {
			parser.hideDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = false;
		} else {
			parser.showDocument(parser.docs[<?php echo $kidd;?>]);
			<?php echo $justname."Visible"; ?> = true;
		}		
	});

 <?php
}
 ?> 
	
	// for Point
	
	
	
	$("#controls").show();
}
function placeMarker(position, mapInstance, distance) {
		// Create marker 
		var marker = new google.maps.Marker({
		  map: mapInstance,
		  position: position,
		  title: 'Center'
		});

		//center map after click
		/*var iscenteractive = document.getElementById("mapcenter").checked
		if( iscenteractive )
			map.setCenter(position);*/

		//add marker into temp array
		markersArray.push(marker);

		//Add circle overlay and bind to marker
		var circle = new google.maps.Circle({
		  	map: mapInstance,
		  	radius: distance,
		  	fillColor: '#AA0000'
		});
		circle.bindTo('center', marker, 'position');

		circlesArray.push(circle);
	}

	//remove all markers from map
	function removeMarkersAndCircles() {
	    if (markersArray) {
	        for (i=0; i < markersArray.length; i++) {
	            markersArray[i].setMap(null);
	            circlesArray[i].setMap(null);
	        }
	    markersArray.length = 0;
	    circlesArray.length = 0;
	    }
	}

	//write labels into inputs
	function writeLabels(position){
		document.getElementById('maplat').value = position.lat();
		document.getElementById('maplng').value = position.lng();
	}

	function AjaxObject()
	{
		if(window.ActiveXObject)		// For IE
		{
			Ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else if(window.XMLHttpRequest)
		{
			Ajax = new XMLHttpRequest();
		}
		else
			alert("Your Browser Did Not Support AJAX");
		return Ajax;
	}
	//draw marker and circle by location
	function drawByLocation(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		var dis_km1=distance/1000;
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;
		
		
	Ajax = AjaxObject();
		if(Ajax)
		{
			url = "<?php echo SITE_URL; ?>buffer_list.php";
			
			formdata= "lati="+lat+"&lngi="+lng+"&dis_km="+dis_km1;
			Ajax.open("POST",url);
			Ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			Ajax.onreadystatechange = outputdept;
			Ajax.send(formdata);
		}
		else
		{
			alert("Not Supported");
		}
		  
		
		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	placeMarker(position, mapInstance, distance);
    	writeLabels(position);
		
		

	}
	function outputdept()
	{
		if(Ajax.readyState == 4)
		{
		document.getElementById("buffer_detail").innerHTML=Ajax.responseText;
		}
	}
	function bufferoff(){
	
		var distance = parseInt(document.getElementById('mapdistance').value);
		
	  	if( distance < 1 ){
		  	alert('Your distance is too small');
		}

	  	//get values from inputs
		var lat = document.getElementById('maplat').value;
		var lng = document.getElementById('maplng').value;

		var position = new google.maps.LatLng(lat, lng);

		//create marker and circle
		removeMarkersAndCircles();
    	/*placeMarker(position, mapInstance, distance);
    	writeLabels(position);*/

	}


$(document).ready(function() {
	var latlng = new google.maps.LatLng('<?php echo $lat  ?>', '<?php echo $lng  ?>');
	var mapOptions = {
		zoom: 19,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.TERRAIN
		/*mapTypeControlOptions: {
		style: google.maps.MapTypeControlStyle.DEFAULT
		}*/
	};
	mapInstance = new google.maps.Map(document.getElementById("map1"), mapOptions);

	// Create a new parser for all the KML
	// processStyles: true means we want the styling defined in KML to be what isrendered
	// singleInfoWindow: true means we only want 1 simultaneous info window open
	// zoom: false means we don't want torecenter/rezoom based on KML data
	// afterParse: customAfterparse is a method to add the sidebar once parsing is done
	//
	parser = new geoXML3.parser({
		map: mapInstance,
		processStyles: true,
		singleInfoWindow: true,
		zoom: false,
		afterParse: customAfterParse
		}
	);

	// Add an event listen for the parsed event on the parser
	// Thisrequires a Geoxml3 with the patch defined in Issue 40
	// http://code.google.com/p/geoxml3/issues/detail?id=40
	// We need this event to know when Geoxml3 has compltely defined the coument arrays
	google.maps.event.addListener(parser, 'parsed', completeInit1);

	<?php $kmlsql="select * from idip2_dashboard.kmls_add";
$kmlresult=mysql_query($kmlsql);
$total=mysql_num_rows($kmlresult);
$file_name_kml="";
$file_kml="";
$i=0;
while($kmldata=mysql_fetch_array($kmlresult))
{
	$i=$i+1;
	if($i<$total)
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'".",";	
	}
	else
	{
	$file_name_kml="kml/".$kmldata['file_name'];
	$file_kml.="'$file_name_kml'";		
	}
	
	$file_name=$kmldata['file_name'];
	$kmlid_1=$kmldata['kid'];
	$kidd=$kmlid_1-1;
	$arr_file=explode(".",$file_name);
	$justname=$arr_file[0];
}
	?>

parser.parse([<?php echo $file_kml;?>]);
});

</script>
<?php
}
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7Ss8YZUpv0rU4NuPGvKC8hLNRT3dYvPo"></script>

<?php
/*$result_dis = mysql_query("SELECT name FROM p2001district where code=".$dcode);
$data_dis=mysql_fetch_array($result_dis); */


?>

<?php /*?><h3 style="margin-left:55px;"><span style="font-size:18px"><?=$data_dis['name'];  ?></span></h3><?php */?>
<ul id="gmaps" style="margin-left:70px;">
<li><a href="detail_link.php?map_id=3&unique_id=<?php echo $unique_id;?>"> <?php echo SATELLITE?></a></li>
<li ><a href="detail_link.php?map_id=2&unique_id=<?php echo $unique_id;?>"><?php echo HYBRID?></a></li><li>
 <li ><a href="detail_link.php?map_id=1&unique_id=<?php echo $unique_id;?>"><?php echo ROADMAP?></a></li>
<li><a href="detail_link.php?map_id=4&unique_id=<?php echo $unique_id;?>"><?php echo TERRAIN?></a></li>
</ul>
<div id="maincol" style="margin-left:6px;">
			<div id="map1" style="float:left" ></div>
			<?php /*?><div id="legends" style="float:left; border:dashed 2px; width:200px; height:450px; padding-left:20px;"  ><h3>Legends</h3>
		
            <p><input type="checkbox" id="pointtoggle" checked="checked" /><label for="pointtoggle"> Electric Pole</label>:<img src="<?php echo $_CONFIG['site_url'];?>kml/Layer0_Symbol_137d6638_0.png" alt=" Point"  /></p>
			</div><?php */?>
			<div style="clear:both"></div>
			
		</div>
<?php /*?><div id="mainTable" style="margin-left:55px; width:89%">

	<table cellspacing="0" cellpadding="0" border="1px"  align="center" width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; margin-top:20px;">
     
      <tr style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold; background-color:#0CF">
        <td colspan="3" width="810" align="center" height="30px">Status of Water Supply Schemes</td>
      </tr>
      <tr style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold; background-color:#85bc40; height:23px">
        <td width="250" height="30px" align="center">Functional</td>
        <td width="130" height="30px" align="center">Non-Functional</td>
        <td width="130" height="30px" align="center">Abandoned</td>
       
      </tr>
<?php 
$result_fun = mysql_query("SELECT COUNT(*) as total_f FROM p2005wss where status=1 and dcode=".$dcode);
$data_fun=mysql_fetch_array($result_fun);
$result_nfun = mysql_query("SELECT COUNT(*) as total_nf FROM p2005wss where status=2 and dcode=".$dcode);
$data_nfun=mysql_fetch_array($result_nfun);
$result_aban = mysql_query("SELECT COUNT(*) as total_ab FROM p2005wss where status=3 and dcode=".$dcode);
$data_aban=mysql_fetch_array($result_aban);

?>
      <tr>
    
        <td width="130" height="30px" align="center"><a  href="javascript:void(null);" onClick="doToggle1('fun_1');" title="functional" style="text-decoration:none; color:black"><?=$data_fun['total_f']?></a></td>
        <td width="130" height="30px"  align="center"><a  href="javascript:void(null);" onClick="doToggle1('nfun_1');" title="nonfunctional" style="text-decoration:none; color:black"><?=$data_nfun['total_nf']?></a></td>
        <td width="130" height="30px"  align="center"><a  href="javascript:void(null);" onClick="doToggle1('aban_1');" title="abandoned" style="text-decoration:none; color:black"><?=$data_aban['total_ab']?></a></td>
        
      </tr>

    </table>
	
<br />
<div id="fun_1" style="display:none;" >
<?php
 $iCount = 0;
  
	 $SQL = "SELECT b.sno as sno,b.wssname as wssname, b.exeagency as exeagency,b.dcode as dcode,b.tcode as tcode,b.vcode as vcode,b.exeagencyval as exeagencyval,b.omagency as omagency,b.omagencyval as omagencyval,b.status as status,b.statusval as statusval,b.reason as reason,b.reasonval as reasonval from p2003village a inner join p2005wss b on (a.giscode=b.giscode) where b.dcode=".$dcode." and status=1";
   $res_sql= mysql_query($SQL);
    $iCount = mysql_num_rows($res_sql);
    ?>
    <table cellspacing="0" cellpadding="0" border="1px"  align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; margin-top:20px; width:100%">
     
      <tr style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold; background-color:#0CF">
        <td colspan="5" width="810" align="center" height="30px">List of Water Supply Schemes</td>
      </tr>
      <tr style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold; background-color:#85bc40; height:23px">
        <td width="250" align="center">Name</td>
        <td width="130" align="center">Executing Agency</td>
        <td width="130" align="center">Operating Agency</td>
        <td width="130" align="center">Status</td>
        <td width="170" align="center">Remarks</td>
      </tr>
<?php while($ress=mysql_fetch_array($res_sql))
{
?>
      <tr>
        <td width="250" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;height:23px; background-color:#85bc40;"><a href="qrdash-home.php?behavid=<?php echo $behavid ?>&componentid=<?php echo $ress['dcode'] ?>&subcomponentid=<?php echo $ress['tcode'] ?>&activityid=<?php echo $ress['vcode'] ?>" target="_blank" style="color:black; font-weight:normal"><? echo $ress['wssname']?></a></td>
        <td width="130" align="center"><?=$ress['exeagencyval']?></td>
        <td width="130" align="center"><?=$ress['omagencyval'] ?></td>
        <td width="130" align="center"><?=$ress['statusval'] ?></td>
        <td width="130" align="center"><?= $ress['reasonval']?></td>
      </tr>
<?php } ?>
    </table>
	</div>
	<div id="nfun_1" style="display:none;" >
<?php
 $iCount = 0;
    $SQL = "SELECT b.sno as sno,b.wssname as wssname, b.exeagency as exeagency,b.dcode as dcode,b.tcode as tcode,b.vcode as vcode,b.exeagencyval as exeagencyval,b.omagency as omagency,b.omagencyval as omagencyval,b.status as status,b.statusval as statusval,b.reason as reason,b.reasonval as reasonval from p2003village a inner join p2005wss b on (a.giscode=b.giscode) where b.dcode=".$dcode." and status=2";
   $res_sql= mysql_query($SQL);
    $iCount = mysql_num_rows($res_sql);
    ?>
    <table cellspacing="0" cellpadding="0" border="1px"  align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; margin-top:20px;width:100%">
     
      <tr style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold; background-color:#0CF">
        <td colspan="5" width="810" align="center" height="30px">List of Water Supply Schemes</td>
      </tr>
      <tr style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold; background-color:#85bc40; height:23px">
        <td width="250" align="center">Name</td>
        <td width="130" align="center">Executing Agency</td>
        <td width="130" align="center">Operating Agency</td>
        <td width="130" align="center">Status</td>
        <td width="170" align="center">Remarks</td>
      </tr>
<?php while($ress=mysql_fetch_array($res_sql))
{
?>
      <tr>
        <td width="250" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;height:23px; background-color:#85bc40;"><a href="qrdash-home.php?behavid=<?php echo $behavid ?>&componentid=<?php echo $ress['dcode'] ?>&subcomponentid=<?php echo $ress['tcode'] ?>&activityid=<?php echo $ress['vcode'] ?>" target="_blank" style="color:black; font-weight:normal"><? echo $ress['wssname']?></a></td>
        <td width="130" align="center"><?=$ress['exeagencyval']?></td>
        <td width="130" align="center"><?=$ress['omagencyval'] ?></td>
        <td width="130" align="center"><?=$ress['statusval'] ?></td>
        <td width="130" align="center"><?= $ress['reasonval']?></td>
      </tr>
<?php } ?>
    </table>
	
	</div>
	<div id="aban_1" style="display:none;" >
<?php
 $iCount = 0;
 $SQL = "SELECT b.sno as sno,b.wssname as wssname, b.exeagency as exeagency,b.dcode as dcode,b.tcode as tcode,b.vcode as vcode,b.exeagencyval as exeagencyval,b.omagency as omagency,b.omagencyval as omagencyval,b.status as status,b.statusval as statusval,b.reason as reason,b.reasonval as reasonval from p2003village a inner join p2005wss b on (a.giscode=b.giscode) where b.dcode=".$dcode." and status=3";
   $res_sql= mysql_query($SQL);
    $iCount = mysql_num_rows($res_sql);
    ?>
    <table cellspacing="0" cellpadding="0" border="1px"  align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; margin-top:20px;width:100%">
     
      <tr style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold; background-color:#0CF">
        <td colspan="5" width="810" align="center" height="30px">List of Water Supply Schemes</td>
      </tr>
      <tr style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold; background-color:#85bc40; height:23px">
        <td width="250" align="center">Name</td>
        <td width="130" align="center">Executing Agency</td>
        <td width="130" align="center">Operating Agency</td>
        <td width="130" align="center">Status</td>
        <td width="170" align="center">Remarks</td>
      </tr>
<?php while($ress=mysql_fetch_array($res_sql))
{
?>
      <tr>
        <td width="250" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;height:23px; background-color:#85bc40;"><a href="qrdash-home.php?behavid=<?php echo $behavid ?>&componentid=<?php echo $ress['dcode'] ?>&subcomponentid=<?php echo $ress['tcode'] ?>&activityid=<?php echo $ress['vcode'] ?>" target="_blank" style="color:black; font-weight:normal"><? echo $ress['wssname']?></a></td>
        <td width="130" align="center"><?=$ress['exeagencyval']?></td>
        <td width="130" align="center"><?=$ress['omagencyval'] ?></td>
        <td width="130" align="center"><?=$ress['statusval'] ?></td>
        <td width="130" align="center"><?= $ress['reasonval']?></td>
      </tr>
<?php } ?>
    </table>
	</div>
	<br />
	</div><?php */?>