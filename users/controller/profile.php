<?php
session_start();

include "../../classes/my_conn.php";
include "../../classes/member_class.php";
include "../../classes/template_engine.php";

// Get connection
$conn = new My_conn("mysql:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657", array(PDO::ATTR_PERSISTENT => true));
$conn = $conn->gc();

/* Get datas for parsing admin data and welcome text for new user.
* This function returns an assoc array containing concerned variables.
*/
 function datas ($connect) {
	$data_sql = $connect->prepare("SELECT users.sign_up_date, users.last_login, user_info.account_type FROM users INNER JOIN user_info ON users.username=user_info.username WHERE users.username=?");
	$data_sql->execute([htmlspecialchars($_GET['username'])]);

		return $data_sql->fetch(PDO::FETCH_ASSOC);
}
$data = datas($conn);

/* Get user info for page usage. Above method is predefined in Member class for easy access to user vars
* Returns an assoc array with user properties as keys
*/
$owner = (array) Member::fetch_me($conn, $_GET['username']);

// Manipulate some individual vars as desired and add to array $owner
$owner['bio'] = htmlspecialchars_decode($owner['bio']);
$owner['first_name'] = explode(' ', $owner['name'])[0];
$owner['title'] = ucwords($owner['name']);

/* ==== MAIN CONTROLS ====
* Prepare variables corresponding to placeholders in 'view' and assign them concerned markup
*/

// Prepare query to fetch all user articles
$inbox = "";

$member_articles = $conn->query("SELECT * FROM user_articles");
$member_articles->execute();
$member_articles->setFetchMode(PDO::FETCH_ASSOC);

	while ($each_article = $member_articles->fetch()) {

		// Add link for push script to work with
		$each_article['push'] = $each_article['article_url'];

		// Parse the view for each article found and add to the inbox key
		$show_article = new Templating_Engine((array)$each_article, '../view/admin_each_article.html');
		$inbox .= $show_article->final_page;

		/** NOTE: This part has to be preprocessed separately before adding to the array since each article * * is unique and has it's own variables. While the "owner" array reads blanket keys (like 'inbox'), it * cannot distinguish one new article and its varaibles from another. So we do the distinction here in * this mini controller and pass the processed result to the "owner" array.
		*/
	}


// Initialize header and footer
ob_start();
include '../../header.php';
$header = ob_get_contents();
ob_end_clean();

ob_start();

include '../../footer.php';
$footer = ob_get_contents();

ob_end_clean();

$owner['header'] = $header;
$owner['footer'] = $footer;

	//load member stylesheet
	$owner['required_css'] = "http://blog.agwconitsha.org/users/controller/member.css";

//check if its a registered user
if (isset($_SESSION['username'])) {

	//Data to be displayed to page owner only
	if(strtolower($_SESSION['username']) == strtolower($_GET['username'])) {
		
		include "make_new_post.php";

		// test whether this is user's first ever login
			if ($data['sign_up_date'] == $data['last_login']) {
				echo '<p style="background: black; color: #f0f0f0;">Your profile is ready. Click on preferences below to update your info so your friends can find you.</p>';
			}

		// check if page owner is admin
		if ($data['account_type'] == "administrator") {
			$owner['admin_menu'] = "<ul>

			<li> <a href='../../a/comments?u={{username}}'><i class='fa fa-comments'></i> view my comments </a></li>

			<li> <a href='../../a/mentions?u={{username}}'> <span style='font-weight: bold;'>@ </span>my mentions </a> </li>

			<li> <a href='../../preferences/'><i class='fa fa-cog'></i> account settings </a> </li>

			<li> <a href='javascript:mA();'> <i class='fa fa-music' aria-hidden='true'></i> mute score </a> </li>

			</ul>

			<!--
			<script>
			function mA() {
				$('audio').pause();
			}
			</script>
			<audio autoplay=true loop style='visibility: hidden'>
  			<source src='/users/view/score.ogg' type='audio/ogg'>
			</audio>
			
			-->";

			$owner['required_css'] = "http://blog.agwconitsha.org/users/controller/admin.css";

			$owner['inbox'] = $inbox;

			// We are forced to also parse the markup since the "inbox" placeholder is nested in it
			$admin_mark = new Templating_Engine((array)$each_article, $_SERVER['DOCUMENT_ROOT']. '/users/view/admin_engine_markup.html');
			$owner['admin_markup'] = $admin_mark->final_page;
		}

		else {

			// Not admin. text area for new post
			$owner['new_blog_post'] = file_get_contents($_SERVER['DOCUMENT_ROOT']. "/users/view/member_post_markup.html");
			
			//user menu
			$owner['my_menu'] = "<ul>

			<li> <a href='../a/comments?u={{username}}'><i class='fa fa-comments'></i> view my comments </a></li>

			<li> <a href='../a/mentions?u={{username}}'> <span style='font-weight: bold;'>@ </span>my mentions </a> </li>

			<li> <a href='../preferences/'><i class='fa fa-cog'></i> account settings </a> </li>
			</ul>";
		}
	}
	elseif ($_SESSION['username'] != $_GET['username']) {
		$owner['guest_menu'] = "<ul>

			<li> <a href='../a/comments?u={{username}}'><i class='fa fa-comments'></i> view {{first_name}}'s comments </a></li>

			<li> <a href='../a/published/?author={{username}}'> <i class='fa fa-file-text'></i> {{first_name}}'s published posts </a> </li>

		</ul>";
		}
}

elseif (!isset($_SESSION['username'])) {

	// At this person has nothing to do with this page. Default page markup
	$owner['guest_menu'] = "<ul>

			<li> <a href='../a/comments?u={{username}}'><i class='fa fa-comments'></i> view {{first_name}}'s comments </a></li>

			<li> <a href='../a/published/?author={{username}}'> <i class='fa fa-file-text'></i> {{first_name}}'s published posts </a> </li>

		</ul>";

	}


/**== PARSE VIEW ==**/
$parse = new Templating_Engine($owner, $_SERVER['DOCUMENT_ROOT']. '/users/view/member_template_file.html');

echo $parse->final_page;

	// If user is admin, include admin engine
	if ($data['account_type'] == "administrator") {
		require 'admin_engine.php';
	}
?>