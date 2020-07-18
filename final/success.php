<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION['logged'])) {
        header("Location: login.php");
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/success.css">
        <link rel="stylesheet" type="text/css" href="css/nav.css">
        <script>
            
            window.onload = function () {
                if (<?php echo ($_SESSION['is_admin'] == 0)?'true':'false'; ?>) {
                    var elements = document.getElementsByClassName('admin');

                    for (var i = 0; i < elements.length; ++i) {
                        elements[i].setAttribute('class', 'pages admin hidden');
                    }
                }
            }
        </script>
    </head>
    <body>
        <nav id="sidebar">
            <div>
                <a href="profile.php"><img id="profile" width="70" src="photo/profile.png"></img></a>
                <a href="send.php" class="selected">Напиши</a>
                <a href="inbox.php?filter=all" class="pages">Кутия</a>
                <a href="inbox.php?filter=group" class="pages">Група</a>
                <a href="inbox.php?filter=sent" class="pages">Изпратени</a>
                <a href="inbox.php?filter=draft" class="pages">Чернови</a>
                <a href="inbox.php?filter=lecturer" class="pages">От лектора</a>

                <div class="control_panel">
                    <div class="control_panel_field">
                        <p id="contact_options">Контакти</p>
                    </div>
                    <div id="contact_members"></div>
                </div>

                <div class="control_panel">
                    <div id="group_options" class="control_panel_field">
                        <p>Група</p>
                    </div>
                    <div id="group_members"></div>
                </div>

                <a href="statistics.php" class="pages admin">Статистики</a>
                <a href="recensions.php" class="pages admin">Рецензии</a>
                <a href="reports.php" class="pages admin">Докладвания</a>
            </div>
        </nav>
        <main>
            <div id="success">
                <?php
					if (!isset($_GET['to'])) {
                        header("Location: send.php");
                        return;
                    }
                    $to = $_GET['to'];
                    if ($to == "sendGroup") {
                        echo "Съобщението бе успешно изпратено на вашата група!";
                    }
                    elseif ($to == "sendAll") {
                        echo "Съобщението бе успешно изпратено на всички потребители!";
                    }
                    elseif (strlen($to) < 4) {
                        echo "Съобщението бе успешно изпратено до потребител с тема номер ".$to."!";
                    }
                    else {
                        echo "Съобщението бе успешно изпратено до потребител с име ".$to."! ";
                        $conn = new PDO("mysql:host=localhost:3306;dbname=webproject", "root", "");
                        $sql = "SELECT userID FROM users WHERE username = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$to]);
                        $row = $stmt->fetch();

                        if ($_SESSION['userID'] == $row['userID']) {
                            return;
                        }

                        $sql = "SELECT * FROM contactlist WHERE userid = ? and contactid = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$_SESSION['userID'], $row['userID']]);
                        $row = $stmt->fetch();

                        if (!$row) {
                            echo "<input onclick='addContact(\"".$to."\")' type='image' id='submit'src='photo/add.png' border='0' alt='Submit'>";
                        }
                    }
                ?>
            </div>
        </main>
    </body>
    <div id="username" style="display:none"><?php echo $_SESSION["username"];?></div>
    <script src="js/contacts.js"></script>
</html>