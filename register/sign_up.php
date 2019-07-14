<?php
session_start();
include_once "../classes/my_conn.php";

// get connection
$conn = new My_conn("mysql:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657");
$conn = $conn->gc();
	// redirect if user is already logged in
	if (isset($_SESSION['username'])) {
		header('Location:http://blog.agwconitsha.org/');
	}
	// sanitize vars
$first_name = filter_var(trim($_POST["first_name"]), FILTER_SANITIZE_STRING);
$last_name = filter_var(trim($_POST["last_name"]), FILTER_SANITIZE_STRING);
$email = $_POST["email"];
$password = empty($_POST["password"]) ? NULL : password_hash($_POST["password"], PASSWORD_BCRYPT);
$temp_username = $first_name.'_'.$last_name;
$confirm_id = mt_rand();

if (!empty($email)) {

$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

$message = "<!DOCTYPE html>
	<html>
	<head>
		<title> Confirm From AGWCOnitsha Blog</title>
	</head>
	<body style='background-color:#f1f1f1;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#757575;font-family:lato, verdana, tahoma, sans-serif;' >

		<main style='width:90%;margin-top:1%;margin-bottom:1%;margin-right:auto;margin-left:auto;' >

			<div style='display: flex;flex-flow: row nowrap;justify-content: space-around;'>

			<h1 style='font-family:raleway, sans-serif;color:#999;' >AGWC Onitsha</h1>

			<img src='http://agwconitsha.org/logo.png' style='height:11%;width:17%;max-height:100%;max-width:100%;' >
			</div>

			<section style='background-color:#f9f9f9;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;padding-top:2%;padding-bottom:2%;padding-right:2%;padding-left:2%;' >

				<h3>Hi $first_name $last_name,</h3>
				<p id=welcome style='margin-top:-15px;margin-bottom:35px;color:#999;' >welcome to AGWC Blog</p>

				<p>Please click on the button below to confirm your email and complete the sign up to AGWC Onitsha</p> <br>

				<span style='background-color:#337ab7;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-radius:3px;padding-top:1%;padding-bottom:1%;padding-right:1%;padding-left:1%;font-size:90%;' >

				<a href='http://agwconitsha.org/blog/register/confirm.php?id=$confirm_id&email=$email' style='color:#fff;text-decoration:none;' >CONFIRM </a></span> <br>
				<p>72A New Market Road Onitsha Anambra Nigeria </p>

			</section>
		</main>
	</body>
	</html>";

	$to = $email;
	$subject = "Confirm AGWC Onitsha sign up";
	$header = 'MIME-Version: 1.0' . "\r\n". 'Content-type: text/html; charset=utf8' . "\r\n" . 'From: ' . "support@agwconitsha.org";


		// Recursive function to check if username is already in use.
		// Returns only unique username
		function username_check($name, $c){
			$username_in_use = $c->prepare("SELECT COUNT(*) FROM users WHERE username=?");
			$username_in_use->execute([$name]);

			if ($username_in_use->fetchColumn() == "1") {
					$name = username_check($name, $c).mt_rand(2, 90);
			}
					else return $name;
		}
			
			//test if email is already in use, if true, return error text
		$email_in_use = $conn->prepare("SELECT COUNT(*) FROM users WHERE email=?");
		$email_in_use->execute([$email]);

		if ($email_in_use->fetchColumn() == "1") {
			echo "<span style='color: red; padding-left:5%;' id='errorText'> sorry. email in use by another user </span>";
			exit();
		}
		else {
			$username = username_check($temp_username, $conn);
			if (!is_null($password)) {
				// if all params are set and valid and all is clear, insert data into database
				$prep = $conn->prepare("INSERT INTO confirm VALUES(?, ?, ?, ?, ?, ?, ?, ?)");

				$params = array($first_name, $last_name, $email, $password, $username, date("Y-m-d H:i"), date("Y-m-d H:i"), $confirm_id);
				
				$prep->execute($params);
				mail($to, $subject, $message, $header);
			}
					exit();
			}
		}


	/*
	* to make new admin, update user row to admin, extend his user class to admin, overwrite his existing **index doc with admin template
	**/
?>