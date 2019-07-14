<?php

include '../../classes/my_conn.php';
/** This script takes one of the posts made by users in the pending table and transfers them to the permanent * post so they can be displayed on the front page.
*/

// Get connection
$conn = new My_conn("mysql:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657");
$conn = $conn->gc();

// Grab posts from pending db
$push = $conn->prepare("SELECT * FROM user_articles WHERE article_url=?");
$push->execute([$_POST['push']]);
$push = $push->fetch(PDO::FETCH_NUM);

$sql = "INSERT INTO blog_posts (article_title, article_author, article_body, article_url, banner_image, categories, date) VALUES(?, ?, ?, ?, ?, ?, ?)";

// Insert into perm db
$insert = $conn->prepare($sql)->execute([$push]);

// Delete them from the pending db so they don't bubble back up tomorrow
$delete = $conn->prepare("DELETE * FROM user_articles WHERE article_url=?")->execute([$_POST['push']]);

echo "Front page updated!";
exit();
?>