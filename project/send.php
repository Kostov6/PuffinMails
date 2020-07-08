<!DOCTYPE html>
<?php
	session_start();
	$showSendAllButton = false;
	if(!isset($_SESSION['logged'])) {
		header("Location: login.php");
	}
	else if ($_SESSION['is_admin'] == 1) {
		$showSendAllButton = true;
	}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/send.css">
		<link rel="stylesheet" type="text/css" href="css/nav.css">
		<script> 
            window.onload = function () {
				if (false) {
					document.getElementById('event').innerText = "hello";
				}
                if (<?php echo $showSendAllButton; ?>) {
                    var spot = document.getElementById('options');

                    var btn = document.createElement('input');
                    btn.setAttribute('type','submit');
                    btn.setAttribute('class','opt');
					btn.setAttribute('name','sendAll');
                    btn.setAttribute('value','Изпрати до всички');

                    spot.appendChild(btn);
                }
            }
        </script>
    </head>
    <body>
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
			<div id="event">
			</div>
            <form id="form" method="POST" enctype="multipart/form-data" action="">
                <div id="info">
                    <div class="infoS">До:</div> <input class="infoT" type="text" name="to" value="<?php if (isset($_POST['to'])) echo $_POST['to']; ?>"><br>
                    <div class="infoS">Тема:</div> <input class="infoT" type="text" name="object" value="<?php if (isset($_POST['object'])) echo $_POST['object']; ?>"><br>
                </div>
                <div id="options">
                    <input type="submit" class="opt" name="submit" value="Изпрати">
                    <input type="submit" class="opt" name="draft" value="Запази в чернови">
					<input type="submit" class="opt" name="anonySubmit" value="Анонимно изпращане">
                    
                </div>
                <textarea id="message" name="message" wrap="hard"><?php if (isset($_POST['message'])) echo $_POST['message']; ?></textarea>
            </form>
            <div id="error">
                <?php
                    require_once('php/sendIt.php');
                    if ($_POST && $error != "") {
                        echo $error;
                        $error = "";
                    }
                ?>
            </div>
        </main>
    </body>
</html>