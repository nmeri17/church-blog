<?php
session_start();
$_SESSION = Array();
session_destroy();
header("Location:http://agwconitsha.org");
?>