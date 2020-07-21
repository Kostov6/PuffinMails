<?php require ('php/reportsLoad.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" type="text/css" href="css/nav.css">
        <link rel="stylesheet" type="text/css" href="css/inbox.css">
        <link rel="stylesheet" type="text/css" href="css/reports.css">
        <script type="text/javascript" defer>  
            var reports = <?php echo json_encode($reports); ?>;
            var bannedUsers = <?php echo json_encode($bannedUsers); ?>;
        </script>
        <script type="text/javascript" src="js/reportsDisplay.js"></script>
        <title>Докладвания</title>
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
                <a href="recensions.php" class="pages admin">Рецензии</a>
                <a href="reports.php" class="selected admin">Докладвания</a>
            </div>
        </nav>
        <main>
            <h3>Забрани</h3>
            <table id="bans">
                <tr class="titles">
                    <td>Име</td>
                    <td>Факултетен номер</td>
                    <td>Забранa до</td>
                    <td>Премахни забрана</td>
                </tr>
            </table>
            <h3>Докладвания</h3>
            <table id="reports">
                <tr class="titles">
                    <td>Докладвал</td>
                    <td>Докладван</td>
                    <td>Време на изпращане</td>
                </tr>
            </table>
        </main>
    </body>
    <div id="username" style="display:none"><?php echo $_SESSION["username"];?></div>
    <script type="text/javascript" src="js/contacts.js"></script>
</html>