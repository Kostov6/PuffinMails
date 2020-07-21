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
                <label for="end_date">Краен срок:</label>
                <input type="date" name="end_date" id="end_date" required>
                <input id="submit" type="submit" name="submit" value="Разпредели рецензии">
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
        </main>
    </body>
    <div id="username" style="display:none"><?php echo $_SESSION["username"];?></div>
    <script type="text/javascript" src="js/contacts.js"></script>
</html>