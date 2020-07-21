<?php
    require ('authorization.php');

    require ('db.php');
    require ('sendMessage.php');
    require ('recensionActions.php');
    $db = new Db('webproject','');

    $userId = $_SESSION['userID'];

    $sql = "SELECT * FROM events WHERE end_date > CURRENT_DATE()";
    $events = $db->select($sql,[]);

    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

        if (empty($events)) {
            $sql = "SELECT userID, number_theme, recension_number FROM users WHERE is_admin = 0";
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
            
            if (empty($errors)) { //TODO TEST
                $usersRec = distributeRecensions($usersRec, $db);
                sendRecensionMessages($userId, $usersRec, $db);  
                startEvent('Рецензии', $endDate, $db);

                $sql = "SELECT * FROM events WHERE end_date > CURRENT_DATE()";
                $events = $db->select($sql,[]);
            }
        }
    }

    $sql = "SELECT first_name, last_name, faculty_number, number_theme, recension_number FROM users WHERE is_admin = 0 AND number_theme IS NOT NULL";
    $users = $db->select($sql, []);
?>