<?php
    require ('authorization.php');

    require ('../backend/inbox/common/db.php');
    require ('sendMessage.php');
    require ('recensionActions.php');
    $db = new Db();

    $userId = $_SESSION['userID'];

    $sql = "SELECT * FROM events WHERE end_date > CURRENT_DATE()";
    $events = $db->select($sql,[]);

    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

        if (empty($events)) {
            $sql = "SELECT userID, first_name, last_name, faculty_number, number_theme, recension_number FROM users WHERE is_admin = 0";
            $usersRec = $db->select($sql, []);

            $endDate = $_POST['end_date'];

            $dateRegex = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';

            if (!preg_match($dateRegex, $endDate)) {
                $errors[0] = "Датата не е във валиден формат, а именно yyyy-mm-dd!";
            }
            
            if (!isset($errors[0])) {
                list($year, $month, $day) = explode('-', $endDate);
                if (!checkdate($month, $day, $year)) {
                    $errors[] = "Датата не съществува!";
                } elseif ($endDate < date("Y-m-d")) {
                    $errors[] = "Крайния срок не може да в миналото!";
                }
            }

            $title = $_POST['title'];
            $message = $_POST['message'];

            if (mb_strlen($title, 'UTF-8') == 0 || mb_strlen($title, 'UTF-8') > 128) {
                $errors[] = "Моля въведете заглавие между 1 и 128 символа!";
            }

            if (mb_strlen($message, 'UTF-8') == 0 || mb_strlen($message, 'UTF-8') > 128) {
                $errors[] = "Моля въведете съобщение между 1 и 2048 символа!";
            }
            
            if (empty($errors)) { 
                $usersRec = distributeRecensions($usersRec, $db);
                sendRecensionMessages($userId, $title, $message, $usersRec, $db); 
                startEvent('Рецензии', $endDate, $db);

                $sql = "SELECT * FROM events WHERE end_date > CURRENT_DATE()";
                $events = $db->select($sql,[]);
            }
        }
    }

    $sql = "SELECT first_name, last_name, faculty_number, number_theme, recension_number FROM users WHERE is_admin = 0 AND number_theme IS NOT NULL";
    $users = $db->select($sql, []);
?>