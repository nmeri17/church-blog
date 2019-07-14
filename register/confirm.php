<?php

include "../classes/member_class.php";
include "../classes/my_conn.php";

// get connection
$conn = new My_conn("mysql:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657");
$conn = $conn->gc();

// fetch data from confirm table for insertion into the main table
$select_all = $conn->prepare("SELECT first_name, last_name, email, password, username, sign_up_date, last_login FROM confirm WHERE confirm_id=? AND email=?");

$arr = array(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT), filter_var($_GET['email'], FILTER_SANITIZE_EMAIL));

$select_all->execute($arr);
$row = $select_all->fetch(PDO::FETCH_BOTH);

// prepare insertion string
$verify = "INSERT INTO users(first_name, last_name, email, password, username, sign_up_date, last_login) VALUES (";
for($i = 0;$i<count($row)/2; $i++) { // dividing by two since fetch_both will return a first half numeric array
$verify .= "'". $row[$i] ."', ";
}
$verify .= ")";

// escape extra commas
$verify = substr($verify, 0, -3) . substr($verify, -1);
if ($conn->query($verify)) {

	// init user object for db activation
	$new_user = new Member($row['username']);

	if ($new_user->activate($conn)) {
		session_start();
		// set session name for usage on site
		$_SESSION['username'] = $row['username'];
		// redirect to blog landing page
		header("Location: http://blog.agwconitsha.org");
		exit();
	}
}
else echo "An error occurred";

?>