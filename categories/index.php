<?php
session_start();
?>

<!DOCTYPE html>
<html lang=en>
<head>
	<meta charset=utf-8>
	
	<link href='categories.css' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link type="x-image/icon" rel="icon" href="../../favicon.ico">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<title> Categories </title>
</head>

<body>
	<?php

	include "../header.php";

	?>
	<main>
		<section>
	<?php
		if (empty($_GET) || count($_GET) < 1):
	?>
	<h1>No categories to display</h1>
	<?php
		else:
		$conn = new mysqli("localhost", "agwconit_root",  "07039841657", "agwconit_general_db");
		if ($category = $conn->query("SELECT * FROM blog_posts WHERE categories LIKE '%" . $_GET['cat'] . "%'")):
		if ($category->num_rows < 1):
	?>
	<h1>Category does not exist!</h1>
	
	<?php
	else:
	?>
	<h1> Showing posts categorized under "<?php echo $_GET['cat']; ?>" </h1>

	<?php
		while ($each_post = $get_all->fetch_assoc()):
	
	?>
		<div class=new-post>
			<div class=image-holder> <img src='<?php echo $each_post['article_url'] . "banner.jpg"; ?>' alt=''> </div>
			<div class='text-holder'>	
				<p class=article-title> <span style='float: left; font-size: 65%; color: #acacac; margin-top: 1%'><i class="fa fa-comments"></i>
				
				<?php
				if ($comment_count = $conn->query("SELECT * FROM comments_table WHERE parent_post='" . $each_post['article_title'] . "'")) {
					echo $comment_count->num_rows();
				}
				?>
				
				</span> <a href='<?php echo $each_post['article_url']; ?>'> <?php echo $each_post['article_title']; ?> </a></p>
				<p class='articleBody'>	<?php echo $each_post['article_body']; ?> </p>
			</div>
			<div class=more> <a href='<?php echo $each_post['article_url']; ?>'>More &#187;</a></div>
		</div>
		<?php
		endwhile;
		endif;
		endif;
		endif;
		?>
	</section>
				<script>
				var body = $('.articleBody');
				for (var i = 0; i < body.length; i++) {
				body[i].innerHTML = body[i].innerHTML.substr(0, 300) + '...';
				}
				</script>
		</section>
	
	</main>

</body>
<?php include "../footer.php"; ?>
</html>