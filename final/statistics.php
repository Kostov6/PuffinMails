<?php 
    require ('php/statisticsConn.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" type="text/css" href="css/nav.css">
        <link rel="stylesheet" type="text/css" href="css/inbox.css">
        <script type="text/javascript" defer>  
            var statistics = <?php echo json_encode($statistics); ?>;
        </script>
        <script type="text/javascript" src="js/displayStatistics.js"></script>
        <title>Статистики</title>
    </head>
    <body>
    <nav id="sidebar">
            <div>
                <a href="profile.php"><img id="profile" width="70" src="photo/profile.png"></a>
                <a href="send.php" class="pages">Напиши</a>
                <a href="inbox.php?filter=all" class="pages">Кутия</a>
                <a href="inbox.php?filter=group" class="pages">Група</a>
                <a href="inbox.php?filter=sent" class="pages">Изпратени</a>
                <a href="inbox.php?filter=draft" class="pages">Чернови</a>
                
                <div class="control_panel">
                    <div class="control_panel_field">
                        <p id="contact_options">Контакти</p>
                    </div>
                    <div id="contact_members"></div>
                </div>

                <a href="statistics.php" class="selected admin">Статистики</a>
                <a href="recensions.php" class="pages admin">Рецензии</a>
                <a href="reports.php" class="pages admin">Докладвания</a>
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
    <div id="username" style="display:none"><?php echo $_SESSION["username"];?></div>
    <script type="text/javascript" src="js/contacts.js"></script>
</html>