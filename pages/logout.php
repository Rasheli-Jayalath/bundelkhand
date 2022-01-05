<?php
$user_cd = $objAdminUser->user_cd;
session_name(PNAME);
session_start();
$objAdminUser->setLogout();
redirect('./');
?>