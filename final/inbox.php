<!DOCTYPE html>
<?php
	session_start();
	if(!isset($_SESSION['logged'])) {
		header("Location: login.php");
	}
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="css/send.css" />
	<link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" href="css/inbox.css" />
    <title>Document</title>
  </head>
  <body>
    <div id="username" style="display:none"><?php echo $_SESSION["username"];?></div>
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
    <main>
      <div id="group_container">
        <div
          id="user_in_group_panel"
          class="options_panel"
          style="display: none;"
        >
          <h1>Управление на групата</h1>
          <h2>Напускане на групата</h2>
          <p>
            Натискайки бутон ще излезете от групата, в която се намирате в
            момента:
            <button id="leave_group">Напускане</button>
          </p>
        </div>
        <div
          id="user_not_in_group_panel"
          class="options_panel"
          style="display: none;"
        >
          <h1>Управление на групата</h1>
          <h2>Създаване на нова група</h2>
          <p>
            Натискайки бутон ще създадете своя група:
            <button id="create_group">Нова група</button>
          </p>
          <h2>Присъединяване в група</h2>
          <p>
            Тък може да видите всички покани, които сте получили за
            присъединяването към група
          </p>
          <div id="invites">
            <div class="invite_item">
              <div class="invite_name" style="font-weight: bold;">Име</div>
              <div class="invite_username" style="font-weight: bold;">
                Потребителско име
              </div>
            </div>
          </div>
        </div>

        <div id="leader_panel" class="options_panel" style="display: none;">
          <h1>Управление на групата</h1>
          <h2>Поканване на членове в групата</h2>
          <p>
            Въведете име и фамилия или потребителското име, за да изпратите покана
            за присъединяване
          </p>
          <input id="invite_name" type="text" />
          <button id="send_invite">
            Изпращане на покана
          </button>
          <h2>Премахване на членове от групата</h2>
          <p>От долното меню може като лидер на групата да премахнете участник</p>
          <div id="kick_container">
            <div class="kick_item">
              <div class="kick_name" style="font-weight: bold;">
                Име на участника
              </div>
              <div class="kick_button_container"></div>
            </div>
          </div>
          <h2>Разпускане на групата</h2>
          <p>
            Натискайки бутона ще изтриете групата, на която сте лидера
            <button class="red_button" id="delete_group">
              Разпускане на групата
            </button>
          </p>
        </div>
      </div>

      <div id="message_container">
        <div id="msg_info">
          <div class="infoS">От:</div>
          <div class="infoT" id="message_sender"></div>
          <br />
          <div class="infoS">До:</div>
          <div class="infoT" id="message_receivers"></div>
          <br />
          <div class="infoS">Тема:</div>
          <div class="infoT" id="message_thema"></div>
          <br />
          
          <div class="infoS"></div>
          <button class="infoT"  id="report_button">Докладвай за злоупотреба</button>
        </div>
        <div id="message_content"></div>
      </div>

      <table id="inbox_container">
        <tr>
          <th>Заглавие</th>
          <th>Изпращач</th>
          <th>Дата</th>
        </tr>
      </table>
    </main>
  </body>
  <script src="js/contacts.js"></script>
  <script src="js/group.js"></script>
  <script src="js/message.js"></script>
  <script src="js/report.js"></script>
</html>
