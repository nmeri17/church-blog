<?php
//include "../settings.php";
?>
<!DOCTYPE html>
<html lang=en>
<head>
	<meta charset=utf-8>
	<style>
	* {
	margin: 0;
	padding: 0;
	text-decoration: none;
	box-sizing: border-box;
}

body {
	font-family: 'Lato', sans-serif;
	background-color: #f0f0f0;
	color: #666;
}

header {
	width: 100%;
	height: 98px;
	background-color: #1e4969;
	padding-top: 5px;
	color:  #fff;
}

header .logo {
	width: 5.4%;
	height: 78%;
	position: relative;
	margin-top: 3px;
	left: 2%;
	z-index: 9999999;
	max-width: 100%;
	max-height: 100%;
}

header h1 {
	position: relative;
	backface-visibility: hidden;
	z-index: 9999999;
	margin-left: 8%;
	margin-top: -3%;
	font-family: Raleway;
}

#hamburger {
	height: 60px;
	width: 60px;
	position: absolute;
	top: 5%;
	right: 2%;
	z-index: 9999999;
	padding: 6px;
	box-sizing: border-box;
	display: flex;
	flex-flow: row wrap;
	justify-content: space-between;
	cursor: pointer;
	overflow: hidden;
}

.lines {
	flex: 1 58%;
	height: 8px;
	background: #fff;
	margin-left: auto;
	margin-right: auto;
	border-radius: 2px;
	box-shadow: inset 0 0 4px #888;
	transition: all 0.2s ease-in-out;
}

#hamburger.open .lines:first-child {
	transform: rotate(-40deg);
	position: relative;
	top: 22.5px;
	transition: all 0.2s ease-in-out;	
}

#hamburger.open .lines:nth-child(2) {
	transform: rotate(50deg);
	transition: all 0.2s ease-in-out;
}

#hamburger.open .lines:last-child {
	display: none;
}

#hamburger.open nav ul {
	transform: translatex(0);
}

nav {
	width: 32%;
	height: 42.5px;
	position: absolute;
	right: 6%;
	top: 55px;
	font-weight: bold;
	box-sizing: border-box;
	text-transform: uppercase;
	font-size: 84%;
	z-index: 9999999;
	overflow: hidden;
}

nav ul {
	position: absolute;
	transform: translatex(540px);
	transition: all 0.3s ease-in-out;
}

nav a {
	color: #bbb;
}

nav li {
	list-style: none;
	display: table-cell;
	padding: 8px;
	height: 30px;
	color: #999;
	white-space: nowrap;
}

nav > ul > li:nth-child(4) a, nav ul li:hover a {
	color: #f1f1f1;
}

#blogMenu {
	position: relative;
	display: flex;
	flex-flow: row nowrap;
	justify-content: center;
	background: #fff;
	font-family: raleway;
	text-transform: uppercase;
	font-size: 75%;
	font-weight: bold;
	}

#blogMenu a {
	color: #333;
	}
	
#blogMenu div {
	padding: 2%;
	}
	
#blogMenu > div:first-child, #blogMenu div:hover {
	background: #f7f7f7;
	}
	
#blogMenu form {
	position: absolute;
	right: 2.5%;
	height: 70%;
	width: 15.5%;
	margin-top: .8%;
	overflow: hidden;
	}
	
#blogMenu input {
	height: 100%;
	width: 100%;
	font-size: 100%;
	border: 1px solid #aaa;
	font-family: lato;
	}
	
#blogMenu form i {
	background: #f0f0f0;
	color: #888;
	padding: 3%;
	position: absolute;
	left: 76.7%;
	top: 2%;
}

aside {
	float: right;
	margin-top: 4%;
	margin-right: 3%;
	width: 8%;
	height: 220px;
	display: flex;
	flex-flow: row wrap;
	justify-content: space-around;
}

aside span {
	flex: 1 100%;
	height: 100px;
	border-radius: 5px;
	background: #edc0da;
}


aside span a {
	color: #f0f0f0;
	margin-left: 1.5%;
	}

main {
	height: auto;
	width: 59%;
	background: #fff;
	margin: 0 auto;
	margin-top: 4%;
	border: 1px solid #e0e0e0;
}

