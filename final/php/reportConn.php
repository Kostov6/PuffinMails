<?php
    require ('authorization.php');
    require ('../backend/inbox/common/db.php');

    $db = new Db();

    if (!isset($_GET['reportId'])) {
        header("Location: reports.php");
        exit();
    }

    $reportId = $_GET['reportId'];

    $sql = "SELECT msgType FROM message WHERE msgId = ?";
    $msgType = $db->select($sql, [$reportId])[0]['msgType'];

    if ($msgType != 7) {
        header("Location: reports.php");
        exit();
    }

    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['banUntil'])) {

        $sql = "SELECT inboxId, seen FROM inboxmessages WHERE msgId = ?";
        $result = $db->select($sql, [$reportId])[0];
        $reportedId = $result['inboxId'];
        $bannedFromReport = $result['seen'];

        $sql = "SELECT ban_until FROM users WHERE userID = ? AND ban_until > CURRENT_DATE()";
        $isBanned = $db->select($sql, [$reportedId]);

        if (!empty($isBanned) || $bannedFromReport) {
            header('Location: report.php?reportId=' . $reportId);
            exit();
        } 

        $banUntil = $_POST['banUntil'];

        $dateRegex = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';

        if (!preg_match($dateRegex, $banUntil)) {
            $errors[0] = "Датата не е във валиден формат, а именно yyyy-mm-dd!";
        }
        
        if (!isset($errors[0])) {
            list($year, $month, $day) = explode('-', $banUntil);
            if (!checkdate($month, $day, $year)) {
                $errors[] = "Датата не съществува!";
            } elseif ($banUntil < date("Y-m-d")) {
                $errors[] = "Не може да се забрани със задна дата!";
            }
        }
        
        if (empty($errors)) {
            $sql = "UPDATE users SET ban_until = ? WHERE userID = ?";
            $db->insert($sql, [$banUntil, $reportedId]);

            $sql = "UPDATE inboxmessages SET seen = 1 WHERE msgId = ?";
            $db->insert($sql, [$reportId]);
        }
    }

    $sql = "SELECT message.*, first_name, last_name, faculty_number FROM message INNER JOIN users ON message.senderId = users.userID WHERE msgId = ? AND msgType = 7";
    $report = $db->select($sql, [$reportId])[0];

    $sql = "SELECT inboxId, seen, first_name, last_name, faculty_number, ban_until FROM inboxmessages INNER JOIN users WHERE inboxmessages.msgId = ? AND users.userID = inboxmessages.inboxId";
    $reported  = $db->select($sql, [$reportId])[0];

    $report['reported'] = $reported;
?>