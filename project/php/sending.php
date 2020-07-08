<?php
	include ('db.php');
	include ('sendMessage.php');
	function sending() {
		require ('authorization.php');

		$db = new Db('project','');

		$title = $_POST['title'];
		$message = $_POST['message'];
		$senderId = $_SESSION['userID'];

		//Get all user ids
		$sql = "SELECT userID FROM users WHERE userID != ?";
		$allIds = array_map(function ($user) {
			return $user['userID'];
		}, $db->select($sql,[$senderId]));

		//Send message to all users
		sendMessage($senderId, $allIds, 5, $title, $message, $db);
		header("Location: success.php");
    }
?>