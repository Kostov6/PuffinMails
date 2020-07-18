function debugClear() {
  let user_in_group_panel = document.getElementById("user_in_group_panel");
  let user_not_in_group_panel = document.getElementById(
    "user_not_in_group_panel"
  );
  let leader_panel = document.getElementById("leader_panel");
  user_in_group_panel.style.display = "block";
  user_not_in_group_panel.style.display = "block";
  leader_panel.style.display = "block";
}

var debugState = "groupUser";

function getOptionState() {
  let data = synchGETRequest(
    "../backend/inbox/group/state.php?cookie=" +
      loggedUser
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return null;
  }
  return data.state;
}

function getGroupMembers() {
  let data = synchGETRequest(
    "../backend/inbox/group/members.php?cookie=" +
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

function leaveGroup() {
  console.log("Leaving group...");
  let data = synchGETRequest(
    "../backend/inbox/group/leave.php?cookie=" +
      loggedUser
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return false;
  }
  return true;
}

function createGroup() {
  console.log("Creating group...");
  let data = synchGETRequest(
    "../backend/inbox/group/create.php?cookie=" +
      loggedUser
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return false;
  }
  return true;
}

function deleteGroup() {
  console.log("Deleting group...");
  let data = synchGETRequest(
    "../backend/inbox/group/removeGroup.php?cookie=" +
      loggedUser
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return false;
  }
  return true;
}

function sendInvite(user) {
  console.log("Inviting user:" + user + " ...");
  let data = synchGETRequest(
    "../backend/inbox/group/invite.php?cookie=" +
      loggedUser +
      "&user=" +
      user
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return false;
  }
  return true;
}

function removeUser(user) {
  console.log("kicking user " + user + " ...");
  let data = synchGETRequest(
    "../backend/inbox/group/remove.php?cookie=" +
      loggedUser +
      "&user=" +
      user
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return false;
  }
  return true;
}

function joinGroup(leaderName) {
  console.log("Joining group of leader " + leaderName + " ...");
  let data = synchGETRequest(
    "../backend/inbox/group/accept.php?cookie=" +
      loggedUser +
      "&leader=" +
      leaderName
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return false;
  }
  return true;
}

let allGroupMembers = getGroupMembers();
loadGroupMembers(allGroupMembers.firstNames);
loadUsersToKick(
  allGroupMembers.firstNames.slice(1, allGroupMembers.firstNames.length),
  allGroupMembers.usernames.slice(1, allGroupMembers.usernames.length)
);
loadInvites(getAllInvites());

function getAllInvites() {
  let data = synchGETRequest(
    "../backend/inbox/group/allInvites.php?cookie=" +
      loggedUser
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return { first_name: [], username: [] };
  }
  return data;
}
/*
loadInvites([
  {
    inviteName: "one",
    inviteUsername: "1",
  },
  {
    inviteName: "two",
    inviteUsername: "2",
  },
  {
    inviteName: "three",
    inviteUsername: "3",
  },
]);
*/
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

var leaveGroupButton = document.getElementById("leave_group");
leaveGroupButton.addEventListener("click", (event) => {
  leaveGroup();
});

var createGroupButton = document.getElementById("create_group");
createGroupButton.addEventListener("click", (event) => {
  createGroup();
});

var deleteGroupButton = document.getElementById("delete_group");
deleteGroupButton.addEventListener("click", (event) => {
  deleteGroup();
});

var sendInviteButton = document.getElementById("send_invite");
sendInviteButton.addEventListener("click", (event) => {
  let user = document.getElementById("invite_name");
  sendInvite(user.value);
});

function loadUsersToKick(kickNames, kickUsernames) {
  for (let i = 0; i < kickNames.length; i++) {
    let kickName = kickNames[i];
    let kick_container = document.getElementById("kick_container");

    let kick_item = document.createElement("div");
    kick_item.setAttribute("class", "kick_item");

    let kick_name = document.createElement("div");
    kick_name.setAttribute("class", "kick_name");
    kick_name.innerHTML = kickName;

    let kick_username = document.createElement("span");
    kick_username.setAttribute("style", "display:none");
    kick_username.innerHTML = kickUsernames[i];

    let kick_button_container = document.createElement("div");
    kick_button_container.setAttribute("class", "kick_button_container");

    let kick_button = document.createElement("button");
    kick_button.setAttribute("class", "kick_button");
    kick_button.addEventListener("click", (event) => {
      let buttonEl = event.target;
      let kickItemEl = buttonEl.parentElement.parentElement;
      let nameEl = kickItemEl.querySelector("span");
      let name = nameEl.innerHTML;
      removeUser(name);
    });
    kick_button.innerHTML = "Премахване";

    kick_button_container.appendChild(kick_button);

    kick_item.appendChild(kick_name);
    kick_item.appendChild(kick_username);
    kick_item.appendChild(kick_button_container);

    kick_container.appendChild(kick_item);
  }
}

function loadInvites(userInvites) {
  for (userInvite of userInvites) {
    let invites = document.getElementById("invites");

    let invite_item = document.createElement("div");
    invite_item.setAttribute("class", "invite_item");

    let invite_name = document.createElement("div");
    invite_name.setAttribute("class", "invite_name");
    invite_name.innerHTML = userInvite.first_name;

    let invite_username = document.createElement("div");
    invite_username.setAttribute("class", "invite_username");
    invite_username.innerHTML = userInvite.username;

    let invite_button_container = document.createElement("div");
    invite_button_container.setAttribute("class", "invite_button_container");

    let invite_button = document.createElement("button");
    invite_button.setAttribute("class", "invite_button");
    invite_button.addEventListener("click", (event) => {
      let buttonEl = event.target;
      let inviteItemEl = buttonEl.parentElement.parentElement;
      let nameEl = inviteItemEl.querySelector("div[class='invite_username']");
      let name = nameEl.innerHTML;
      joinGroup(name);
    });
    invite_button.innerHTML = "Приемане";

    invite_button_container.appendChild(invite_button);

    invite_item.appendChild(invite_name);
    invite_item.appendChild(invite_username);
    invite_item.appendChild(invite_button_container);

    invites.appendChild(invite_item);
  }
}

var groupOptionsButton = document.getElementById("group_options");
groupOptionsButton.addEventListener("click", (event) => {
  let optionState = getOptionState();
  if (optionState != null) {
    showProperOption(optionState);
  }
});

function showProperOption(state) {
  let user_in_group_panel = document.getElementById("user_in_group_panel");
  let user_not_in_group_panel = document.getElementById(
    "user_not_in_group_panel"
  );
  let leader_panel = document.getElementById("leader_panel");

  document.getElementById("group_container").style.display = "block";
  document.getElementById("message_container").style.display = "none";
  document.getElementById("inbox_container").style.display = "none";
  if (state == "groupUser") {
    user_in_group_panel.style.display = "block";
    user_not_in_group_panel.style.display = "none";
    leader_panel.style.display = "none";
  } else if (state == "noGroupUser") {
    user_in_group_panel.style.display = "none";
    user_not_in_group_panel.style.display = "block";
    leader_panel.style.display = "none";
  } else if (state == "leader") {
    user_in_group_panel.style.display = "none";
    user_not_in_group_panel.style.display = "none";
    leader_panel.style.display = "block";
  } else {
    console.log("invalid state parameter");
  }
}
