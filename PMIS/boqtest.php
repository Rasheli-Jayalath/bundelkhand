<?php
$db = mysql_connect("localhost", "root", "") or die("Could not connect.");
if(!$db) 
	die("no db");
if(!mysql_select_db("pmst2_pmis",$db))
 	die("No database selected.");
 $sql="SELECT *  FROM  boq";
 $amountresult = mysql_query($sql);
 while($data=mysql_fetch_array($amountresult))
 {
echo $amount=$data["boqqty"]*$data["boqrate"];
echo $sql1="UPDATE boq SET boqamount='".$amount."' where boqid=".$data["boqid"];
  mysql_query($sql1);
echo "<br/>";

}


		