#banner-image {
	margin-top: 3%;
	width: 100%;
	height: 360px;
}

#banner-image img {
	max-height: 100%;
	max-width: 100%;
	opacity: .95;
}

h2 {
	margin-top: 3%;
	margin-left: 3%;
	color: #888;
	text-transform: capitalize;
}

#info {
	width: 95%;
	height: 40px;
	border-bottom: 1px outset silver;
	margin: 0 auto;
	text-transform: uppercase;
	font-size: 80%;
	padding-top: 3%;
	color: #aaa;
}

#author {
	color: #777;
}

#date {
	float: right;
}

main section {
	margin: 4%;
	line-height: 32px;
	color: #555;
}

#controls {
	height: 50px;
	display: flex;
	flex-flow: row nowrap;
	}

#controls span {
	margin-right: 1%;
	border-radius: 15px;
	flex: 0 10%;
	height: 65%;
	background: #726;
	padding-left: 1.5%;
}

#controls a {
	color: #ddd;
}
	
#categories {
	margin: 0 auto;
	width: 59%;
	}

#categories a {
	text-decoration: underline;
	color: #444;
}

#share {
	margin-left: 21%;
	margin-top: 2%;
}

#share a {
	padding: 1%;
	background: #3b5998;
	color: #fff;
	margin-right: 1%;
}

#share a:last-child {
	background: #00aced;
	}

#new-comment {
	margin: 0 auto;
	margin-top: 5%;
	width: 59%;
	background: #fff;
	height: 100px;
	padding-top: 1%;
	display: flex;
	flex-flow: row nowrap;
	justify-content: space-around;
	overflow: hidden;
}

#new-comment div {
	flex: 0 9%;
	height: 80.5%;
	border-radius: 50%;
	overflow: hidden;
	margin-right: 1%;
}

#new-comment div img {
	height: 100%;
	width: 100%;
}

#new-comment form {
	display: flex;
	flex-flow: row nowrap;
	justify-content: space-between;
	overflow: hidden;
}

textarea {
	font-family: inherit;
	font-size: inherit;
	border: 0;
	outline: 0;
	margin-top: 3%;
	resize: none;
	}

#new-comment form input {
	flex: 1 10%;
	height: 40px;
	border-radius: 3px;
	border: 0;
	margin-top: 15%;
	transition: all .2s ease-in-out;
}

#comments {
	margin: 0 auto;
	margin-top: 5%;
	height: auto;
	width: 59%;
	padding-bottom: 3%;
}

hr {
	width: 3%;
	border-bottom: 1px outset white;
}

#comments > div {
	background: #fff;
	height: auto;
	display: flex;
	flex-flow: row wrap;
	justify-content: space-around;
	margin-top: 2%;
	padding: 2%;
	}

#comments > div > div:first-child {
	flex: 0 7%;
	height: 55px;
	border-radius: 50%;
	overflow: hidden;
	margin-right: 1%;
}

#comments > div > div img {
	height: 100%;
	width: 100%;
	opacity: .9;
}

#comments > div .span {
	text-transform: uppercase;
	flex: 1 80%;
	font-size: 80%;
	color: #aaa;
	padding-top: 5%;
}

#comments > div p {
	flex: 1 100%;
	margin-top: 1%;
	line-height: 28px;
}

footer {
	height: 250px;
	background: #555;
	padding-top: 6%;
}

#quicklinks {
	display: flex;
	flex-flow: row wrap;
	justify-content: center;
}

#quicklinks a {
	color: #aaa;
	text-transform: uppercase;
	margin-right: 4%;
	font-size: 75%;
}

footer div:nth-child(2) {
	margin: 0 auto;
	width: 38%;
	height: 85px;
	padding-top: 3%;
	color: #888;
	font-size: 70%;
}

footer div:nth-child(2) img {
	height: 80%;
	max-width: 100%;
	opacity: .5;
	}

footer div:nth-child(3) {
	float: right;
	width: 15%;
	background: #116ba1;
	color: #ddd;
	padding: 1%;
	white-space: nowrap;
	margin-top: 1.8%;
	font-size: 85%;
}

footer div:nth-child(3) a {
	color: #fff;
}
	</style>
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
	<title> title </title>
