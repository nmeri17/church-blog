<?php
session_start();

include "../../classes/my_conn.php";
include "../../classes/member_class.php";
include "../../classes/template_engine.php";

// Get connection
$conn = new My_conn("mysql:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657", array(PDO::ATTR_PERSISTENT => true));
$conn = $conn->gc();

// Fetch current user's data for use when needed
$deets = Member::fetch_me($conn, $_SESSION['username']);

// Grab all post's details
$a = $conn->prepare("SELECT * FROM blog_posts WHERE article_url=?");
$a->execute([$_GET['post_url']]);
$curr_post = $a->fetch(PDO::FETCH_ASSOC);
var_dump($curr_post);

if (!empty($curr_post)) {
$curr_post['article_author'] = "<a href='". $curr_post['article_author']. "'>". $deets->name. "</a>";

function isAdmin ($connect) {
	$data_sql = $connect->prepare("SELECT account_type FROM user_info WHERE username=?");
	$data_sql->execute([$_SESSION['username']]);
	$data_sql = $data_sql->fetch(PDO::FETCH_ASSOC);
	return $data_sql['account_type'] == "administrator";
}

//get current post id
$current_id = $conn->prepare("SELECT id FROM blog_posts WHERE article_url=?");
$current_id->execute([$curr_post['article_url']]);

while ($row = $current_id->fetch(PDO::FETCH_ASSOC)) {
	$curr = $row['id'];
}
	
$next_prev = $conn->prepare("SELECT article_url FROM blog_posts WHERE id=?");
$next_prev->setFetchMode(PDO::FETCH_ASSOC);

// Get next post button
$next_prev->execute([$curr + 1]);
$next = $next_prev->fetch();
$curr_post['next'] = $next['article_url'];

// get previous post button
$next_prev->execute([$curr - 1]);
$prev = $next_prev->fetch();
$curr_post['prev'] = $prev['article_url'];


// Get categories
$cat_str = "";
$categories = preg_match("/(\w){1},|\s/i", $curr_post['categories'], $categories);

foreach($categories as $category){
	$cat_str .= "<a href='../../categories?cat=$category'> ". $category. "</a>";
}

// Variable to store all comments
$comments_str = "";

// Pull all comments pertaining to current post
$all_comments = $conn->prepare("SELECT * FROM comments_table WHERE parent_post=?");
$all_comments->execute([$curr_post['article_url']]);
$all_comments->setFetchMode(PDO::FETCH_ASSOC);

$all_comments_arr = $all_comments->fetchAll();

// Add each comment and its info to the comments string
foreach($all_comments_arr as $each_comment) {

	// Comment details are contained in $each_comment; but we also need info pertaining to comment author
	$comment_author_vars = Member::fetch_me($conn, $each_comment['author_username']);

	// Then merge both the class returned by fetch_me and the each_comment array
	$merge = array_merge((array)$each_comment, (array)$comment_author_vars);

	$comment_parse = new Templating_Engine($merge, '../view/each_comment.html');
	$comments_str .= $comment_parse->final_page;
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

$curr_post['header'] = $header;
$curr_post['footer'] = $footer;


// Check if its a registered user
if (isset($_SESSION['username'])) {

	$curr_post['new_comment'] = "<div id='comment-image-holder'> <img src='". $deets->profile_pic. "' alt=''> </div>";

	$curr_post['new_comment'] .= "<form action='' method='POST'>
				<textarea name='new_comment' cols=70 rows=7 placeholder='Your awesome comment goes here'></textarea>
				<input type=submit value=comment>

				<!--=== LOADING ANIMATION ==== --->
		<div id='floatingCirclesG' class='hide-anim'>
	<div class='f_circleG' id='frotateG_01'></div>
	<div class='f_circleG' id='frotateG_02'></div>
	<div class='f_circleG' id='frotateG_03'></div>
	<div class='f_circleG' id='frotateG_04'></div>
	<div class='f_circleG' id='frotateG_05'></div>
	<div class='f_circleG' id='frotateG_06'></div>
	<div class='f_circleG' id='frotateG_07'></div>
	<div class='f_circleG' id='frotateG_08'></div>
</div>
			</form>

			<script src='comment.js'></script>";

	if (isAdmin($conn)) {
		$curr_post['admin_controls'] = "<div id=controls> <span> <a href='../../edit?article_title={{article_url}}'> Edit </a> </span> <span> <a href='../../delete?article_title={{article_url}}'> Delete </a> </span></div>";
	}
}
else {
	$curr_post['new_comment'] = "<p style='color: #aaa; text-align:center; margin-top:4%;'> You must be <a href='../../login/' style='color:#333;'>logged in </a> to post a comment </p>";
}

	$curr_post['categories'] = $cat_str;

	$curr_post['comments_count'] = count($all_comments_arr). " Responses";

	$curr_post['all_comments'] = $comments_str;

/**== PARSE VIEW ==**/
$parse = new Templating_Engine($curr_post, "../view/blog_template.html");

echo $parse->final_page;
}

?>