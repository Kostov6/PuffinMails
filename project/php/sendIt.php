<?php
include ('sending.php');
function checkIfAnony($message){
    $exp = "/".$_SESSION['username']."|".$_SESSION['faculty_number']."|".$_SESSION['first_name']."|".$_SESSION['last_name']."/";
    if (preg_match( $exp, $message)) {
        return false;
    }
    else {
        return true;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $to = $_POST['to'];
    $object = $_POST['object'];
    $message = $_POST['message'];
    $id = $_SESSION['userID'];
    $error = "";
    $type = 0;

    if (strlen($message) == 0 || strlen($message) > 2048) {
        $error = "Съобщението трябва да е между 1 и 2048 символа!";
        return;
    }
    if (strlen($object) == 0 || strlen($object) > 128) {
        $error = "Темата трябва да е между 1 и 128 символа!";
        return;
    }
    if (isset($_POST['draft'])) {
        $type = 6;
        $conn = new PDO("mysql:host=localhost:3306;dbname=project", "root", "");
        $sql = "INSERT INTO message (msgType, title, content, senderId)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$type, $object, $message, $id]);
        return;
    }
	else if (isset($_POST['sendAll'])) {
		$_SESSION["last"] = 5;
		sending();
		return;
	}

    if (isset($_SESSION['ban_until']) && $_SESSION['ban_until'] > date('Y-m-d')) {
        $error = "Вашият акаунт е баннат до ".$_SESSION['ban_until'];
        return;
    }

    if (strlen($to) == 0 || strlen($to) > 64) {
        $error = "До трябва да е между 1 и 64 символа!";
        return;
    }

    if (strlen($to) < 4) {
        $type = 3;
    }
    if ((isset($_POST['anonySubmit']))) {
        if (!checkIfAnony($message)) {
            $error = "Съобщението не е анонимно!";
            return;
        }
        if (strlen($to) < 4) {
            $type = 1;
        }
        else {
            $type = 2;
        }
    }

    if (strlen($to) < 4 ) {
        $conn = new PDO("mysql:host=localhost:3306;dbname=project", "root", "");
        $sql = "SELECT * FROM users WHERE number_theme = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$to]);
        $row = $stmt->fetch();

        if (!$row) {
            $error = "Няма потребител с тема: $to";
            return;
        }
    }
    else {
        $conn = new PDO("mysql:host=localhost:3306;dbname=project", "root", "");
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$to]);
        $row = $stmt->fetch();
		
        if (!$row) {
            $error = "Няма потребител с име: $to";
            return;
        }
    }
    $_SESSION['to'] = $to;
    $to = $row['userID'];

    $sql = "INSERT INTO message (msgType, title, content, senderId)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$type, $object, $message, $id]);
    
    $sql = "SELECT MAX(`msgId`) FROM message WHERE senderId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    $msgid = $row["MAX(`msgId`)"];

    $sql = "INSERT INTO inboxmessages (inboxId, msgId)
            VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$to, $msgid]);
    header("Location: success.php");
}