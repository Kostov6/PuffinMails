<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/success.css">
		<link rel="stylesheet" type="text/css" href="css/nav.css">
    </head>
    <body>
        <?php
            session_start();
            if(!isset($_SESSION['logged'])) {
                header("Location: login.php");
            }
        ?>
        <nav id="sidebar">
			<a href="profile.php"><img id="profile" width="70" src="photo/profile.png"></img></a>
            <div>
				<a href="send.php">Напиши</a>
                <a href="#">Кутия</a>
                <a href="#">Група</a>
                <a href="#">Изпратени</a>
                <a href="#">Чернови</a>
                <a href="#">Контакти</a>
            </div>
        </nav>
        <main>
            <div id="success">
                <?php
					if (isset($_SESSION['last'])) {
                        echo "Успешно изпратено глобално съобщение!";
                    }
                    else if (strlen($_SESSION['to']) < 4) {
                        echo "Съобщението бе успешно изпратено до потребител с тема номер ".$_SESSION['to'];
                    }
                    else {
                        echo "Съобщението бе успешно изпратено до потребител с име ".$_SESSION['to'];
                    }
                ?>
            </div>
        </main>
    </body>
</html>