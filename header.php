<?php

if(isset($_SESSION['username'])) {
	include "classes/member_class.php";
	include "classes/my_conn.php";

	// get connection
	$conn = new My_conn("mysqli:host=localhost;dbname=agwconit_general_db", "agwconit_root",  "07039841657", array(PDO::ATTR_PERSISTENT => true));
	$conn = $conn->gc();

	// Fetch current user's data for use when needed
	$deets = Member::fetch_me($conn, $_SESSION['username']);
	$conn = NULL;
}
?>

	<header class=header-class>
	<img class=logo src='/blog/using_mod_rewrite/logo.png' alt=logo> 
		<h1>
			BLOG
		</h1>
	
		<!--HAMBURGER MENU-->
		<div id=hamburger>
			<div class=lines> </div>
			<div class=lines> </div>
			<div class=lines> </div>
		</div>
		
	<!--MAIN SITE NAVIGATION-->
	<nav>
		<ul>
			<li><a href='http://agwconitsha.org'>Home</a></li>
			<li><a href='http://agwconitsha.org/about/'>About Us</a></li>
			<li><a href='http://agwconitsha.org/sermons/'>Sermons</a></li>
			<li><a href=http://blog.agwconitsha.org>Blog</a></li>
			<li><a href='http://agwconitsha.org/contact/'>Contact</a></li>
			<li><a href='http://agwconitsha.org/giving/'>Giving</a></li>
		</ul>
	</nav>
	</header>

	<script>
			$("#hamburger").click(function() {
			if ($("#hamburger").hasClass("open")) {
			$("#hamburger").removeClass("open");
			$("nav ul").css("transform", "translatex(540px)");
			}
			else {
			$("#hamburger").addClass("open");
			$("nav ul").css("transform", "translatex(0)");
			}
			});
	</script>
		
		<!--BLOG MENU STARTS HERE-->
	<div id=blogMenu>
		<div> <a href='http://blog.agwconitsha.org/'> Home</a> </div>
		<div id=categoryDiv> <a href='http://blog.agwconitsha.org/categories/'> Categories <i class="fa fa-angle-down"></i></a> <div id=categories></div></div>
		<div> <a href='http://blog.agwconitsha.org/about/'> About</a> </div>
		<div>
	<?php
	if (isset($_SESSION['username'])):
	?>
	<a href='<?php echo $deets->pagename; ?>'> Me</a>
	
	<?php
	else:
	?>
	<a href='/blog/using_mod_rewrite/login/'> Sign In</a>
	<?php
	endif;
	?>
		</div>
		
		<!--SEARCH FORM -->
		<form>
			<input type=search name=searchArticle placeholder='search article'/>
			
		</form>
	</div>
		<script>
		$('#categoryDiv').on("hover", function(){
		/*$('#categores').load('http://blog.agwconitsha.org/categories/index.php .results', function(e){
		$('.results');
		});*/
		alert('yes');
		});
		</script>
	
	<!--END OF NAVIGATION MENUS. MAIN CONTENT STARTS BELOW-->