</head>

<body>
	<header class=header-class>
	<img class=logo src=../../logo.png alt=logo> 
		<h1>
			BLOG
		</h1>
	
		<div id=hamburger>
			<div class=lines> </div>
			<div class=lines> </div>
			<div class=lines> </div>
		</div>
		
	<nav>
		<ul>
			<li><a href=#>Home</a></li>
			<li><a href=about/index.html>About Us</a></li>
			<li><a href=sermons/index.html>Sermons</a></li>
			<li><a href=blog.agwconitsha.org>Blog</a></li>
			<li><a href=contact/index.html>Contact</a></li>
			<li><a href=giving/index.html>Giving</a></li>
		</ul>
	</nav>
	</header>
	<script>
			$("#hamburger").click(function() {
			$("#hamburger").toggleClass("open");
			$("nav ul").css("transform", "translatex(0)");
			});

	</script>
	<div id=blogMenu>
		<div> <a href=/blog/> Home</a> </div>
		<div> <a href=/blog/> Categories <i class="fa fa-angle-down"></i></a> </div>
		<div> <a href=/blog/> About</a> </div>
		<div> <a href=/blog/> Me</a> </div>
		<form>
			<input type=search name=searchArticle placeholder='search article'/>
		</form>
	</div>
	
	<?php
		$query_string = "SELECT id FROM blog_posts_table WHERE article_title=" . $article_title;
		$row['id'];
		$next = "SELECT article_url FROM blog_posts_table WHERE id=" . $row['id'] + 1;
		$prev = "SELECT article_url FROM blog_posts_table WHERE id=" . $row['id'] - 1;
		
	?>
	<aside>
		<span><a href=#?article_title> <i class="fa fa-arrow-right fa-5x"></i></a></span> <!-- convert this to php===> article_title -->
		<span><a href=#?article_title> <i class="fa fa-arrow-left fa-5x"></i></a></span>
	</aside>
	<main>
		<h2> Then Go Even Deeper And Narrower</h2>
		<div id=banner-image> <img src=banner2.jpg alt=""> </div>
		<div id=info> by<span id=author> raheem sadiq</span> <span id=date> sunday 17 July 2016</span> </div>
		
		<section>
		******** <br>
		<p>A young Eritrean man in his early twenties has two nephews and one niece but is particularly fond of the niece; partly because they both share similar traits and temperaments. During each visit to her parents' home, they spend the most time together, with her clinging unto him. Her pudgy arms raised in the air, beckoning to her uncle, she says
'Carry me. Carry me.'<br>
in a voice unusually deep for a three year old girl. And he obliges by lifting her aloft into what can be considered her nirvana. Back at his own home--while taking a dump--thoughts of her airborne pleas cross his mind, amusing him. He gets up from the toilet seat and raises his arms, jocularly motioning to be carried.
'Carry me. Carry me' he says, smiling to himself.
Just then, a pair of arms come through the ceiling and lifts him into where they came from. He is taken away with his pants still on the floor and the toilet unflushed.
<br>******* </p>
<p>
The patient opened his eyes, and then squinted at its intruding brightness. He felt sedated but mildly alarmed at his new environment. He busied his mind with the unsuccessful task of attempting to recall what events preceded his current admission at the hospital. He was thoughtfully propped up when moments later, a very brief doctor walked into the room. <br>

