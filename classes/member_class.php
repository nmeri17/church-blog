<?php

class Member {
	/*
	* @Member class: This is the base account type and every other account type should inherit from this
	* @author: Al Nmeri
	* ==== @constructor ====
	* @param: a unique username to init user for db indexing.
	* @returns: attaches user info to properties
	**/
	public $name;
	public $pagename;
	public $can_comment;
	public $profile_pic;
	public $username;
	public $bio;
	public $account_type;

	public function __construct($name) {
		$this->name = str_replace('_', ' ', ucwords(strtolower($name)));
		$this->pagename = "http://blog.agwconitsha.org/". strtolower(str_replace('_', '.', $name)) . '/';
		$this->can_comment = true;
		$this->profile_pic = "http://blog.agwconitsha.org/user.png";
		$this->username = $name;
		$this->bio = "";
		$this->account_type = 'member';
		}

	/*
	* @param: PDO conn object
	* @returns: returns true on successful insert of all user properties into db
	**/
	public function activate (PDO $conn) {

	$active = $conn->prepare("INSERT INTO user_info (name, username, pagename, can_comment, profile_pic, bio, account_type) VALUES (:name, :username, :pagename, :can_comment, :profile_pic, :bio, :account_type)");
	
	$active->execute((array) $this);
	return true;
	}

	/*
	* @description: For settings page. To fetch all alterable user properties
	* @param: PDO conn object
	* @param: joiner: the variable that join the tables
	* @returns: returns an object containing current user properties for sitewide usage
	**/

	public static function fetch_me (PDO $conn, $joiner) {
		
		$prep = $conn->prepare("SELECT users.username, users.email, users.password, user_info.name, user_info.profile_pic, user_info.bio, user_info.pagename FROM users INNER JOIN user_info ON users.username=user_info.username WHERE users.username=?"); //ON is the joiner between the tables like WHERE is for values

		$prep->execute([filter_var($joiner, FILTER_SANITIZE_STRING)]);

		return $prep->fetch(PDO::FETCH_OBJ);
	}

	/*
	* @param: $old_pass: old password
	* @param: $new_pass: new password;
	* @param: $conn: PDO connection
	* @description: changes user password
	* @returns: false on wrong password or failure
	**/
	public static function change_password($old_pass, $new_pass, $conn) {
			$new_pass = password_hash($new_pass, PASSWORD_BCRYPT);
			$sess = $_SESSION['username'];
			
			if (password_verify($old_pass, SELF::fetch_me($conn, $sess)->password)) {
			$change_pass_query = $conn->prepare("UPDATE users SET password=? WHERE username=?")->execute([$new_pass, $sess]);
		}
		else return false;
	}
	
	/*
	* @param: $pass: user password
	* @param: $new_email: $email to change to
	* @param: $conn: PDO connection
	* @description: changes user email
	* @returns: false on wrong password or failure
	**/
	public static function change_email($pass, $new_email, $conn) {
		$sess = $_SESSION['username'];
		$new_email = filter_var($new_email, FILTER_SANITIZE_EMAIL);

		if (password_verify($pass, SELF::fetch_me($conn, $sess)->password)) {
			//test if email is already in use by someone else

			$email_in_use = $conn->prepare("SELECT COUNT(*) FROM users WHERE email=?");
			$email_in_use->execute([$new_email]);

			if ($email_in_use->fetchColumn() == "1") {
				return "<span style='color: red; padding-left:5%;' id='errorText'> sorry. email in use by another user </span>";
			}
			//else update db with new email

			else {
				$change_email_query = $conn->prepare("UPDATE users SET email=? WHERE username= ?")->execute([$new_email, $sess]);
		}
	}
		else echo "Changes not saved: wrong password.";
	}
	
