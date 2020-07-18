<?php require ('php/reportConn.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/sidebar.css">
        <link rel="stylesheet" type="text/css" href="css/send.css">
        <script type="text/javascript">
            var errors = <?php echo json_encode($errors); ?>;
            var report = <?php echo json_encode($report); ?>;

        </script>
        <script type="text/javascript" src="js/reportDisplay.js"></script>
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
            <form method="post" action="" id="ban" onsubmit="return validate();">
                <label for="banUntil">Забрани изпращане до:</label>
                <input name="banUntil" type="date" id="ban_date">
                <input type="submit" value="Забрани изпращане!">
                <div id="date_error" class="error"></div>
            </form>
            <div id="ban_info">
            </div>
        </main>
    </body>
    <script type="text/javascript" src="js/contacts.js"></script>
</html>