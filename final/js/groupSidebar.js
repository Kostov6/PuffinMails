let allGroupMembers = getGroupMembers();
loadGroupMembers(allGroupMembers.firstNames);

function synchGETRequest(url) {
  var request = new XMLHttpRequest();
  // false makes the request synchronous
  request.open("GET", url, false);
  request.send(null);

  if (request.status === 200) {
    return request.responseText;
  } else {
    return "Server returned status code " + request.status_;
  }
}

function loadGroupMembers(groupMembers) {
  if (groupMembers.length >= 1) {
    loadMember("fa fa-crown", groupMembers[0]);
    for (i = 1; i < groupMembers.length; i++) {
      loadMember("fa fa-user", groupMembers[i]);
    }
  }
}

function loadMember(iconClass, member) {
  let group_members = document.getElementById("group_members");
  console.log(member);
  let panel_member = document.createElement("div");
  panel_member.setAttribute("class", "panel_member");
  let icon = document.createElement("i");
  icon.setAttribute("class", iconClass);
  let par = document.createElement("p");
  par.innerHTML = member;

  panel_member.appendChild(icon);
  panel_member.appendChild(par);
  group_members.appendChild(panel_member);
}

function getGroupMembers() {
  let data = synchGETRequest(
    "http://localhost/Project/backend/inbox/group/members.php?cookie=" +
      loggedUser
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    if (data == "User is not in group") {
      let groupMembers = document.getElementById("group_members");

      let tipMessage = document.createElement("div");
      tipMessage.setAttribute("class", "panel_member");
      tipMessage.innerHTML = "В момента не си в група.";

      groupMembers.appendChild(tipMessage);
    } else {
      showErrorMst(data);
    }
    return { firstNames: [], usernames: [] };
  }
  return data;
}
