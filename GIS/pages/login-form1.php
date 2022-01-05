<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	 $username 	= trim($_POST['username']);
	 $passwd 	= trim($_POST['password']);
	//$user_type	= trim($_POST['user_type']);
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("username", LOGIN_FLD_VAL_USERNAME, "S");
	$objValidate->setCheckField("password", LOGIN_FLD_VAL_PASSWD, "S");
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
		$objAdminUser->setProperty("username", $username);
//		$objAdminUser->setProperty("passwd", md5($passwd));
		$objAdminUser->setProperty("passwd", $passwd);
		
		$objAdminUser->lstAdminUser();
		if($objAdminUser->totalRecords() >= 1){
		//$objAdminUser->setProperty("user_type", $user_type);
		$objAdminUser->lstAdminUser();
		if($objAdminUser->totalRecords() >= 1){
			$rows = $objAdminUser->dbFetchArray(1);
			$fullname = $rows['first_name'] . " " . $rows['last_name'];
			$objAdminUser->setProperty("user_cd", $rows['user_cd']);
			$objAdminUser->setProperty("username", $rows['username']);
			$objAdminUser->setProperty("fullname_name", $fullname);
			$objAdminUser->setProperty("user_type", $rows['user_type']);
			$log_time= date('Y-m-d H:i:s');
			$objAdminUser->setProperty("logged_in_time", date('Y-m-d H:i:s'));
			$objAdminUser->setProperty("member_cd", $rows['member_cd']);
			$objAdminUser->setProperty("designation", $rows['designation']);
			$objAdminUser->setProperty("user_country", $rows['user_country']);
			$objAdminUser->setProperty("gmc", $rows['gmc']);
			$objAdminUser->setProperty("gmcadm", $rows['gmcadm']);
			$objAdminUser->setProperty("gmcentry", $rows['gmcentry']);
			$objAdminUser->setAdminLogin();
		/***** Log Entry *****/
		
			$ip = $_SERVER['REMOTE_ADDR'];
			$ipadd = $ip;
			$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$nowdt = date("Y-m-d H:i:s");
			$sSQLlog = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname) VALUES ('$rows[user_cd]', '$rows[username]', '$nowdt', '$ipadd', '$hostname')";
			mysql_query($sSQLlog);
			$urid=mysql_insert_id();
			$_SESSION['urid']=$urid;
		
		
		
	/*	$log_desc 	= "User <strong>" . $fullname . "</strong> is login at.". $log_time;
			$log_module = "Login";
			$log_title 	= "User Login";
			doLog($log_module, $log_title, $log_desc,$rows['user_cd']);*/
				if(isset($_SERVER["REQUEST_URI"]))
			{
			$url="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			header("location:".$url);
			}
			else
			{
			header("location: index.php");
			}
			
		}
		else
		{
			$objCommon->setMessage("Invalid User Accesss Rights! Please try again", 'Error');
		}
		}
		else{
			$objCommon->setMessage(LOGIN_FLD_INVALID, 'Error');
		}
	}
}
?>

<script>
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.username.value == ""){
		msg = msg + "\r\n<?php echo LOGIN_FLD_VAL_USERNAME;?>";
		flag = false;
	}
	if(frm.password.value == ""){
		msg = msg + "\r\n<?php echo LOGIN_FLD_VAL_PASSWD;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
	
}
</script>
<script type="text/javascript">
function toggleDiv(divId) {
 /*  $("#"+divId).toggle();*/
   $("#"+divId).hide(800);
/*   $("p").hide("slow");*/

}
</script>

<div id="wrapper_MemberLogin_main" style="">
	<h1 style="color:#000"></h1>
	<div class="clear"></div>
	<div id="LoginBox" class="borderRound borderShadow">
		<!--<div id="useralert">Please Enter Correct User/Pass.</div>-->
		<?php echo $objCommon->displayMessage();?>  
        
        		<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
            
            <div class="limiter">
		<div class="container-login100" style="height:">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">
					<span class="login100-form-title-1" style="margin-top:20px">
						Second Irrigation and Drainage Improvement Project <br/>(IDIP2)
					</span>
				</div>

				<form class="login100-form validate-form" onsubmit="return frmValidate(this);" method="post">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Username</span>
			 <input name="username" type="text" id="username" style="margin-top:13px" value="<?php echo $_POST['username'];?>" class="userinbox"
              placeholder="Username" />
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
			 <input name="password" id="password" type="password" style="margin-top:13px" class="userinbox" placeholder="Password"/>
						<span class="focus-input100"></span>
					</div>


					<div class="container-login100-form-btn">
					<input type="submit" name="Submit" value="<?php echo LOGIN_BTN_LOGIN;?>" id="uLogin" />
				</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<script src="js/main.js"></script>

        
        
            
<!--	<form name="frmlogin" onsubmit="return frmValidate(this);" method="post" action="">
	  
	  	<div class="loginboxContainer borderRound borderShadow">
			<div id="username1">
			 <input name="username" type="text" id="username" value="" class="userinbox"/>
			</div>
		</div>
		<div class="loginboxContainer borderRound borderShadow">
			<div id="userpass">
			 <input name="password" id="password" type="password" class="userinbox"/>
			</div>
		</div>	  
-->	  
	  	<!--<div class="loginboxContainer borderRound borderShadow">
			<div id="usertype">
			  <input type="radio"  
			id="user_type" name="user_type" value="1" />
			 SuperAdmin 
			 <input type="radio" 
			 id="user_type" name="user_type" value="2" checked="checked"/>
			SubAdmin
            <input type="radio" 
			 id="user_type" name="user_type" value="3" />
			User</div>
		</div>-->
		
<!--	  <div id="userLogin"> <input type="submit" name="Submit" value="<?php echo LOGIN_BTN_LOGIN;?>" id="uLogin" />
	    
	  </div>
	 
	  <div class="clear"></div>	  
      </form>
	</div>
-->	 <!--<div id="forgotPass"><a href="./?forgot=forgot" id="forgotPass">Forgot Password?</a></div>-->
</div>
