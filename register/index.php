<?php

	if (isset($_SESSION['username'])) {
		header('Location:http://blog.agwconitsha.org/');
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
	font-family: 'Lato', sans-serif;
	background-color: #f0f0f0;
	color: #666;
	overflow-x: hidden;
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
	height: 77%;
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
	
#blogMenu > div:first-child, #blogMenu div:hover {
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
	
#blogMenu form i {
	background: #f0f0f0;
	color: #888;
	padding: 3%;
	position: absolute;
	left: 76.7%;
	top: 2%;
}

#progress {
	height: 100px;
	font-size: 300%;
	margin-top: 2%;
	opacity: .65;
	display: flex;
	flex-flow: row nowrap;
	justify-content: space-between;
	position: relative;
	overflow: hidden;
	transition: all .5s ease-in-out;
}

#progress.fixed {
	margin-top: 0;
	position: fixed;
	top: 0;
	width: 100%;
	z-index: 99999999999;
	transition: all .5s ease-in-out;
}

#progress span {
	flex: 1 20%;
	color: #99d;
	position: relative;
	transition: all 1s ease-in-out;
	background: rgba(0, 0, 0, .1);
	padding-left: 30%;
	text-shadow: 0 -1px 1px #666;
}

#progress span:first-child {
	margin-right: 5%;
	text-shadow: 0 -1px 1px #333;
}

#progress span:last-child {
	color: #ccf;
}

#progress span:first-child::after {
	content: '';
	position: absolute;
	left: 100%;
	border-left: 50px solid rgba(0, 0, 0, .1);
	border-top: 60px solid transparent;
	border-bottom: 55px solid transparent;
	z-index: 999;
}

#progress span:last-child::before {
	content: '';
	position: absolute;
	top: -30%;
	left: -5%;
	border-left: 80px solid #f0f0f0;
	border-top: 85px solid transparent;
	border-bottom:80px solid transparent;
	z-index: 34;
}

#form-div {
	height: auto;
	width: 2300px;
	display: flex;
	flex-flow: row nowrap;
	padding-bottom: 3%;
}

#form-div form {
	position: relative;
	left: 20%;
	width: 28%;
	padding-top: 2%;
	height: auto;
	transition: all 1.2s ease-in-out;
}

#form-div form input {
	height: 40px;
	width: 90%;
	border-radius: 3px;
	border: 1px solid #888;
	font-size: 125%;
	background: #f7f7f7;
	z-index: 900;
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

#confirm p {
	margin: 9% 0 0 55%;
	margin-right: 30%;
	font-size: 200%;
	width: 40%;
	text-align: center;
	color: #777;
	transition: all 1.2s ease-in-out;
}

#confirm p a {
	color: #f1f1f1;
}

#confirm p span:last-child {
	background: #286090;
	border-radius: 3px;
	font-size: 60%;
	padding: 1%;
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
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway:400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link type="x-image/icon" rel="icon" href="../../favicon.ico">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<title> Register </title>
</head>

<body>
	<?php
	include "../header.php";
	?>

	<div id=wrapper>
	<div id=progress> <span> <i class="fa fa-user-plus"></i></span> <span style='font-weight:bold;'> @</span></div>
	
	<div id=form-div>
	<form method="POST" action="">
	First Name: <br> <input type="text" name=first_name required pattern="[A-Za-z]{2,}" /> <br> <br>
	Last Name: <br> <input type="text" name=last_name required pattern="[A-Za-z]{2,}" /> <br> <br>
	Email: <span id=emailReport></span> <br> <input type="email" name='email' id=email required /> <br> <br>
	Password: <br> <input type="password" name=password required pattern=".{6,}" title="Password must be six or more characters" /> <br> <br>
	Confirm password: <br> <input type=password name=password required /> <br> <br>
	<input type=submit value='sign up' />
	</form>
	
	<div id=confirm> <p> Congratulations on coming this far! You are just one more step from completing your <span style="color: #cc1030;">FREE</span> sign
	up process. Click on the button below to confirm your email address <br> <br> <span> <a href=''>Open Email <i class="fa fa-paper-plane"></i></a> </span></p> </div>
	</div>
	
	</div>
	<script>

	window.addEventListener ("scroll", function () {
	var currentDistance = (document.body.scrollTop);
	if (currentDistance > "125") {
	$('#progress').addClass("fixed");
	}
	else 
	$('#progress').removeClass("fixed");
	});

	$("#email").change(function(){
	$.post('sign_up.php', $("#form-div form").serialize()).done(function(c) {
	//console.log(c);
	if (c.indexOf('errorText') != -1) {
		$('#emailReport').html(c);
	}
	});
	});
	
			
	$('#form-div form').submit(function(e){
		e.preventDefault();
		var allFields = e.target.querySelectorAll("input"), email = allFields[2].value, data = $(this).serialize();
		
		function validate () {
			if (allFields[3].value !== allFields[4].value) {
				alert ("Passwords do not match");
				return false;
			} else {
				$('#progress span:last-child').css('color', '#99d');
				$('#form-div form').css('left', '-70%');
				$('#confirm p').css('margin-left', '-12%');
				}
			}
			validate();
				if (validate() != false) {
				$.post("sign_up.php", $("#form-div form").serialize()).done(function(data){console.log(data);
				});
				
				if (email.match(/gmail/gi)) {
				$('#confirm a').attr('href', encodeURI('https://mail.google.com/mail/u/0/#search/in:Anywhere' + ' subject:"Confirm AGWC Onitsha sign up"' + ' from:support@agwconitsha.org'));
				}
				else if (email.match(/yahoo/gi)) {
				$('#confirm a').attr('href', encodeURI('https://in.search.yahoo.com/search?p=' + 'support@agwconitsha.org' +'+Confirm AGWC Onitsha sign up' +
				 '&fr=yfp-t-101'));
				}
				else {
				$('#confirm a').attr('href', email.split('@')[1]);
				}
			}

		});
	</script>
	
	<?php include '../footer.php';
	?>
</body>
</html>