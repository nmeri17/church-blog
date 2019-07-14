<?php
		$conn = new mysqli("localhost", "agwconit_root",  "07039841657", "agwconit_general_db");
		$comments_query = "SELECT comments, parent_post FROM comments_table WHERE author=$this->$name";
		$all_comments = $conn->query($comments_query);
		if ($all_comments->num_rows > 0) {
			echo "<ul> \n<li>";
			while ($row = $all_comments->fetch_assoc()) {
				echo $this->name . "commented on " . $row['parent_post'] ."<br>" . "\n <div class=comments>" . $row['comments'] . " </div> \n</li><li>";
			}
			echo "</li> \n</ul>";
		}
		$conn->close;
	}
?>