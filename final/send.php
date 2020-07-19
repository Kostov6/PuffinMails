<!DOCTYPE html>

<html>
<?php
    session_start();
    require_once('php/sendIt.php');
	$showAdminOptions = 0;
	if(!isset($_SESSION['logged'])) {
        header("Location: login.php");
        exit();
	}
	else if ($_SESSION['is_admin'] == 1) {
		$showAdminOptions = 1;
	}
?>
    <head>
        <meta charset="UTF-8">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" type="text/css" href="css/send.css">
        <link rel="stylesheet" type="text/css" href="css/nav.css">
        <link rel="stylesheet" type="text/css" href="css/inbox.css">
		<script>
            
            window.onload = function () {
                var showAdminOptions = <?php echo $showAdminOptions; ?>

                if (<?php echo (isset($_SESSION['end']) && $_SESSION['is_admin'] == 0)?'true':'false'; ?>) {
                    document.getElementById('anony').style.display = "inline-block";
                    if (<?php echo (isset($_SESSION['sent']) && $_SESSION['sent'] == false)?'true':'false';?>) {
                        document.getElementById('event').style.display = "block";
                    }
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
			
		    var elements = document.getElementsByClassName('no_admin');

                    for (var i = 0; i < elements.length; ++i) {
                        elements[i].setAttribute('class', 'pages no_admin hidden');
                    }
			
                } else {
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
            <div>
                <a href="profile.php"><img id="profile" width="70" src="photo/profile.png"></img></a>
                <a href="send.php" class="selected">Напиши</a>
                <a href="inbox.php?filter=all" class="pages">Кутия</a>
                <a href="inbox.php?filter=sent" class="pages">Изпратени</a>
                <a href="inbox.php?filter=group" class="pages no_admin">Групови съобщения</a>
                <a href="inbox.php?filter=draft" class="pages">Чернови</a>
                <a href="inbox.php?filter=lecturer" class="pages no_admin">От лектора</a>

                <div class="control_panel">
                    <div class="control_panel_field">
                        <p id="contact_options">Контакти</p>
                    </div>
                    <div id="contact_members"></div>
                </div>

                <div class="control_panel">
                    <div id="group_options" class="control_panel_field" onclick="window.location.assign('inbox.php?filter=groupOptions')">
                        <p>Група</p>
                    </div>
                    <div id="group_members"></div>
                </div>

                <a href="statistics.php" class="pages admin">Статистики</a>
                <a href="recensions.php" class="pages admin">Рецензии</a>
                <a href="reports.php" class="pages admin">Докладвания</a>
            </div>
        </nav>
        <main>
			<div id="event">
                <?php
                    echo "Направете рецензия на тема ".$_SESSION['recension_number']." и я изпратете анонимно до ".$_SESSION["end"]; 
                ?>
			</div>
            <form id="form" method="POST" enctype="multipart/form-data" action="">
                <div id="info">
                    <div class="infoS">До:</div> <input class="infoT" id="to" type="text" name="to" value="<?php if(isset($_GET['to'])) echo $_GET['to']; elseif (isset($_POST['to'])) echo $_POST['to']; ?>"><br>
                    <div class="infoS">Относно:</div> <input class="infoT" type="text" name="object" value="<?php if(isset($_GET['title'])) echo $_GET['title']; if (isset($_POST['object'])) echo $_POST['object']; ?>"><br>
                </div>
                <div id="options">
                    <input type="submit" class="opt" name="submit" value="Изпрати">
                    <input type="submit" class="opt" name="draft" value="Запази в чернови">
					<input type="submit" id="anony" class="opt hidden" name="anonySubmit" value="Анонимно изпращане">
                    <input type="submit" id="group" class="opt hidden" name="sendGroup" value="Групово изпращане">
                </div>
                <textarea id="message" name="message" wrap="hard"><?php if(isset($_GET['content'])) echo $_GET['content']; if (isset($_POST['message'])) echo $_POST['message']; ?></textarea>
            </form>
            <div id="error">
                <?php
                    if ($_POST && $error != "") {
                        echo $error;
                    }
                ?>
            </div>
        </main>
    </body>
    <div id="username" style="display:none"><?php echo $_SESSION["username"];?></div>
    <script src="js/contacts.js"></script>
    <script src="js/groupSidebar.js"></script>
</html>
