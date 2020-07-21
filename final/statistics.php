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
        <link rel="stylesheet" type="text/css" href="css/statistics.css">
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
                    <td class="title">Средна дължина на съобщение</td>
                    <td id="average_len" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Общ брой съобщения</td>
                    <td id="all_msg_count" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Брой неанонимни съобщения</td>
                    <td id="non_anon_count" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Брой съобщения от рецензии</td>
                    <td id="rec_msg_count" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Брой групови съобщения</td>
                    <td id="group_msg_count" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Процент на прочетени съобщения</td>
                    <td id="seen_percentage" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Най-комуникираща група</td>
                    <td id="most_msg_group" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Брой съобщения от най-комуникиращата група</td>
                    <td id="most_msg_for_group" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Тема получила най-много рецензии</td>
                    <td id="most_rec_theme" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Брой рецензии на най-рецензирана тема</td>
                    <td id="most_rec_for_theme" class="result"></td>
                </tr>
                <tr>
                    <td class="title">Потребител изпратил най-много съобщения</td>
                    <td id="user_most_msg" class="result"></td>
                </tr>
            </table>
        </main>
    </body>
    <div id="username" style="display:none"><?php echo $_SESSION["username"];?></div>
    <script type="text/javascript" src="js/contacts.js"></script>
</html>