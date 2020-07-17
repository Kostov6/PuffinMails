<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $fn = $_POST['fn'];
    $password = $_POST['password'];
    $error = "";

    $conn = new PDO("mysql:host=localhost:3306;dbname=webproject", "root", "");
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name]);
    $row = $stmt->fetch();

    if ($row[0] == 0) {
        $error = "Грешно потребителско име!";
    }
    else if (password_verify($password, $row['password_hash'])) {
        if ($fn == $row['faculty_number']) {
            session_start();
            $_SESSION=$row;
            $_SESSION['logged'] = true;
            "SELECT  FROM message WHERE senderId = ?";
            $sql = "SELECT * FROM events WHERE end_date > CURRENT_DATE()";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row) {
                $_SESSION['end'] = $row['end_date'];
            }
            header('Location: send.php');
        } else {
            $error = "Грешен факултетен номер!";
        }
    } else {
        $error = "Грешна парола!";
    }
}
