<?php
session_start();

	// if user is already signed in, redirect them to where they truly belong: the homepage!
	if (isset($_SESSION['username'])) {
		header('Location:http://blog.agwconitsha.org/');
	}
	else {

include_once "../classes/my_conn.php";
include_once "../classes/member_class.php";

	// get connection
	$conn = new My_conn("mysql:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657", array(PDO::ATTR_PERSISTENT => true));
	$conn = $conn->gc();
$error;

// validation function
function auth_user($email, $password, $connect){
	
	$query = $connect->prepare("SELECT * FROM users WHERE email=?");
	global $error;

	if ($query->execute([$email])) {
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			echo "we got to this point";
			if (password_verify($password, $row['password'])) {
				$_SESSION['username'] = $row['username'];
				return true;
			}
		}
	}
}
	
if (isset($_POST['email'], $_POST['password'])) {

// not SANItizing  password because I don't want nothing to do with SANI Abacha?
$user_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$user_password = $_POST['password'];

		if (auth_user($user_email, $user_password, $conn)) {

			// update last login of current user
			Member::set_last_login($conn, $_SESSION['username']);
		
			header('Location: http://blog.agwconitsha.org/');
		}
		$error = '<p style="color:#900;">*incorrect email or password</p>';
	}

}

?>

<!DOCTYPE html>
<html lang=en>
<head>
	<meta charset=utf-8>
	<style>
	* {
	margin: 0;
	padding: 0;
	text-decoration: none;
	box-sizing: border-box;
}

body {
	font-family: Lato, sans-serif;
	background-color: #f0f0f0;
	color: #666;
}

header {
	width: 100%;
	height: 98px;
	background-color: #1e4969;
	padding-top: 5px;
	color:  #fff;
}

header .logo {
	width: 5.4%;
	height: 78%;
	position: relative;
	margin-top: 3px;
	left: 2%;
	z-index: 9999999;
	max-width: 100%;
	max-height: 100%;
}

header h1 {
	position: relative;
	backface-visibility: hidden;
	z-index: 9999999;
	margin-left: 8%;
	margin-top: -3%;
	font-family: 'Raleway';
}

#hamburger {
	height: 60px;
	width: 60px;
	position: absolute;
	top: 5%;
	right: 2%;
	z-index: 9999999;
	padding: 6px;
	box-sizing: border-box;
	display: flex;
	flex-flow: row wrap;
	justify-content: space-between;
	cursor: pointer;
	overflow: hidden;
}

.lines {
	flex: 1 58%;
	height: 8px;
	background: #fff;
	margin-left: auto;
	margin-right: auto;
	border-radius: 2px;
	box-shadow: inset 0 0 4px #888;
	transition: all 0.2s ease-in-out;
}

#hamburger.open .lines:first-child {
	transform: rotate(-40deg);
	position: relative;
	top: 22.5px;
	transition: all 0.2s ease-in-out;	
}

#hamburger.open .lines:nth-child(2) {
	transform: rotate(50deg);
	transition: all 0.2s ease-in-out;
}

#hamburger.open .lines:last-child {
	display: none;
}

#hamburger.open nav ul {
	transform: translatex(0);
}

nav {
	width: 32%;
	height: 42.5px;
	position: absolute;
	right: 6%;
	top: 55px;
	font-weight: bold;
	box-sizing: border-box;
	text-transform: uppercase;
	font-size: 84%;
	z-index: 9999999;
	overflow: hidden;
}

nav ul {
	position: absolute;
	transform: translatex(540px);
	transition: all 0.3s ease-in-out;
}

nav a {
	color: #bbb;
}

nav li {
	list-style: none;
	display: table-cell;
	padding: 8px;
	height: 30px;
	color: #999;
	white-space: nowrap;
}

nav > ul > li:nth-child(4) a, nav ul li:hover a {
	color: #f1f1f1;
}

#blogMenu {
	position: relative;
	display: flex;
	flex-flow: row nowrap;
	justify-content: center;
	background: #fff;
	font-family: raleway;
	text-transform: uppercase;
	font-size: 75%;
	font-weight: bold;
	}

#blogMenu a {
	color: #333;
	}
	
#blogMenu div {
	padding: 2%;
	}
	
#blogMenu > div:nth-child(4), #blogMenu div:hover {
	background: #f7f7f7;
	}
	
#blogMenu form {
	position: absolute;
	right: 2.5%;
	height: 70%;
	width: 15.5%;
	margin-top: .8%;
	overflow: hidden;
	}
	
#blogMenu input {
	height: 100%;
	width: 100%;
	font-size: 100%;
	border: 1px solid #aaa;
	font-family: lato;
}

h2 {
	margin: 0 auto;
	width: 30%;
	padding: 2% 0;
	font-size: 190%;
}

#form-div {
	height: 300px;
	display: flex;
	flex-flow: row wrap;
	justify-content: space-between;
}

#form-div form {
	margin: 0 auto;
	width: 30%;
	padding-top: 2%;
	height: auto;
}

#form-div input {
	height: 40px;
	width: 90%;
	border-radius: 3px;
	border: 1px solid #888;
	font-size: 125%;
	background: #f7f7f7;
}

#form-div input:last-child {
	height: auto;
	width: auto;
	font-size: initial;
	border-radius: 10%;
	background: #5ca03d;
	padding: 2%;
	color: #f0f0f0;
	border: 0;
	cursor: pointer;
}

#form-div p {
	flex: 1 100%;
	padding-left: 35%;
}

#form-div p a {
	color: #de6059;
}

footer {
	height: 250px;
	background: #555;
	padding-top: 6%;
}

#quicklinks {
	display: flex;
	flex-flow: row wrap;
	justify-content: center;
}

#quicklinks a {
	color: #aaa;
	text-transform: uppercase;
	margin-right: 4%;
	font-size: 75%;
}

footer div:nth-child(2) {
	margin: 0 auto;
	width: 38%;
	height: 85px;
	padding-top: 3%;
	color: #888;
	font-size: 70%;
}

footer div:nth-child(2) img {
	height: 80%;
	max-width: 100%;
	opacity: .5;
	}

footer div:nth-child(3) {
	float: right;
	width: 15%;
	background: #116ba1;
	color: #ddd;
	padding: 1%;
	white-space: nowrap;
	margin-top: 1.8%;
	font-size: 85%;
}

footer div:nth-child(3) a {
	color: #fff;
}
	</style>
	<link href=https://fonts.googleapis.com/css?family=Lato rel=stylesheet type=text/css>
	<link href=https://fonts.googleapis.com/css?family=Raleway rel=stylesheet type=text/css>
	<link rel=stylesheet href=https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css>
	<link type="x-image/icon" rel="icon" href="../../favicon.ico">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<title> Sign In </title>
</head>

<body>
	<?php
	include "../header.php";
	?>


	<h2>sign in</h2>
	
	<div id=form-div>
	
	<?php if (isset($error)) echo $error; ?>
	
	<form method='POST' action=''>
	Email: <br> <input type='email' name='email' required > <br> <br>
	Password: <br> <input type='password' name='password' required /> <br> <br>
	<input type='submit' name='submit' value='sign in' />
	</form>
	

	<p> Dont have an account? <a href="../register/"> Sign up</a> in less than 10 seconds!</p>
	</div>
	
	<?php include '../footer.php';
	?>
</body>
</html>