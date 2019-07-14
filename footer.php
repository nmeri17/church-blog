<footer>
	<div id=quicklinks> <a href='http://blog.agwconitsha.org/about/'> about</a> <a href=#> advertise</a> <a href='http://agwconitsha.org'> parent site</a> <a href='http://agwconitsha.org/contact'> contact</a> <a href='http://agwconitsha.org/sermons/'> sermons</a>
	<?php
	if (isset($_SESSION['username'])):
	echo "<a href='http://blog.agwconitsha.org/login/sign_out.php'> sign out</a>";
	else:
	echo "<a href='http://blog.agwconitsha.org/login/'> sign in</a>";
	endif;
	?>
	</div>
	<div> <img src='/blog/using_mod_rewrite/new_logo.png' alt=""> Logo, brand and contents, property of AGWC Onitsha. <?php echo date("Y"); ?> All Rights Reserved</div>
	<div> Developer:<a href=http://twitter.com/mmayboy_ target="_blank"> CONQUEROR ST </a></div>
	
</footer>
	