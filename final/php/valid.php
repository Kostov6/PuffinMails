<?php
include "../backend/inbox/common/db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $fn = $_POST['fn'];
    $password = $_POST['password'];
    $error = "";

    try{
        $db=new Db();
        $conn = $db->getConnection();
    } catch (PDOException $e) {
        $error = "В момента има проблем с базата данни, моля опитайте по-късно!";
        return;
    }

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name]);
    $row = $stmt->fetch();

    if (!$row) {
        $error = "Грешно потребителско име!";
    }
    else if (password_verify($password, $row['password_hash'])) {
        if ($fn == $row['faculty_number'] || $row['is_admin'] == 1) {
            session_start();
            $_SESSION=$row;
            unset($_SESSION['password_hash']);
            $_SESSION['logged'] = true;
            "SELECT  FROM message WHERE senderId = ?";
            $sql = "SELECT * FROM events WHERE end_date > CURRENT_DATE()";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            $sql = "SELECT * 
                    FROM (message INNER JOIN inboxmessages ON message.msgId = inboxmessages.msgId) INNER JOIN users ON users.userID = inboxmessages.inboxId
                    WHERE msgType = 1 and senderId = ? and number_theme = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_SESSION['userID'], $_SESSION['recension_number']]);
            $row2 = $stmt->fetch();
            if ($row) {
                $_SESSION['end'] = $row['end_date'];
                if ($row2) {
                    $_SESSION['sent'] = true;
                }
                else {
                    $_SESSION['sent'] = false;
                }
            }
            header('Location: send.php');
        } else {
            $error = "Факултетния номер не отговаря с даденото потребителско име!";
        }
    } else {
        $error = "Грешна парола!";
    }
}
