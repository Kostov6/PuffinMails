<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $fn = $_POST['fn'];
    $password = $_POST['password'];
    $error = "";

    try{
        $conn = new PDO("mysql:host=localhost:3306;dbname=project", "root", "");
    } catch (PDOException $e) {
        $error = "В момента има проблем с базата данни, моля опитайте по-късно!";
        return;
    }

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name]);
    $row = $stmt->fetch();

    if ($row[0] == 0) {
        $error = "Грешно потребителско име!";
    }
    else if (password_verify($password, $row['password_hash'])) {
        if ($fn == $row['faculty_number'] || $row['is_admin'] == 1) {
            session_start();
            $_SESSION=$row;
            $_SESSION['logged'] = true;
            "SELECT  FROM message WHERE senderId = ?";
            $sql = "SELECT * FROM events WHERE end_date > CURRENT_DATE()";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            $sql = "SELECT * 
                    FROM (message INNER JOIN inboxmessages ON message.msgId = inboxmessages.msgId) INNER JOIN users ON users.userID = inboxmessages.inboxId
                    WHERE msgType = 3 and senderId = ? and number_theme = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_SESSION['userID'], $_SESSION['recension_number']]);
            $row2 = $stmt->fetch();
            if ($row && !$row2) {
                $_SESSION['end'] = $row['end_date'];
            }
            header('Location: send.php');
        } else {
            $error = "Факултетния номер не отговаря с даденото потребителско име!";
        }
    } else {
        $error = "Грешна парола!";
    }
}
