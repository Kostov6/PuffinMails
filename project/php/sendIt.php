<?php
require ('sendAll.php');
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

    try{
        $conn = new PDO("mysql:host=localhost:3306;dbname=project", "root", "");
    } catch (PDOException $e) {
        $error = "В момента има проблем с базата данни, моля опитайте по-късно!";
        return;
    }

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
        $sql = "INSERT INTO message (msgType, title, content, senderId)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$type, $object, $message, $id]);
        return;
    }
    elseif (isset($_POST['sendGroup'])) {
        if (!isset($_SESSION['member_of'])) {
            $error = "Вие не сте член на група";
            return;
        }

        $type = 4;
        $sql = "SELECT * FROM users WHERE member_of = ? and userID != ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION['member_of'], $_SESSION['userID']]);
        $row = $stmt -> fetchAll();

        $sql = "INSERT INTO message (msgType, title, content, senderId)
            VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$type, $object, $message, $id]);

        $sql = "SELECT MAX(`msgId`) FROM message WHERE senderId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $msgId = $result["MAX(`msgId`)"];
        
        foreach ($row as $row) {
            $sql = "INSERT INTO inboxmessages (inboxId, msgId)
                    VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$row['userID'], $msgId]);
        }
        header("Location: success.php?to=sendGroup");
		return;
	}
	elseif (isset($_POST['sendAll'])) {
        sendAll();
        header("Location: success.php?to=sendAll");
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
        elseif (!isset($_SESSION['end'])) {
            $error = "В момента не могат да се изпращат анонимни съобщения!";
            return;
        }
        elseif  ($_SESSION['is_admin'] == 1) {
            $error = "Администраторите не могат да пращат анонимни писма!";
            return;
        }
        elseif (strlen($to) < 4) {
            $type = 1;
        }
        else {
            $type = 2;
        }
    }

    if (strlen($to) < 4 ) {
        $sql = "SELECT * FROM users WHERE number_theme = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$to]);
        $row = $stmt->fetch();

        if (!$row) {
            $error = "Няма потребител с тема: $to";
            return;
        }
        elseif ($_SESSION['recension_number'] == $to) {
            unset($_SESSION['end']);
        }
    }
    else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$to]);
        $row = $stmt->fetch();
		
        if (!$row) {
            $error = "Няма потребител с име: $to";
            return;
        }
    }
    $too = $to;
    $to = $row['userID'];

    $sql = "INSERT INTO message (msgType, title, content, senderId)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$type, $object, $message, $id]);
    
    $sql = "SELECT MAX(`msgId`) FROM message WHERE senderId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    $msgId = $row["MAX(`msgId`)"];

    $sql = "INSERT INTO inboxmessages (inboxId, msgId)
            VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$to, $msgId]);
    header("Location: success.php?to=" . $too);
}