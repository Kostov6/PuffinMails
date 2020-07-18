<?php 
    require ('php/statisticsConn.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/sidebar.css">
        <link rel="stylesheet" type="text/css" href="css/send.css">
        <script type="text/javascript" defer>  
            var statistics = <?php echo json_encode($statistics); ?>;
        </script>
        <script type="text/javascript" src="js/displayStatistics.js"></script>
        <title>Статистики</title>
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

                <a href="statistics.php" class="selected">Статистики</a>
                <a href="recensions.php" class="pages">Рецензии</a>
                <a href="reports.php" class="pages">Докладвания</a>
            </div>
        </nav>
        <main>
            <h3>Статистики</h3>
            <table id="statistics">
                <tr>
                    <td>Заглавие</td>
                    <td>Резултат</td>
                </tr>
                <tr>
                    <td>Средна дължина на съобщение</td>
                    <td id="average_len"></td>
                </tr>
                <tr>
                    <td>Общ брой съобщения</td>
                    <td id="all_msg_count"></td>
                </tr>
                <tr>
                    <td>Брой неанонимни съобщения</td>
                    <td id="non_anon_count"></td>
                </tr>
                <tr>
                    <td>Брой съобщения от рецензии</td>
                    <td id="rec_msg_count"></td>
                </tr>
                <tr>
                    <td>Брой групови съобщения</td>
                    <td id="group_msg_count"></td>
                </tr>
                <tr>
                    <td>Процент на прочетени съобщения</td>
                    <td id="seen_percentage"></td>
                </tr>
            </table>
        </main>
    </body>
    <script type="text/javascript" src="js/contacts.js"></script>
</html>