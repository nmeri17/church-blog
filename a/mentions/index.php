<?php

	function mentions () {
	$conn = new mysqli("localhost", "agwconit_root",  "07039841657", "agwconit_general_db");
	$query = "SELECT comments, author FROM comments_table WHERE comments LIKE $this->name";
	$mentions = $conn->query($query);
	echo "You have $mentions->num_rows mentions\n";
	if ($mentions->num_rows > 0) {
		echo "<ul id=mentions> \n <li>";
		while ($row = $mentions->fetch_assoc()) {
			echo $row['author'] . "mentioned you in their comment on " . $row['parent_post'] . "\n " . "<div class=mention>" . $row['comments'].
			"</div> </li> <li>";
		}
		echo "</li> </ul>";
	}
	}
?>