<?php require ('php/recensionsConn.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" type="text/css" href="css/nav.css">
        <link rel="stylesheet" type="text/css" href="css/inbox.css">
        <link rel="stylesheet" type="text/css" href="css/recensions.css">
        <script type="text/javascript" defer>
            var users = <?php echo json_encode($users); ?>;
            var events = <?php echo json_encode($events); ?>;
            var errors = <?php echo json_encode($errors); ?>;
        </script>
        <script type="text/javascript" src="js/recensionsDisplay.js"></script> 
        <title>Рецензии</title>
    </head>
    <body>
    <nav id="sidebar">
            <div>
                <a href="profile.php"><img id="profile" width="70" src="photo/profile.png"></a>
                <a href="send.php" class="pages">Напиши</a>
                <a href="inbox.php?filter=all" class="pages">Кутия</a>
                <a href="inbox.php?filter=sent" class="pages">Изпратени</a>
                <a href="inbox.php?filter=draft" class="pages">Чернови</a>

                <div class="control_panel">
                    <div class="control_panel_field">
                        <p id="contact_options">Контакти</p>
                    </div>
                    <div id="contact_members"></div>
                </div>

                <a href="statistics.php" class="pages admin">Статистики</a>
                <a href="recensions.php" class="selected admin">Рецензии</a>
                <a href="reports.php" class="pages admin">Докладвания</a>
            </div>
        </nav>
        <main>
            <h3>Рецензии</h3>
            <form method="POST" action="" id="add_event" onsubmit="return validate();">
                <input type="text" name="title" id="title" placeholder="Заглавие на съобщението" required>
                <textarea id="message" name="message" placeholder="Съобщение до рецензентите" required></textarea>
                <div id="menu">
                    <div>
                        <label for="end_date">Краен срок:</label>
                        <input type="date" name="end_date" id="end_date" required>
                        <input id="submit" type="submit" name="submit" value="Разпредели рецензии">
                    </div>
                    <div id="legend">
                        <div>В заглавието и съобщението може да използвате </br> следните променливите:</div>
                        <div><b>$name</b> - Име на рецензента</div>
                        <div><b>$fn</b> - Факултетен номер на рецензента</div>
                        <div><b>$rec</b> - Номер на тема за рецензия</div>
                    </div>
                </div>
                <div id="date_error" class="error"></div>
            </form>
            <table id="events" class="hidden">
            </table>
            <table id="recensions">
                <tr>
                    <td>Име</td>
                    <td>Факултетен номер</td>
                    <td>Номер на тема</td>
                    <td>Номер на рецензия</td>
                </tr>
            </table>
            <h3>Добавяне на потребители</h3>
            <form method="POST" action="php/addUsers.php" enctype="multipart/form-data"> 
                <p>Добавете файл в json формат съдържащ масив от потребителите във формат: <div>[[потребителско име, хеш на паролата, първо име, фамилно име, факултетен номер, номер на тема], ...]</div></p>
                <input type="file" name="file" id="file">
                <input id="add_users" type="submit" name="add_users" value="Добави потребители">
            </form>
        </main>
    </body>
    <div id="username" style="display:none"><?php echo $_SESSION["username"];?></div>
    <script type="text/javascript" src="js/contacts.js"></script>
</html>