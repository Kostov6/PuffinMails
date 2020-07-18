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

    function sendRecensionMessages($senderId, $usersRec, $db) {
        foreach ($usersRec as $user) {
            $title = "Рецензия";
            $message = "Имате да направите рецензия на тема №" . $user['recension_number'];
            sendMessage($senderId, $user['userID'], 0, $title, $message, $db);
        }
    }

    function startEvent($eventTitle, $endDate, $db) {
        $sql = "INSERT INTO events(event_title, end_date) VALUES (?, ?)";
        $db->insert($sql, [$eventTitle, $endDate]);
    }
?>