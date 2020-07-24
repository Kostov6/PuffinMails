<?php 
    function distributeRecensions($usersRec, $db) {
        $themes = array_map(function ($user) {
            return $user['number_theme'];
        }, $usersRec);

        for ($i = 0; $i < count($usersRec); ++$i) {
            
            $recIndex = rand(0, count($themes) - 1);
            while ($themes[$recIndex] == $usersRec[$i]['number_theme'] && $i < count($usersRec) - 1) {
                $recIndex = rand(0, count($themes) - 1);
            }

            if ($themes[$recIndex] == $usersRec[$i]['number_theme'] && $i == count($usersRec) - 1) {
                $userIndex = rand(0, count($usersRec) - 2);

                $usersRec[$i]['recension_number'] = $usersRec[$userIndex]['recension_number'];
                $usersRec[$userIndex]['recension_number'] = $themes[$recIndex];
            } else {
                $usersRec[$i]['recension_number'] = $themes[$recIndex];
            }

            unset($themes[$recIndex]);
            $themes = array_values($themes);
        }

        foreach ($usersRec as $user) {
            $recTheme = $user['recension_number'];

            $sql = "UPDATE users SET recension_number = ? WHERE userID = ?";
            $db->insert($sql, [$recTheme, $user['userID']]);
        }

        return $usersRec;
    }

    function sendRecensionMessages($senderId, $title, $message, $usersRec, $db) {
        foreach ($usersRec as $user) {
            $titleCurr = $title;
            $messageCurr = $message;

            $titleCurr = str_replace('$fn', $user['faculty_number'], $titleCurr);
            $titleCurr = str_replace('$name', $user['first_name'] . ' ' . $user['last_name'], $titleCurr);
            $titleCurr = str_replace('$rec', $user['recension_number'], $titleCurr);

            $messageCurr = str_replace('$fn', $user['faculty_number'], $messageCurr);
            $messageCurr = str_replace('$name', $user['first_name'] . ' ' . $user['last_name'], $messageCurr);
            $messageCurr = str_replace('$rec', $user['recension_number'], $messageCurr);

            sendMessage($senderId, $user['userID'], 5, $titleCurr, $messageCurr, $db);
        }
    }

    function startEvent($eventTitle, $endDate, $db) {
        $sql = "INSERT INTO events(event_title, end_date) VALUES (?, ?)";
        $db->insert($sql, [$eventTitle, $endDate]);
    }
?>