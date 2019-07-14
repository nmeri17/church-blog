<?php
session_start();
include "classes/my_conn.php";

// get connection
$conn = new My_conn("mysqli:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657", array(PDO::ATTR_PERSISTENT => true));
$conn = $conn->gc();

?>

<!DOCTYPE html>
<html lang=en>
<head>
	<meta charset=utf-8>
	<link href='index.css' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link type="x-image/icon" rel="icon" href="../favicon.ico">
	<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
	<title> AGWC Blog </title>
</head>

<body>
	<?php
		include 'header.php';
	?>
	
	<main> 
	<section>
	<!--== DUMMY POST TO BE REMOVED WHEN WE HAVE ACTUAL CONTENT ===-->
		<div class=new-post>
			<div class=image-holder> <img src='posts/banner2.jpg' alt=''> </div>
			<div class='text-holder'>	
				<p class=article-title> <span style='float: left; font-size: 65%; color: #acacac; margin-top: 1%'><i class="fa fa-comments"></i>  282</span> <a href='posts/pastor_test.php'>Then Go Even Deeper And Narrower </a></p>
				<p class='articleBody'>
				
				A young Eritrean man in his early twenties has two nephews and one niece but is particularly fond of the niece; partly because they both share similar traits
				and temperaments. During each visit to her parents' home, they spend the most time together, with her clinging unto him. Her pudgy arms raised
				in the air, beckoning to her uncle, she says 'Carry me. Carry me.' in a voice unusually deep for a three year old girl. And he obliges by lifting her aloft into what can be considered her nirvana.
				</p>
			</div>
			<div class=more> <a href='posts/pastor_test.php'>More &#187;</a></div>
		</div>
		
		<div class=new-post>
			<div class=image-holder> <img src='posts/banner1.jpg' alt=''> </div>
			<div class='text-holder'>	
				<p class=article-title> <span style='float: left; font-size: 65%; color: #acacac; margin-top: 1%'> <i class="fa fa-comments"></i> 365</span> <a href='posts/pastor_test.php'>Then Go Even Deeper And Narrower </a></p>
				<p class='articleBody'>
				A young Eritrean man in his early twenties has two nephews and one niece but is particularly fond of the niece; partly because they both share similar traits
				and temperaments. During each visit to her parents' home, they spend the most time together, with her clinging unto him. Her pudgy arms raised
				in the air, beckoning to her uncle, she says 'Carry me. Carry me.' in a voice unusually deep for a three year old girl. And he obliges by lifting her aloft into what can be considered her nirvana.
				</p>
			</div>
			<div class=more> <a href='posts/pastor_test.php'>More &#187;</a></div>
		</div>

	</section>
				<script>
				var body = $('.articleBody');
				for (var i = 0; i < body.length; i++) {
				body[i].innerHTML = body[i].innerHTML.substr(0, 300) + '...';
				}
				</script>
	<aside>

		<div id=book-of-the-month>
			<p> book of the month</p>
			<div id=book-image> <img src=book.jpg alt='book-of-the-month'> </div>
			<p> the introvert advantage </p>
		</div>
		
		<div id=testimonies>
			<p> testimonies</p>
			<p>The patient opened his eyes, and then squinted at its intruding brightness. He felt sedated but mildly alarmed at his new environment. He busied his mind
			with the unsuccessful task of attempting to recall what events preceded his current admission at the hospital.</p>
			<p> <a href=#>-<?php
			// while we're still waiting for content, if a user is signed in, display their name here
			if (isset($_SESSION['username'])){
			echo $deets->name;
			}
			else echo "Raheem Sadiq";
			?> </a></p>
		</div>
		
		<div id=announcements>
			<p> announcements</p>
			<ul>
				<li> <i class="fa fa-angle-left"></i> The patient pauses for a few seconds.</li>
				<li> <i class="fa fa-angle-left"></i> Sorry--what day is it, Sunday. Today is Sunday 18th July 1976.</li>
				<li> <i class="fa fa-angle-left"></i> Please where is your family and who settles your bill?.</li>
			</ul>
		</div>
		
		<div id=social>
			<p> find us elsewhere</p>
			<div id=social-button-holder> <div> <a href=#><i class="fa fa-facebook"></i> </a> </div> <div><a href=#><i class="fa fa-twitter"> </i>  </a></div> </div>
		</div> 
	</aside>
	
	<!--<?php
		
		// grab all posts
		if ($get_all = $conn->query("SELECT * FROM blog_posts")):
		while ($each_post = $get_all->fetch(PDO::FETCH_OBJ)):
	
	?>
		<div class=new-post>
			<div class=image-holder> <img src='<?php echo $each_post->article_url. "banner.jpg"; ?>' alt=''> </div>
			<div class='text-holder'>	
				<p class=article-title> <span style='float: left; font-size: 65%; color: #acacac; margin-top: 1%'><i class="fa fa-comments"></i>
				
				// display number of comments
				<?php
				$number_of_comments = $conn->query("SELECT COUNT(*) FROM comments_table WHERE parent_post='$each_post->article_title'");
				$number_of_comments->execute();

				echo $number_of_comments->fetch();
				?>
				
				</span> <a href='<?php echo $each_post->article_url; ?>'> <?php echo $each_post->article_title; ?> </a></p>

				<p class='articleBody'>	<?php echo $each_post->article_body; ?> </p>
			</div>
			<div class=more> <a href='<?php echo $each_post->article_url; ?>'>More &#187;</a></div>
		</div>
		<?php
		endwhile;
		endif;
		?>

		<!--===END OF MAIN SECTION. SIDE BAR BEGINS HERE ===-/->
		<div id=book-of-the-month>
			<p> book of the month</p>
			<div id=book-image> <img src=book.jpg alt='b-of-the-m'> </div>
			
			<?php
			$books = $conn->query('SELECT book_of_the_month FROM sidebar LIMIT 1');
			$books->execute();
			$book = $books->fetch(PDO::FETCH_ASSOC);
			?>
			<p> <?php echo $book['book_of_the_month']; ?> </p>
			
		</div>
		
		<div id=testimonies>
			<p> testimonies</p>
			
			<?php
			$testimonies = $conn->query('SELECT testimony_body, testimony_author FROM sidebar LIMIT 1');
			$testimonies->execute();
			$testimony = $testimonies->fetch(PDO::FETCH_OBJ);
			?>
			<p><?php echo $testimony->testimony_body; ?> </p>
			<p>-<?php echo $testimony->testimony_author; ?> </p>
			
		</div>
		
		<div id=announcements>
			<p> announcements</p>
			<ul>
			
			<?php
			$ann = $conn->query('SELECT announcements FROM sidebar LIMIT 3');
			$ann->execute();
			while ($announcements = $ann->fetch(PDO::FETCH_OBJ)):
			?>
				<li> <i class="fa fa-angle-left"></i> <?php echo $announcements->announcements; ?> </li>
			<?php
			endwhile;
			?>
			</ul>
		</div>-->
	</main>
	<?php
		include 'footer.php';
	?>
</body>
</html>