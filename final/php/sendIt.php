<?php
require ('sendAll.php');
include "../backend/inbox/common/db.php";
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
        $db = new Db();
        $conn = $db->getConnection();
    } catch (PDOException $e) {
        $error = "В момента има проблем с базата данни, моля опитайте по-късно!";
        return;
    }

    if (strlen($message) == 0 || strlen($message) > 2048) {
        $error = "Съобщението трябва да е между 1 и 2048 символа!";
        return;
    }
    if (strlen($object) == 0 || strlen($object) > 128) {
        $error = "Полето 'Относно' трябва да е между 1 и 128 символа!";
        return;
    }
    if (isset($_POST['draft'])) {
        $type = 6;
        $sql = "INSERT INTO message (msgType, title, content, senderId)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$type, $object, $message, $id]);

        $sql = "SELECT MAX(`msgId`) FROM message WHERE senderId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $msgId = $result["MAX(`msgId`)"];

        $sql = "INSERT INTO inboxmessages (inboxId, msgId)
                    VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id, $msgId]);
        return;
    }
    if (isset($_SESSION['ban_until']) && $_SESSION['ban_until'] > date('Y-m-d')) {
        $error = "Вашият акаунт е баннат до ".$_SESSION['ban_until'];
        return;
    }
    if (isset($_POST['sendGroup'])) {
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

    $to = explode(" ", $to);

    if (count($to) > 1 && isset($_POST['anonySubmit'])) {
        $error = "Не е позволено пращането на анонимно съобщение до много потребители!";
        return;
    }
    
    foreach ($to as $check) {
        if (strlen($check) < 4) {
            $error = "Не е позволено се праща по тема когато съобщението е до много потребители!";
            return;
        }
    }

    foreach ($to as $receiver) {
        if (isset($sent[$receiver]) &&  isset($sent[$receiver]) == 1) {
            continue;
        }

        $sent[$receiver] = 1;

        if (strlen($receiver) == 0 || strlen($receiver) > 64) {
            $error = "До трябва да е между 1 и 64 символа!";
            return;
        }

        if (strlen($receiver) < 4) {
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
            elseif (strlen($receiver) < 4) {
                $type = 1;
            }
            else {
                $type = 2;
            }
        }

        if (strlen($receiver) < 4 ) {
            $sql = "SELECT * FROM users WHERE number_theme = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$receiver]);
            $row = $stmt->fetch();
            $receiverId[$receiver] = $row['userID'];

            if (!$row) {
                $error = "Няма потребител с тема: $receiver";
                return;
            }
            elseif ($_SESSION['recension_number'] == $receiver && $type = 1) {
                $_SESSION['sent'] = true;
            }
        }
        else {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$receiver]);
            $row = $stmt->fetch();
            $receiverId[$receiver] = $row['userID'];
            
            if (!$row) {
                $error = "Няма потребител с име: $receiver";
                return;
            }
        }
    }

    if (count($to) == 1) {
        $to = $to[0];
    }
    else {
        $to = "multi";
    }
    
    

    $sql = "INSERT INTO message (msgType, title, content, senderId)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$type, $object, $message, $id]);
    
    $sql = "SELECT MAX(`msgId`) FROM message WHERE senderId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    $msgId = $row["MAX(`msgId`)"];

    foreach ($receiverId as $recId) {
        $sql = "INSERT INTO inboxmessages (inboxId, msgId)
                VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$recId, $msgId]);
    }


    header("Location: success.php?to=" . $to);
    exit();
}