'I see you're awake, Mr. Razak...' the doctor says glancing at his notepad.<br>
'...Sadiq. Mr. Raheem Sadiq, right?'<br>
'Yes.'<br>
'You were brought here last Tuesday by the people at your office. You were found unconsciously sprawled on the floor and they considered it wise to come dump you here. No one has visited you since then. Haven't you got a wife or kids?'<br>
The patient pauses for a few seconds.<br>
'Sorry; what day is it?'
'Sunday. Today is Sunday 18th July 1976. I forgot to welcome you to our planet and give you a crash course cum orientation. Please where is your family? Who settles your bill?'<br>
'I will. Why did I collapse?'<br>
'Oh! You've got polyarthritis nodosa.'<br>
'I don't understand. I mean, I've never heard of it before. How did I get it? What are the implications?'<br>
'It implies you do not have much time left to live. The nurse at the counter will give you its leaflet.'<br>
The patient ruefully stares blankly at the bed railing, internally battling to contain the flurry of morbid emotions triggered by this new knowledge.<br>
'Sir? Your bill amounts to N28.13k.'<br>
Jolted back to reality, he turns to face the doctor.<br>
'I'll pay you once I can leave.'<br>
'You can, as soon as you think you're strong enough.' The doctor says with a sardonic smile and starts toward the door.<br>
Just before he turns the knob, the patient asks<br>
'How much time have I got left? Two years? Three?'<br>
He turns around swiftly and retorts<br>
'Much, much less!'<br>
in a shrill almost metallic voice before exiting the room.

			<div id=controls> <span> <a href=#>Edit </a> </span> <span> <a href=#>Delete </a> </span></div>
		</section>
	</main>
		<div id=categories>Categorized under: <a href=#>Theology </a>, <a href=#>Reincarnation </a></div>
		<div id=share> <a href=#><i class="fa fa-facebook"></i> Facebook </a> <a href=#><i class="fa fa-twitter"></i> Twitter </a> </div>
		<!--sign in to post a comment -->
		<div id=new-comment>
			<div> <img src=comment.jpg alt=""> </div>
			<form action="" method=GET>
				<textarea name=new_comment cols=70 rows=7 placeholder="Your awesome comment goes here"></textarea>
				<input type=submit value=comment>
			</form>
			<script>
			var text = document.querySelector("textarea");
			text.addEventListener("focus", function(){
			text.parentNode.getElementsByTagName("input")[0].style.marginTop = "0";
			});
			</script>
		</div>
		
		<section id=comments>
		<h3> 4 Responses</h3> <hr>
		
		<div id=1>
		<div> <img src=user1.jpg alt=""> </div>
		<div class=span> amaka donnia <span style="float: right; margin-top: -4%">12:44pm</span> </div>
		<p> I hate being boxed into the dilemma I'm in currently. Especially, since proponents of such opinions are considered atheists and infidels and I'm
		neither of those--'least not yet. Of my annual appearances in church, last year was the least.</p>
		</div>
		
		<div id=2>
		<div> <img src=user3.jpg alt=""> </div>
		<div class=span> yemi jimba <span style="float: right; margin-top: -4%">11:00am</span> </div>
		<p> Now, staring at the system from its exterior, it seems anaemic and unappealing. I think that was putting it mildly: Its components bear marked
		semblance to deceptive devices faultlessly suitable for controlling its blindfolded and utterly inane occupants.</p>
		</div>
		</div>
		
		<div id=3>
		<div> <img src=user2.jpg alt=""> </div>
		<div class=span> nwando ogbuotobo <span style="float: right; margin-top: -4%">17:59pm</span> </div>
		<p> From the biblically proclaimed lukewarm orthodox, to the self-centred, money oriented youth based churches riddled with all the impunity driven
		immorality synonymous with this generation and have decomposed into scouting fields for satiation of lustful intents. The bible says to "love your enemies"
		and "do good to those who hate you" (Luke 6:27-30, Proverbs 24:17).</p>
		</div>
		</div>
		
		<div id=4>
		<div> <img src=user4.jpg alt=""> </div>
		<div class=span> Ramsay munachukwuso <span style="float: right; margin-top: -4%">20:17pm</span> </div>
		<p> With those in mind, pay a little attention to the prayers emanating from the countless speakers that weekly constitute a nuisance to the serenity of our
		residences (which by the way, they get away with; sadly). One should marvel at the density of toxic emotions a man bears for his fellow man.</p>
		</div>
		
		</section>
	<footer>
	
	<div id=quicklinks> <a href=#> about</a> <a href=#> advertise</a> <a href=#> parent site</a> <a href=#> contact</a> <a href=#> sign out</a></div>
	<div> <img src=new_logo.png alt=""> Logo, brand and contents, property of AGWC Onitsha. <?php echo date("Y"); ?> All Rights Reserved</div>
	<div> Developer:<a href=http://twitter.com/mmayboy_ target="_blank"> CONQUEROR ST </a></div>
	</footer>
</body>
</html>