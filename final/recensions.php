<?php require ('php/recensionsConn.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" type="text/css" href="css/nav.css">
        
        <link rel="stylesheet" type="text/css" href="css/inbox.css">
        
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
                <a href="recensions.php" class="selected">Рецензии</a>
                <a href="reports.php" class="pages">Докладвания</a>
            </div>
        </nav>
        <main>
            <h3>Рецензии</h3>
            <form method="POST" action="" id="add_event" onsubmit="return validate();">
                <label for="end_date">Краен срок:</label>
                <input type="date" name="end_date" id="end_date" required>
                <input type="submit" name="submit" value="Разпредели рецензии!">
                <div id="date_error" class="error"></div>
            </form>
            <table id="events" class="hidden">
                <tr>
                    <td>Краен срок</td>
                </tr>
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