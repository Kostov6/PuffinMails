<!DOCTYPE html>
<?php
	session_start();
	if(!isset($_SESSION['logged'])) {
		header("Location: login.php");
	}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/nav.css">
		<link rel="stylesheet" type="text/css" href="css/profile.css">
		<script> 
            window.onload = function () {

                if (<?php echo (isset($_SESSION['end']) && $_SESSION['is_admin'] == 0)?'true':'false'; ?>) {
                    document.getElementById('event').style.display = "block";
				}
				if (<?php echo $_SESSION['is_admin']; ?> == 0) {
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
      <div>
        <a href="send.php">Напиши</a>
        <div class="control_panel">
          <div onclick="showInbox('')" class="control_panel_field">
            <p>Кутия</p>
          </div>
          <div onclick="showInbox('send')"  class="control_panel_field">
            <p>Изпратени</p>
          </div>
          <div onclick="showInbox(4)" class="control_panel_field">
            <p>Групови съобщения</p>
          </div>
          <div onclick="showInbox(6)" class="control_panel_field">
            <p>Чернови</p>
          </div>
          <div onclick="showInbox(5)" class="control_panel_field">
            <p>От Лектора</p>
          </div>
        </div>

        <div class="control_panel">
          <div class="control_panel_field">
            <p id="contact_options">Контакти</p>
          </div>
          <div id="contact_members"></div>
        </div>

        <div class="control_panel">
          <div id="group_options" class="control_panel_field">
            <p>Група</p>
          </div>
          <div id="group_members"></div>
        </div>
      </div>
        </nav>
        </nav>
        <main>
		<div id="event">
                <?php
                    echo "Направете рецензия на тема ".$_SESSION['recension_number']." и я изпратете анонимно до ".$_SESSION["end"]; 
                ?>
			</div>
			<div id="cont">
				<h3>Потребителска информация:</h3>
				<table>
					<tr>
						<td>Потребителско име</td>
						<td class="right"><?php echo $_SESSION['username']; ?></td>
					</tr>
					<tr>
						<td>Име и фамилия</td>
						<td class="right"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></td>
					</tr>
					<?php
						if($_SESSION['is_admin'] == 0) {
							$rec = (isset($_SESSION['recension_number']))?$_SESSION['recension_number']:'Не са разпределени!';
							echo "<tr>
								<td>Факултетен номер</td>
								<td class='right'>".$_SESSION['faculty_number']."</td>
							</tr>
							<tr>
								<td>Номер на избрана тема</td>
								<td class='right'>".$_SESSION['number_theme']."</td>
							</tr>
							<tr>
								<td>Номер на тема за рецензия</td>
								<td class='right'>".$rec."</td>
							</tr>";
						}
						if(isset($_SESSION['ban_until']) && ($_SESSION['ban_until']) >= date("Y-m-d")) {
						echo "<tr>
								<td>Баннат до</td>
								<td class='right'>".$_SESSION['ban_until']."</td>
							</tr>";
						}
					?>
				</table>
				<h3>Статистика:</h3>
				<table>
					<tr>
						<td>Брой изпратени съобщения:</td>
						<td class="right">
							<?php 
								$conn = new PDO("mysql:host=localhost:3306;dbname=webproject", "root", "");
								$sql = "SELECT * FROM message WHERE senderId = ? and msgType < 6";
    							$stmt = $conn->prepare($sql);
								$stmt->execute([$_SESSION['userID']]);
								$row = $stmt->fetchAll();
								$num = 0;
								$len = 0;
								foreach ($row as $row) {
									$num = $num + 1;
									if ($len < strlen($row['content'])) {
										$len = strlen($row['content']);
									}
								}
								echo $num;
							?>
						</td>
					</tr>
					<tr>
						<td>Брой получени съобщения:</td>
						<td class="right">
							<?php 
								$sql = "SELECT *
										FROM message INNER JOIN inboxmessages ON message.msgId = inboxmessages.msgId
										WHERE inboxId = ? and msgType < 6";
    							$stmt = $conn->prepare($sql);
								$stmt->execute([$_SESSION['userID']]);
								$row = $stmt->fetchAll();
								$num = 0;
								$len2 = 0;
								foreach ($row as $row) {
									$num = $num + 1;
									if ($len2 < strlen($row['content'])) {
										$len2 = strlen($row['content']);
									}
								}
								echo $num;
							?>
						</td>
					</tr>
					<tr>
						<td>Най-дълго съобщение:</td>
						<td class="right">
							<?php 
								echo $len." символа";
							?></td>
					</tr>
					<tr>
						<td>Най-дълго получено съобщение:</td>
						<td class="right">
							<?php 
								echo $len2." символа";
							?></td>
					</tr>
				<table>
				<form method="POST" action="php/logout.php">
					<input type="submit" id="submit" value="Изход">
				</form>
			</div>
        </main>
	</body>
  <script src="js/contacts.js"></script>
  <script src="js/group.js"></script>
  <script src="js/message.js"></script>
  <script src="js/report.js"></script>
</html>