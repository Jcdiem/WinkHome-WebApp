<?php
session_start();

if(!$_SESSION['user']) {
	header("Location: login.php?redirect={$_SERVER['REQUEST_URI']}");
	exit();
}
?>
