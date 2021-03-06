let selectedFilter = new URLSearchParams(window.location.search).get("filter");
if (selectedFilter == "all") {
  showInbox("");
} else if (selectedFilter == "group") {
  showInbox(4);
} else if (selectedFilter == "sent") {
  showInbox("send");
} else if (selectedFilter == "draft") {
  showDraftInbox();
} else if (selectedFilter == "lecturer") {
  showInbox(5);
} else if (selectedFilter == "groupOptions") {
  showProperOption(getOptionState());
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

  document.getElementById("message_receivers").innerHTML = "всички";
  if (data.msgType != 5) {
    document.getElementById("message_receivers").innerHTML = data.receivers;
  }

  return true;
}

function select(filter) {
  document.getElementById("inbox").setAttribute("class", "control_panel_field");
  document.getElementById("sent").setAttribute("class", "control_panel_field");
  document
    .getElementById("group")
    .setAttribute("class", "control_panel_field no_admin");
  document.getElementById("draft").setAttribute("class", "control_panel_field");
  document
    .getElementById("lecturer")
    .setAttribute("class", "control_panel_field no_admin");
  document
    .getElementById("group_options")
    .setAttribute("class", "control_panel_field");

  if (filter == "") {
    document
      .getElementById("inbox")
      .setAttribute("class", "control_panel_field selected");
  } else if (filter == "send") {
    document
      .getElementById("sent")
      .setAttribute("class", "control_panel_field selected");
  } else if (filter == 4) {
    document
      .getElementById("group")
      .setAttribute("class", "control_panel_field no_admin selected");
  } else if (filter == "draft") {
    document
      .getElementById("draft")
      .setAttribute("class", "control_panel_field selected");
  } else if (filter == 5) {
    document
      .getElementById("lecturer")
      .setAttribute("class", "control_panel_field no_admin selected");
  } else if (filter == "group_options") {
    document
      .getElementById("group_options")
      .setAttribute("class", "control_panel_field selected");
  }
}

function showInbox(filter) {
  select(filter);

  document.getElementById("message_container").style.display = "none";
  document.getElementById("inbox_container").style.display = "table";
  document.getElementById("group_container").style.display = "none";

  loadInbox(filter);
}

function showDraftInbox() {
  select("draft");

  document.getElementById("message_container").style.display = "none";
  document.getElementById("inbox_container").style.display = "table";
  document.getElementById("group_container").style.display = "none";

  loadDraftInbox();
}

function loadDraftInbox() {
  loadCommonInboxElements(6, (event) => {
    let row = event.target;
    if (row.tagName.toLowerCase() == "td") {
      row = row.parentElement;
    }
    let msgId = row.querySelector("div").innerHTML;

    let data = synchGETRequest(
      "../backend/inbox/messages/view.php?cookie=" + loggedUser + "&id=" + msgId
    );
    try {
      data = JSON.parse(data);
    } catch (error) {
      showErrorMst(data);
      return false;
    }
    window.location.assign(
      "send.php?to=" +
        data.receivers +
        "&title=" +
        data.title +
        "&content=" +
        data.content
    );
  });
}

function loadInbox(filter) {
  loadCommonInboxElements(filter, (event) => {
    let row = event.target;
    if (row.tagName.toLowerCase() == "td") {
      row = row.parentElement;
    }
    let msgId = row.querySelector("div").innerHTML;
    showMessage(msgId);
  });
}

function loadCommonInboxElements(filter, onclickFunction) {
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

  if (data.length == 0) {
    let row = document.createElement("tr");

    let empty = document.createElement("td");
    empty.innerHTML = "Кутията е празна";

    row.appendChild(empty);

    inbox_container.appendChild(row);

    return;
  }
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

    inbox_container.appendChild(row);

    row.addEventListener("click", onclickFunction);
  }
}
