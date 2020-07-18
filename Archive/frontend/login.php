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
            <form id="form" method="POST" enctype="multipart/form-data" action="">
                <div id="formTitle"><b>Вътрешна поща на Puffin</b></div>
                <input class="regInputs" type="text" name="name" placeholder="Потребителско име" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>">
                <input class="regInputs" type="password" name="password" placeholder="Парола" >
                <input class="regInputs" type="number" name="fn" placeholder="Факултетен номер" value="<?php if (isset($_POST['fn'])) echo $_POST['fn']; ?>">
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