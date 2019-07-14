<?php
session_start();
include "../../classes/my_conn.php";
include "../../classes/member_class.php";
include "../../classes/template_engine.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
// Get connection
$conn = new My_conn("mysql:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657", array(PDO::ATTR_PERSISTENT => true));
$conn = $conn->gc();

$comment_author_vars = Member::fetch_me($conn, $_SESSION['username']);

$comment_author = "<a href='". $comment_author_vars->pagename. "'> ". $comment_author_vars->name. "</a>";
$author_username = $_SESSION['username'];
$time = date("g:i a");
$parent_post = htmlspecialchars($_POST['parent_post'], ENT_COMPAT);
$comment_body = htmlspecialchars(trim($_POST['new_comment']), ENT_COMPAT);

if (isset($_POST['new_comment'])) {
// send comment and related info to db using named placeholders
	$init = $conn->prepare("INSERT INTO comments_table (parent_post, comment_author, comment_body, time, author_username) VALUES (:parent_post, :comment_author, :comment_body, :time, :author_username)");

	$comment_arr = array('parent_post' => $parent_post, 'comment_author' => $comment_author, 'comment_body' => $comment_body, 'time' => $time, 'author_username' => $author_username);
			
	if ($init->execute($comment_arr)) {

	$comment_author_vars->pagename = $comment_author;
	// Then merge both the class returned by fetch_me and the each_comment array
	$merge = array_merge((array)$comment_arr, (array)$comment_author_vars);

	$comment_parse = new Templating_Engine($merge, 'http://blog.agwconitsha.org/posts/view/each_comment.html');
	$return_comment = $comment_parse->final_page;
	}
}
echo $return_comment;
}
?>