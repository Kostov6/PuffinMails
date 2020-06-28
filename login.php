<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <title>login</title>
</head>

<body>
    <div id="cont">
        <img src="photo/mail.png" alt="mail">
        <div class="forms">
            <form id="form" method="POST" enctype="multipart/form-data" action="php/valid.php">
                <div id="formTitle"><b>Вътрешна поща на Puffin</b></div>
                <input class="regInputs" type="text" name="name" placeholder="Потребителско име">
                <input class="regInputs" type="password" name="password" placeholder="Парола">
                <input class="regInputs" type="number" name="fn" placeholder="Факултетен номер">
                <div id="error">
                    <?php
                        require_once('php/valid.php');
                        if ($_POST && $error != "") {
                            echo $error;
                        }
                    ?>
                </div>
                <input type="submit" id="submit" value="Вход">
            </form>
        </div>
    </div>
</body>

</html>