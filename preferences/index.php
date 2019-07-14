<?php
session_start();
include "../classes/my_conn.php";
include "../classes/member_class.php";
include "../classes/template_engine.php";

// Get connection
$conn = new My_conn("mysql:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657", array(PDO::ATTR_PERSISTENT => true));
$conn = $conn->gc();


// If this is not a registered user, redirect back to homepage
if(!isset($_SESSION['username'])) {
		header('Location:http://blog.agwconitsha.org/login/');
}
else {
//parse page and display
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$pass = $_POST['pass'];
		$email = $_POST['email'];
		$old_pass = $_POST['old_pass'];
		$new_pass = $_POST['new_pass'];
		$bio = $_POST['bio'];
		$pic = $_FILES['profile_pic'];

		// If submit has been sent and any other vars have been sent, process and update
		if (!empty($pass) && !empty($email)) Member::change_email($pass, $email, $conn);

		if (!empty($old_pass) && !empty($new_pass)) Member::change_password($old_pass, $new_pass, $conn);

		if (!empty($pic)) {
			$err = ' ';
			$formats = array('jpg', 'jpeg', 'png');
	
			Member::change_picture($conn);
	
			if ($pic['size'] > 2048000) {
				$err .= "Image size is above 2mb";
			}
			else if (!in_array(end((explode('.', strtolower($pic['name'])))), $formats)) {
				$err .= "Image type not supported";
			}
			else {
				move_uploaded_file($pic['tmp_name'], '/home/agwconit/public_html/blog/a/profile_images/'. Member::fetch_me($conn, $_SESSION['username'])->username. '.png');
			}
			// echo <div id error-text>$err</div>;
		}
		if (!empty($bio)) Member::bio($bio, $conn);
}

	/** ========== echo "<p id='success'>Changes saved.</p>"; ======== */
$myself = (array) Member::fetch_me($conn, $_SESSION['username']);

// Initialize header and footer
ob_start();
include '../header.php';
$header = ob_get_contents();
ob_end_clean();

ob_start();
include '../footer.php';
$footer = ob_get_contents();

ob_end_clean();

$myself['header'] = $header;
$myself['footer'] = $footer;

/**== PARSE VIEW ==**/
$parse = new Templating_Engine($myself, "http://blog.agwconitsha.org/preferences/settings.html");

echo $parse->final_page;
}
?>