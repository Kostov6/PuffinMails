<?php require ('php/reportConn.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" type="text/css" href="css/nav.css">
        <link rel="stylesheet" type="text/css" href="css/inbox.css">
        <link rel="stylesheet" type="text/css" href="css/report.css">
        <script type="text/javascript">
            var errors = <?php echo json_encode($errors); ?>;
            var report = <?php echo json_encode($report); ?>;

        </script>
        <script type="text/javascript" src="js/reportDisplay.js"></script>
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
            <form method="post" action="" id="ban" onsubmit="return validate();">
                <label for="banUntil">Забрани изпращане до:</label>
                <input name="banUntil" type="date" id="ban_date">
                <input type="submit" value="Забрани изпращане">
                <div id="date_error" class="error"></div>
            </form>
            <div id="ban_info">
            </div>
        </main>
    </body>
    <div id="username" style="display:none"><?php echo $_SESSION["username"];?></div>
    <script type="text/javascript" src="js/contacts.js"></script>
</html>