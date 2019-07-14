<?php
include '../../classes/template_engine.php';

	if (isset($article_title, $article_image, $article_body)) {
		new_post ("blog_posts", $conn);

		// upload banner image
		move_uploaded_file($_FILES['banner_image']['tmp_name'], $article_image);
	}

		/**=== SIDEBAR DATA ==== */
$announcements = htmlspecialchars($_POST['announcements']);
$book = htmlspecialchars($_POST['book_of_the_month']);
		
/*since the datas for the sidebar are unrelated (not row dependent) but going to the same table and we can't * guarantee all fields will always be filled, we have to test what fields were filled and enter their data * * thus:*/

$posts  = ['announcements', 'book_of_the_month'];
$value = [];
$sidebar   = 'INSERT INTO sidebar ("';
foreach($posts as $post) {
    if(!empty($_POST[$post])) {
        $sidebar    .= $post. ', ';
        $value[] = $_POST[$post];
	}
}
	$sidebar .= '") VALUES ("';    
	$sidebar .= implode(', ', $value); 
	$sidebar .= '");';
       		
	$sidebar = $conn->query($sidebar)->execute();
		
	if (!empty($book_image)) {
		move_uploaded_file($_FILES['book_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT']. "/book-image.png");
	}

/**========= SERMONS SECTION ====== */

// Check if preacher is a registered member and replace with URL to his page
$preach = $conn->query("SELECT pagename FROM user_info WHERE name LIKE ?");
$preach->execute(['%'. htmlspecialchars($_POST['preacher']). '%']);
$preach = $preach->fetch(PDO::FETCH_ASSOC);
			if (!empty($preach['pagename'])) {		
				$preacher = "<a href='". $preach['pagename'][0]. "'";
			}
			else $preacher = htmlspecialchars($_POST['preacher']);

$sermon_title = htmlspecialchars($_POST['sermon_title']);
$sermon_body = htmlspecialchars($_POST['sermon_body']);
	
if (isset($sermon_title, $preacher, $sermon_body)) {
	$sermon_url = str_replace(" ", "_", $sermon_title);

	$sermon = $conn->prepare("INSERT INTO sermons_table (sermon_title, sermon_url, sermon_body, preacher) VALUES (?, ?, ?, ?)");
	$sermon_vars = array($sermon_title, $sermon_url, $sermon_body, $preacher);
	$sermon->execute($sermon_vars);
}

/**======= DELETE SERMON =========== */
		$delete_sermon = $conn->prepare("DELETE * FROM sermons_table WHERE sermon_name=?")->execute([htmlspecialchars($_POST['delete_sermon'])]);

/**======== HOME IMAGES ===========- */
		if (isset($_FILES['banner_image'])) {
			$image_name = $_FILES['banner_image']['name'];
			if ($_FILES['banner_image']['error'] > 0) {
				$_SESSION['error'] = "An unexpected error occurred.";
				session_set_cookie_params(10);
				return;
			}
			else {
				// If no error is returned, replace the image on the homepage 
					rename(move_uploaded_file($_FILES['banner_image']['tmp_name'], "../../" . $_SERVER['DOCUMENT_ROOT'] . "/"), "img-" . $_POST['number'] . ".jpg");
				}
		}

/**========== NEW ARTICLES BY USERS =========== */
$new_article = "SELECT * FROM user_articles ";
	if (isset($_POST['value'])) {

		// Get last login time
		$last_login = $conn->prepare("SELECT last_login FROM users WHERE username=?");
		$last_login->execute([$_SESSION['username']]);

		$last_login = $last_login->fetch(PDO::FETCH_ASSOC);

		// What order should the posts be served in
		switch($_POST['value']) {
			case 'oldest': $new_article .= "ORDER BY DESC";
			break;

			case 'newest': $new_article .= "WHERE time_posted > CAST('" . $last_login['last_login'] . "' AS DATETIME)";
			break;

			case 'all': $new_article = $new_article;
			break;

			default: $new_article .= "WHERE time_posted > CAST('" . $last_login['last_login'] . "' AS DATETIME)";
		}
	}
?>