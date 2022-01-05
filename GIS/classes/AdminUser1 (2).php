<?php
/**
*
* This is a class AdminUser
* @version 0.01
* @author
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by 
*
**/
class AdminUser extends Database{
	public $is_login;
	public $user_cd;
	public $user_name;
	public $fullname_name;
	public $logged_in_time;
	public $user_type;
	public $member_cd;
	public $designation;
	public $user_country;
	public $ne_gmc;
	public $ne_gmcadm;
	public $ne_gmcentry;

	/*
	* This is the constructor of the class AdminUser
	* @author
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by 
	*/
	public function __construct(){
		parent::__construct();
		if($_SESSION['is_login'] == true){
			$this->is_login 		= $_SESSION['is_login'];
			$this->user_cd 			= $_SESSION['user_cd'];
			$this->username 		= $_SESSION['username'];
			$this->user_type 		= $_SESSION['user_type'];
			$this->fullname_name 	= $_SESSION['fullname_name'];
			$this->logged_in_time 	= $_SESSION['logged_in_time'];
			$this->member_cd 	= $_SESSION['member_cd'];
			$this->designation 	= $_SESSION['designation'];
			$this->user_country = $_SESSION['user_country'];
				$this->ne_gmc 			= $_SESSION['ne_gmc'];
			$this->ne_gmcadm 		= $_SESSION['ne_gmcadm'];
			$this->ne_gmcentry 	= $_SESSION['ne_gmcentry'];
		}
	}

	/*
	* This is the function to set the admin user logged in
	* @author 
	* @Date 13 Dec, 2007
	* @modified 13 Dec, 2007 by 
	*/
	public function setAdminLogin(){
		$_SESSION['is_login'] 	= true;
		if($this->isPropertySet("user_cd", "V"))
			$_SESSION['user_cd'] 		= $this->getProperty("user_cd");
		if($this->isPropertySet("username", "V"))
			$_SESSION['username'] 		= $this->getProperty("username");
		if($this->isPropertySet("logged_in_time", "V"))
			$_SESSION['logged_in_time'] 	= $this->getProperty("logged_in_time");
		if($this->isPropertySet("user_type", "V"))
			$_SESSION['user_type'] 		= $this->getProperty("user_type");
		if($this->isPropertySet("member_cd", "V"))
			$_SESSION['member_cd'] 		= $this->getProperty("member_cd");
			if($this->isPropertySet("designation", "V"))
			$_SESSION['designation'] 		= $this->getProperty("designation");
		if($this->isPropertySet("fullname_name", "V"))
			$_SESSION['fullname_name'] 		= $this->getProperty("fullname_name");
			if($this->isPropertySet("user_country", "V"))
			$_SESSION['user_country'] 		= $this->getProperty("user_country");
				if($this->isPropertySet("gmc", "V"))
			$_SESSION['ne_gmc'] 		= $this->getProperty("gmc");
		if($this->isPropertySet("gmcadm", "V"))
			$_SESSION['ne_gmcadm'] 		= $this->getProperty("gmcadm");
		if($this->isPropertySet("gmcentry", "V"))
			$_SESSION['ne_gmcentry'] 		= $this->getProperty("gmcentry");
	}
	
	/*
	* This is the function to unset the session variables
	* @author 
	* @Date 13 Dec, 2007
	* @modified 13 Dec, 2007 by 
	*/
	public function setLogout(){
		unset(
				$_SESSION['is_login'], 
				$_SESSION['user_cd'], 
				$_SESSION['username'], 
				$_SESSION['logged_in_time'], 
				$_SESSION['user_type'], 
				$_SESSION['fullname_name'],
				$_SESSION['member_cd'],
				$_SESSION['designation'],
				$_SESSION['user_country'],
				$_SESSION['ne_gmc'],
				$_SESSION['ne_gmcadm'],
				$_SESSION['ne_gmcentry']
			);
	}
	
