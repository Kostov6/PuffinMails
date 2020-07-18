let selectedFilter = new URLSearchParams(window.location.search).get("filter");
if (selectedFilter == "all") {
  showInbox("");
} else if (selectedFilter == "group") {
  showInbox(4);
} else if (selectedFilter == "sent") {
  showInbox("send");
} else if (selectedFilter == "draft") {
  showInbox(6);
} else if (selectedFilter == "lecturer") {
  showInbox(5);
}

function showMessage(messageId) {
  document.getElementById("message_container").style.display = "block";
  document.getElementById("inbox_container").style.display = "none";
  document.getElementById("group_container").style.display = "none";

  loadMessage(messageId);
}

function loadMessage(messageId) {
  let data = synchGETRequest(
    "../backend/inbox/messages/view.php?cookie=" +
      loggedUser +
      "&id=" +
      messageId
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return false;
  }
  document.getElementById("message_content").innerHTML = data.content;
  document.getElementById("message_thema").innerHTML = data.title;
  document.getElementById("message_sender").innerHTML = data.sender;
  document.getElementById("message_receivers").innerHTML = data.receivers;

  return true;
}

function showInbox(filter) {
  document.getElementById("message_container").style.display = "none";
  document.getElementById("inbox_container").style.display = "table";
  document.getElementById("group_container").style.display = "none";

  loadInbox(filter);
}

function loadInbox(filter) {
  let data = synchGETRequest(
    "../backend/inbox/messages/inbox.php?cookie=" +
      loggedUser +
      "&filter=" +
      filter
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return false;
  }
  let inbox_container = document.getElementById("inbox_container");
  inbox_container.innerHTML =
    "<tr><th>Заглавие</th><th>Изпращач</th><th>Дата</th></tr>";
  for (message of data) {
    let row = document.createElement("tr");
    row.setAttribute("class", "row_element");
    if (message.seen == "0") {
      row.style.fontWeight = "bold";
    }
    let title = document.createElement("td");
    title.innerHTML = message.title;

    let sender = document.createElement("td");
    sender.innerHTML = message.sender;

    let date = document.createElement("td");
    date.innerHTML = message.time_sent;

    let msgId = document.createElement("div");
    msgId.innerHTML = message.msgId;
    msgId.style = "display:none";

    row.appendChild(title);
    row.appendChild(sender);
    row.appendChild(date);
    row.appendChild(msgId);

    row.addEventListener("click", (event) => {
      let row = event.target;
      if (row.tagName.toLowerCase() == "td") {
        row = row.parentElement;
      }
      let msgId = row.querySelector("div").innerHTML;
      showMessage(msgId);
    });

    inbox_container.appendChild(row);
  }
}
