<!DOCTYPE html>
<?php
	session_start();
	$showAdminOptions = 0;
	if(!isset($_SESSION['logged'])) {
		header("Location: login.php");
	}
	else if ($_SESSION['is_admin'] == 1) {
		$showAdminOptions = 1;
	}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/send.css">
		<link rel="stylesheet" type="text/css" href="css/nav.css">
		<script>
            
            window.onload = function () {
                var showAdminOptions = <?php echo $showAdminOptions; ?>

                if (<?php echo (isset($_SESSION['end']) && $_SESSION['is_admin'] == 0)?'true':'false'; ?>) {
                    document.getElementById('event').style.display = "block";
                    document.getElementById('anony').style.display = "inline-block";
                }

                if (<?php echo isset($_SESSION['member_of'])?'true':'false'; ?>) {
                    document.getElementById('group').style.display = "inline-block";
                }
				
                if (showAdminOptions) {
                    var spot = document.getElementById('options');

                    var btn = document.createElement('input');
                    btn.setAttribute('type','submit');
                    btn.setAttribute('class','opt');
					btn.setAttribute('name','sendAll');
                    btn.setAttribute('value','Изпрати до всички');

                    spot.appendChild(btn);
                }
                else {
                    var elements = document.getElementsByClassName('admin');

                    for (var i = 0; i < elements.length; ++i) {
                        elements[i].setAttribute('class', 'pages admin hidden');
                    }
                }
            }
        </script>
    </head>
    <body>
        <nav id="sidebar">
			<a href="profile.php"><img id="profile" width="70" src="photo/profile.png"></img></a>
            <a href="send.php" class="selected">Напиши</a>
            <a href="inbox.php" class="pages">Кутия</a>
            <a href="#" class="pages">Група</a>
            <a href="#" class="pages">Изпратени</a>
            <a href="#" class="pages">Чернови</a>
            <a href="#" class="pages">Контакти</a>
            <a href="statistics.php" class="pages admin">Статистики</a>
            <a href="recensions.php" class="pages admin">Рецензии</a>
            <a href="reports.php" class="pages admin">Докладвания</a>
        </nav>
        <main>
			<div id="event">
                <?php
                    echo "Направете рецензия на тема ".$_SESSION['recension_number']." и я изпратете анонимно до ".$_SESSION["end"]; 
                ?>
			</div>
            <form id="form" method="POST" enctype="multipart/form-data" action="">
                <div id="info">
                    <div class="infoS">До:</div> <input class="infoT" type="text" name="to" value="<?php if (isset($_POST['to'])) echo $_POST['to']; ?>"><br>
                    <div class="infoS">Тема:</div> <input class="infoT" type="text" name="object" value="<?php if (isset($_POST['object'])) echo $_POST['object']; ?>"><br>
                </div>
                <div id="options">
                    <input type="submit" class="opt" name="submit" value="Изпрати">
                    <input type="submit" class="opt" name="draft" value="Запази в чернови">
					<input type="submit" id="anony" class="opt hidden" name="anonySubmit" value="Анонимно изпращане">
                    <input type="submit" id="group" class="opt hidden" name="sendGroup" value="Групово изпращане">
                    
                </div>
                <textarea id="message" name="message" wrap="hard"><?php if (isset($_POST['message'])) echo $_POST['message']; ?></textarea>
            </form>
            <div id="error">
                <?php
                    require_once('php/sendIt.php');
                    if ($_POST && $error != "") {
                        echo $error;
                    }
                ?>
            </div>
        </main>
    </body>
</html>