	/*
	* @param: $email: user email
	* @param: $conn: PDO connection
	* @description: replaces password in user row and sends mail containing new pass
	* @returns: On success, string confirming email sent.
	**/
	public static function reset_password($email, $conn) {
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		$to = $email;
		$subject = "AGWC Blog Password Reset";
		$header = 'MIME-Version: 1.0' . "\r\n". 'Content-type: text/html; charset=utf-8' . "\r\n" . 'From: ' . "support@agwconitsha.org";

		//fetch user first name for use in mail body
		$get_first_name = $conn->prepare("SELECT first_name FROM users WHERE email=?");
		$get_first_name->execute([$email]);

		while ($row = $get_first_name->fetch(PDO::FETCH_ASSOC)) {
			$first_name = $get_first_name['first_name'];
		}

		//new pass
		$possible_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYS1234567890abcdefghijklmnopqrstuvwxyz";
		$reset_pass = substr(str_shuffle(str_repeat($possible_chars, 5)), 1, 5);
		
		//message body
		$message = "<!DOCTYPE html>
	<html>
	<head>
		<title> Password Reset</title>
	</head>
	<body style='background-color:#f1f1f1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#757575;font-family:lato, sans-serif;' >

		<main style='width:90%;margin-top:1%;margin-bottom:1%;margin-right:auto;margin-left:auto;' >

			<div style='display: flex;flex-flow: row nowrap;justify-content: space-around;'>

			<h1 style='font-family:raleway, sans-serif;color:#999;' >AGWC Onitsha</h1> <img src='http://agwconitsha.org/logo.png' style='height:11%;width:17%;max-height:100%;max-width:100%;' >
			</div>

			<section style='background-color:#f9f9f9;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;padding-top:2%;padding-bottom:2%;padding-right:2%;padding-left:2%;' >
				<h3>Hi ". $first_name ."</h3>
				<p id=welcome style='margin-top:-15px;margin-bottom:35px;color:#999;' >You have requested a password reset and your new password is". $reset_pass. " </p>
				<p>Please click on the button below to return to your account</p> <br>
				<span style='background-color:#337ab7;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-radius:3px;padding-top:1%;padding-bottom:1%;padding-right:1%;padding-left:1%;font-size:90%;' ><a href='http://agwconitsha.org/blog/login/' style='color:#fff;text-decoration:none;' >BACK TO AG Worship Center </a></span> <br>
				<p>72A New Market Road Onitsha Anambra Nigeria </p>
			</section>
		</main>
	</body>
	</html>";

		mail($to, $subject, $message, $header);
		
		// update db with new pass
		$reset_pass_query = $conn->prepare("UPDATE users SET password=? WHERE email=?")->execute([password_hash($reset_pass, PASSWORD_BCRYPT), $email]);
	}
	
	/*
	* @param: valid PDO connection
	* @param: Session variable
	* @description: updates user's last login
	* @return: null
	**/
	public static function set_last_login($conn, $sess) {
		
		$conn->prepare("UPDATE users SET last_login=NOW() WHERE username=?")->execute([$sess]);
	}
	
	public static function bio($bio, $conn) {
		$sess = $_SESSION['username'];
		
		$update = $conn->prepare("UPDATE user_info SET bio=? WHERE username=?")->execute([htmlspecialchars($bio), $sess]);
	}
	
	/*
	* @function: A one time function to check if user has changed default display picture and updates db if so
	* @param: valid PDO connection
	**/
	public static function change_picture($conn){
		$sess = $_SESSION['username'];
		$my_vars = SELF::fetch_me($conn, $sess);

		// Check if user has previously uploaded profile picture
		if ($my_vars->profile_pic == "http://blog.agwconitsha.org/user.png") {
			$new_image_link = 'http://blog.agwconitsha.org/a/profile_images/'. $my_vars->username. '.png';

			$conn->prepare("UPDATE user_info SET profile_pic=? WHERE username='$my_vars->username'")->execute([$new_image_link]);
		}
	}

	/*@function: In case of upgrade, use overloading to add new features **/
	public function __set ($name, $method){
		return $this->name = $method;
	}
}

class Admin extends Member {
	function __construct($name) {
		parent::__construct($name);
		$this->can_delete_comment = true;
	}

	/*function ban($username) {
	foreach($all_users as $user => $value) {
	if ($value == $username) {
	$user->can_comment = false;
	}
	}
	}*/
}

?>