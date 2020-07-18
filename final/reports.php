<?php require ('php/reportsLoad.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/sidebar.css">
        <link rel="stylesheet" type="text/css" href="css/send.css">
        <script type="text/javascript" defer>  
            var reports = <?php echo json_encode($reports); ?>;
            var bannedUsers = <?php echo json_encode($bannedUsers); ?>;
        </script>
        <script type="text/javascript" src="js/reportsDisplay.js"></script>
        <title>Докладвания</title>
    </head>
    <body>
        <nav id="sidebar">
            <a href="profile.php"><img id="profile" width="70" src="photo/profile.png"></img></a>
            <div>
                <a href="send.php" class="pages">Напиши</a>
                <div class="control_panel">
                    <div onclick="showInbox('')" class="control_panel_field">
                        <p>Кутия</p>
                    </div>
                    <div onclick="showInbox('send')"  class="control_panel_field">
                        <p>Изпратени</p>
                    </div>
                    <div onclick="showInbox(6)" class="control_panel_field">
                        <p>Чернови</p>
                    </div>
                </div>

                <div class="control_panel">
                    <div class="control_panel_field">
                        <p id="contact_options">Контакти</p>
                    </div>
                    <div id="contact_members"></div>
                </div>

                <a href="statistics.php" class="pages">Статистики</a>
                <a href="recensions.php" class="pages">Рецензии</a>
                <a href="reports.php" class="selected">Докладвания</a>
            </div>
        </nav>
        <main>
            <h3>Докладвания</h3>
            <table id="reports">
                <tr>
                    <td>Докладвал</td>
                    <td>Докладван</td>
                    <td>Време на изпращане</td>
                </tr>
            </table>
            <h3>Забрани</h3>
            <table id="bans">
                <tr>
                    <td>Име</td>
                    <td>Факултетен номер</td>
                    <td>Забранено изпращане до</td>
                    <td></td>
                </tr>
            </table>
        </main>
    </body>
    <script type="text/javascript" src="js/contacts.js"></script>
</html>