	/*
	* This function is used to list the admin users
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function lstAdminUser(){
		$Sql = "SELECT 
					user_cd,
					username,
					passwd,
					first_name,
					last_name,
					CONCAT(first_name,' ',last_name) AS fullname,
					email,
					designation,
					phone,
					user_type,
					last_login_date,
					is_active,
					member_cd,
					user_country,
					gmc,
					gmcadm,
					gmcentry
				FROM
					mis_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("user_cd", "V"))
			$Sql .= " AND user_cd=" . $this->getProperty("user_cd");
		if($this->isPropertySet("username", "V"))
			$Sql .= " AND username='" . $this->getProperty("username") . "'";
		if($this->isPropertySet("passwd", "V"))
			$Sql .= " AND passwd='" . $this->getProperty("passwd") . "'";
			/*if($this->isPropertySet("user_type", "V"))
			$Sql .= " AND user_type='" . $this->getProperty("user_type") . "'";*/
			if($this->isPropertySet("user_name", "V")){
			$Sql .= " AND (LOWER(first_name) LIKE '%" . $this->getProperty("user_name") . "%' OR LOWER(last_name) LIKE '%" . $this->getProperty("user_name") . "%' OR LOWER(username) LIKE '%" . $this->getProperty("user_name") . "%')";
		}
		if($this->isPropertySet("limit", "V"))
			 $Sql .= $this->appendLimit($this->getProperty("limit"));
		$this->dbQuery($Sql);
	
	}
	
	public function lstAsset(){
		$Sql = "SELECT asset_id, asset_name, asset_desc, asset_dop, asset_validity, asset_ownership, asset_location, asset_ref, asset_issue_to, country, asset_no FROM tbl_assets 
				WHERE 
					1=1";
			if($this->isPropertySet("asset_id", "V"))
			$Sql .= " AND asset_id=" . $this->getProperty("asset_id");
		if($this->isPropertySet("asset_no", "V"))
			$Sql .= " AND asset_no=" . $this->getProperty("asset_no");
		if($this->isPropertySet("country", "V"))
			$Sql .= " AND country='" . $this->getProperty("country") . "'";
		if($this->isPropertySet("asset_name", "V"))
			$Sql .= " AND asset_name='" . $this->getProperty("asset_name") . "'";
			
	
		if($this->isPropertySet("limit", "V"))
			 $Sql .= $this->appendLimit($this->getProperty("limit"));
		$this->dbQuery($Sql);
	
	}
	
	////Staff Member Directory
		public function lstStaffMember(){
		$Sql = "SELECT 
					member_cd,
					first_name,
					last_name,
					CONCAT(first_name,' ',last_name) AS fullname,
					position,
					cell_no,
					landline,
					email,
					address
				FROM
					mis_tbl_staff_directory
				WHERE 
					1=1";
		if($this->isPropertySet("member_cd", "V"))
			$Sql .= " AND member_cd=" . $this->getProperty("member_cd");
		if($this->isPropertySet("first_name", "V")){
			$Sql .= " AND (LOWER(first_name) LIKE '%" . $this->getProperty("first_name") . "%')";
			}
		if($this->isPropertySet("last_name", "V")){
			$Sql .= " AND (LOWER(last_name) LIKE '%" . $this->getProperty("last_name") . "%')";
		}
		if($this->isPropertySet("position", "V")){
			$Sql .= " AND (LOWER(position) LIKE '%" . $this->getProperty("position") . "%')";
		}
		if($this->isPropertySet("cell_no", "V")){
			$Sql .= " AND (LOWER(cell_no) LIKE '%" . $this->getProperty("cell_no") . "%')";
		}
		if($this->isPropertySet("landline", "V")){
			$Sql .= " AND (LOWER(landline) LIKE '%" . $this->getProperty("landline") . "%')";
		}
		if($this->isPropertySet("email", "V")){
			$Sql .= " AND (LOWER(email) LIKE '%" . $this->getProperty("email") . "%')";
		}if($this->isPropertySet("address", "V")){
			$Sql .= " AND (LOWER(address) LIKE '%" . $this->getProperty("address") . "%')";
		}
		if($this->isPropertySet("limit", "V"))
			 $Sql .= $this->appendLimit($this->getProperty("limit"));
		$this->dbQuery($Sql);
	}
	
	public function actStaffMember($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO mis_tbl_staff_directory(
						member_cd,
						first_name,
						last_name,
						position,
						cell_no,
						landline,
						email,
						address
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("member_cd", "V") ? $this->getProperty("member_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("first_name", "V") ? "'" . $this->getProperty("first_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("last_name", "V") ? "'" . $this->getProperty("last_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("position", "V") ? "'" . $this->getProperty("position") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cell_no", "V") ? "'" . $this->getProperty("cell_no") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("landline", "V") ? "'" . $this->getProperty("landline") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("email", "V") ? "'" . $this->getProperty("email") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("address", "V") ? "'" . $this->getProperty("address") . "'" : "NULL";
						
				$Sql .= ")";
				echo $Sql;
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_staff_directory SET ";
				
				if($this->isPropertySet("first_name", "K")){
					$Sql .= "$con first_name='" . $this->getProperty("first_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("last_name", "K")){
					$Sql .= "$con last_name='" . $this->getProperty("last_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("position", "K")){
					$Sql .= "$con position='" . $this->getProperty("position") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cell_no", "K")){
					$Sql .= "$con cell_no='" . $this->getProperty("cell_no") . "'";
					$con = ",";
				}
				if($this->isPropertySet("landline", "K")){
					$Sql .= "$con landline='" . $this->getProperty("landline") . "'";
					$con = ",";
				}				
				if($this->isPropertySet("email", "K")){
					$Sql .= "$con email='" . $this->getProperty("email") . "'";
					$con = ",";
				}
				if($this->isPropertySet("address", "K")){
					$Sql .= "$con address='" . $this->getProperty("address") . "'";
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND member_cd=" . $this->getProperty("member_cd");
				echo $Sql;
				break;
			case "D":
				$Sql = "Delete from mis_tbl_staff_directory 
						WHERE
							1=1";
				$Sql .= " AND member_cd=" . $this->getProperty("member_cd");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function actAsset($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO tbl_assets(
						asset_id,
						asset_no,
						asset_name,
						asset_desc,
						asset_dop,
						asset_validity,
						asset_ownership,
						asset_location,
                        asset_ref,
                        asset_issue_to,
                        country
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("asset_id", "V") ? $this->getProperty("asset_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("asset_no", "V") ? "'" . $this->getProperty("asset_no") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("asset_name", "V") ? "'" . $this->getProperty("asset_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("asset_desc", "V") ? "'" . $this->getProperty("asset_desc") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("asset_dop", "V") ? "'" . $this->getProperty("asset_dop") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("asset_validity", "V") ? "'" . $this->getProperty("asset_validity") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("asset_ownership", "V") ? "'" . $this->getProperty("asset_ownership") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("asset_location", "V") ? "'" . $this->getProperty("asset_location") . "'" : "NULL";
                $Sql .= ",";
				$Sql .= $this->isPropertySet("asset_ref", "V") ? "'" . $this->getProperty("asset_ref") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("asset_issue_to", "V") ? "'" . $this->getProperty("asset_issue_to") . "'" : "NULL";
                $Sql .= ",";
				$Sql .= $this->isPropertySet("country", "V") ? "'" . $this->getProperty("country") . "'" : "NULL";
						
				$Sql .= ")";
				echo $Sql;
				break;
			case "U":
				$Sql = "UPDATE tbl_assets SET ";
				
				if($this->isPropertySet("asset_no", "K")){
					$Sql .= "$con asset_no='" . $this->getProperty("asset_no") . "'";
					$con = ",";
				}
				if($this->isPropertySet("asset_name", "K")){
					$Sql .= "$con asset_name='" . $this->getProperty("asset_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("asset_desc", "K")){
					$Sql .= "$con asset_desc='" . $this->getProperty("asset_desc") . "'";
					$con = ",";
				}
				if($this->isPropertySet("asset_dop", "K")){
					$Sql .= "$con asset_dop='" . $this->getProperty("asset_dop") . "'";
					$con = ",";
				}
				if($this->isPropertySet("asset_validity", "K")){
					$Sql .= "$con asset_validity='" . $this->getProperty("asset_validity") . "'";
					$con = ",";
				}				
				if($this->isPropertySet("asset_ownership", "K")){
					$Sql .= "$con asset_ownership='" . $this->getProperty("asset_ownership") . "'";
					$con = ",";
				}
				if($this->isPropertySet("asset_location", "K")){
					$Sql .= "$con asset_location='" . $this->getProperty("asset_location") . "'";
					$con = ",";
				}
                if($this->isPropertySet("asset_ref", "K")){
					$Sql .= "$con asset_ref='" . $this->getProperty("asset_ref") . "'";
					$con = ",";
				}
                if($this->isPropertySet("asset_issue_to", "K")){
					$Sql .= "$con asset_issue_to='" . $this->getProperty("asset_issue_to") . "'";
					$con = ",";
				}
                if($this->isPropertySet("country", "K")){
					$Sql .= "$con country='" . $this->getProperty("country") . "'";
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND asset_id=" . $this->getProperty("asset_id");
				echo $Sql;
				break;
			case "D":
				$Sql = "Delete from tbl_assets 
						WHERE
							1=1";
				$Sql .= " AND asset_id=" . $this->getProperty("asset_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	/*
	* This function is used to perform DML (Delete/Update/Add)
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function actAdminUser($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO mis_tbl_users(
						user_cd,
						username,
						passwd,
						first_name,
						last_name,
						email,
						phone,
						designation,
						user_type,
						last_login_date,
						is_active,
						gmc,
						gmcadm,
						gmcentry) 
						VALUES(";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("username", "V") ? "'" . $this->getProperty("username") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("passwd", "V") ? "'" . $this->getProperty("passwd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("first_name", "V") ? "'" . $this->getProperty("first_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("last_name", "V") ? "'" . $this->getProperty("last_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("email", "V") ? "'" . $this->getProperty("email") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("phone", "V") ? "'" . $this->getProperty("phone") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("designation", "V") ? "'" . $this->getProperty("designation") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_type", "V") ? "'" . $this->getProperty("user_type") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("last_login_date", "V") ? "'" . $this->getProperty("last_login_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_active", "V") ? "'" . $this->getProperty("is_active") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("gmc", "V") ?$this->getProperty("gmc") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("gmcadm", "V") ?$this->getProperty("gmcadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("gmcentry", "V") ? $this->getProperty("gmcentry") : "0";
						
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_users SET ";
				if($this->isPropertySet("username", "K")){
					$Sql .= "username='" . $this->getProperty("username") . "'";
					$con = ",";
				}
				if($this->isPropertySet("passwd", "K")){
					$Sql .= "$con passwd='" . $this->getProperty("passwd") . "'";
					$con = ",";
				}
				if($this->isPropertySet("email", "K")){
					$Sql .= "$con email='" . $this->getProperty("email") . "'";
					$con = ",";
				}
				if($this->isPropertySet("first_name", "K")){
					$Sql .= "$con first_name='" . $this->getProperty("first_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("middle_name", "K")){
					$Sql .= "$con middle_name='" . $this->getProperty("middle_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("last_name", "K")){
					$Sql .= "$con last_name='" . $this->getProperty("last_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("phone", "K")){
					$Sql .= "$con phone='" . $this->getProperty("phone") . "'";
					$con = ",";
				}
				if($this->isPropertySet("designation", "K")){
					$Sql .= "$con designation='" . $this->getProperty("designation") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_type", "K")){
					$Sql .= "$con user_type='" . $this->getProperty("user_type") . "'";
					$con = ",";
				}
				if($this->isPropertySet("is_active", "K")){
					$Sql .= "$con is_active='" . $this->getProperty("is_active") . "'";
					
				}
				if($this->isPropertySet("gmc", "K")){
					$Sql .= "$con gmc='" . $this->getProperty("gmc") . "'";
					
				}if($this->isPropertySet("gmcadm", "K")){
					$Sql .= "$con gmcadm='" . $this->getProperty("gmcadm") . "'";
					
				}if($this->isPropertySet("gmcentry", "K")){
					$Sql .= "$con gmcentry='" . $this->getProperty("gmcentry") . "'";
					
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND user_cd=" . $this->getProperty("user_cd");
				break;
			case "D":
				$Sql = "Delete from mis_tbl_users 
						WHERE
							1=1";
				$Sql .= " AND user_cd=" . $this->getProperty("user_cd");
				break;
			default:
				break;
		}
		echo $Sql;
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to check the username already exists or not.
	* @author 
	* @Date Dec 05, 2007
	* @modified Dec 05, 2007 by 
	*/
	public function checkAdminUsername(){
		$Sql = "SELECT 
					username
				FROM
					mis_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("username", "V"))
			$Sql .= " AND username='" . $this->getProperty("username") . "'";
		if($this->isPropertySet("user_cd", "V"))
			$Sql .= " AND user_cd!=" . $this->getProperty("user_cd");
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to check the email address already exists or not.
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function checkAdminEmailAddress(){
		$Sql = "SELECT 
					user_cd,
					username,
					email,
					CONCAT(first_name,' ', middle_name , ' ',last_name) AS fullname
				FROM
					mis_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
		if($this->isPropertySet("user_cd", "V"))
			$Sql .= " AND user_cd!=" . $this->getProperty("user_cd");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to change the password
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function changePassword(){
		$Sql = "UPDATE mis_tbl_users SET
					passwd='" . $this->getProperty("passwd") . "' 
				WHERE 
					1=1 
					AND user_cd=" . $this->getProperty("user_cd") . " 
					AND username='" . $this->getProperty("username") . "'";
		return $this->dbQuery($Sql);
	}
	
	public function actMenuUser($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO mis_tbl_user_rights(
				        right_id,
						user_cd,
						menu_cd
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("right_id", "V") ? $this->getProperty("right_id") : 
					"";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("menu_cd", "V") ?  $this->getProperty("menu_cd") : 
				"NULL";
				
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_user_rights SET ";
				if($this->isPropertySet("user_cd", "K")){
					$Sql .= "user_cd='" . $this->getProperty("user_cd") . "'";
					$con = ",";
				}
				if($this->isPropertySet("menu_cd", "K")){
					$Sql .= "$con menu_cd='" . $this->getProperty("menu_cd") . "'";
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND right_id=" . $this->getProperty("right_id");
				break;
			case "D":
				$Sql = "Delete from mis_tbl_user_rights
						WHERE
							1=1";
				$Sql .= " AND menu_cd=" . $this->getProperty("menu_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	public function actCMSUser($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_cms_rights(
				        cms_right_id,
						user_cd,
						cms_id
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("cms_right_id", "V") ? $this->getProperty("cms_right_id") : 
					"";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cms_id", "V") ?  $this->getProperty("cms_id") : 
				"NULL";
				
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_cms_rights SET ";
				if($this->isPropertySet("user_cd", "K")){
					$Sql .= "user_cd='" . $this->getProperty("user_cd") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cms_id", "K")){
					$Sql .= "$con cms_id='" . $this->getProperty("cms_id") . "'";
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND cms_right_id=" . $this->getProperty("cms_right_id");
				break;
			case "D":
				$Sql = "Delete from rs_tbl_cms_rights
						WHERE
							1=1";
				$Sql .= " AND cms_id=" . $this->getProperty("cms_id");
				if($this->isPropertySet("user_cd", "K")){
					$Sql .= " AND user_cd=" . $this->getProperty("user_cd") ;
					
				}
				//echo $Sql;
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
}
?>