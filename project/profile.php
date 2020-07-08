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
			<div id="cont">
				<h3>Потребителска информация:</h2>
				<table>
					<tr>
						<td>Потребителско име</td>
						<td class="right"><?php echo $_SESSION['username']; ?></td>
					</tr>
					<tr>
						<td>Име и фамилия</td>
						<td class="right"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></td>
					</tr>
					<tr>
						<td>Факултетен номер</td>
						<td class="right"><?php echo $_SESSION['faculty_number']; ?></td>
					</tr>
					<tr>
						<td>Номер на избрана тема</td>
						<td class="right"><?php echo $_SESSION['number_theme']; ?></td>
					</tr>
					<tr>
						<td>Номер на тема за рецензия</td>
						<td class="right"><?php if(isset($_SESSION['recursion_number'])){echo $_SESSION['recursion_number'];} else {echo "Не са разпределени!";} ?></td>
					</tr>
					<?php
						if(isset($_SESSION['ban_until']) && ($_SESSION['ban_until']) >= date("Y-m-d")) {
						echo "<tr><td>Баннат до</td><td class='right'>".$_SESSION['ban_until']."</td></tr>";
						}
					?>
				</table>
				<form method="POST" action="php/logout.php">
					<input type="submit" id="submit" value="Изход">
				</form>
			</div>
        </main>
    </body>
</html>