<?php

/**====== NEW BLOG POST ==== */


// Fetch current user's pagename for use when needed.
function getPagename ($connect) {
	$pagename = $connect->prepare("SELECT pagename FROM user_info WHERE username=?");
	$pagename->execute([htmlspecialchars($_SESSION['username'])]);
	$pagename = $pagename->fetch(PDO::FETCH_ASSOC);
	return $pagename['pagename'];
}


function authenticate_author ($get, $post) {

	if ($get != $post) {
		throw new Exception("Unable to authenticate user", 1);
	}
	return $post;
}

	// Ensure that current author corresponds with page owner. Though we might not need it but just in case
try {
	$article_author = authenticate_author(getPagename($conn), $deets->pagename);
}
catch (Exception $e) {
	echo $e->getMessage();
	die();
}

// Format post url and filter off irrelevancies
function manipulate ($article_title, $conn) {
			$temp_link = explode(" ", $article_title);
			$article_link = array();

			// Remove words containing words less than 3 letters
			foreach ($temp_link as $word) {
			 	$article_link[] = (strlen($temp_link[$word]) > 2) ? $temp_link[$word] : NULL;
			 }
			$temp_link = date('Y/m') . "/" . implode("-", $article_link);

			// Test if another article already has the same URL
			$test = $conn->query("SELECT * FROM blog_posts WHERE article_url='$temp_link'")->fetchAll(PDO::FETCH_NUM);
			if (count($test) > 0) {
				return $temp_link. "?unique=". mt_rand(2,50);
			}
		}

	$article_title = htmlspecialchars($_POST['article_title']);

	$article_image = $_SERVER['DOCUMENT_ROOT']. "/a/blog_post_banners/$article_url.jpg";
	$article_body = htmlspecialchars($_POST['article_body']);
	$categories = filter_var($_POST['categories'], FILTER_SANITIZE_STRING);
	$article_url = manipulate($article_title, $conn);
	$date = date("l d F, Y");

	// update db with posts info
	function new_post ($table_name, $conn) {
	$blog_post_vars = array($article_title, $article_author, $article_body, $article_url, $article_image, $categories, $date);
	
	$sql = "INSERT INTO ". $table_name. " (article_title, article_author, article_body, article_url, banner_image, categories, date) VALUES(?, ?, ?, ?, ?, ?, ?)";

	$update = $conn->prepare($sql);
	$update->execute($blog_post_vars);
}
?>