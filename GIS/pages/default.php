<?php
 $incPage = $objCommon->getAdminPage(trim($_GET['p']));
 if(isset($incPage)&&$incPage!="")
{
//include ('includes/saveurl.php');
require_once("$incPage");
}

?>
