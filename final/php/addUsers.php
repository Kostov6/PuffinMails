<?php
    require ('authorization.php');
    require ('../../backend/inbox/common/db.php');

    $db = new Db();

    if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])) {
        header('Location: ../recensions.php');
        exit();
    }

    $strJsonFileContents = file_get_contents($_FILES['file']['tmp_name']);
    $users = json_decode($strJsonFileContents);

    print_r($users);

    foreach ($users as $user) {
        $sql = "INSERT INTO users(username, password_hash, first_name, last_name, faculty_number, number_theme) VALUES (?, ?, ?, ?, ?, ?)";
        $db->insert($sql, $user);

        $sql = "SELECT userID FROM users WHERE username = ?";
        $userId = $db->select($sql, [$user[0]/*username*/])[0]['userID'];

        $sql = "INSERT INTO inbox (inboxId, ownerId) VALUES (?, ?)";
        $db->insert($sql, [$userId, $userId]);
    }

    header('Location: ../recensions.php');
?>