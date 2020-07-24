<?php
	function sendAll() {
		
		require ('../backend/inbox/common/db.php');
		require ('sendMessage.php');
		require ('authorization.php');

		$db = new Db();

		$title = $_POST['object'];
		$message = $_POST['message'];
		$senderId = $_SESSION['userID'];

		//Get all user ids
		$sql = "SELECT userID FROM users WHERE userID != ?";
		$allIds = array_map(function ($user) {
			return $user['userID'];
		}, $db->select($sql,[$senderId]));

		//Send message to all users
		sendMessage($senderId, $allIds, 5, $title, $message, $db);
    }
?>