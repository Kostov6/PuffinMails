var loggedUser = document.getElementById("username").innerHTML;
console.log(loggedUser);

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

function showErrorMst(errorMsg) {
  alert(errorMsg);
}

function addContact(user) {
  let data = synchGETRequest(
    "../backend/inbox/contacts/add.php?cookie=" +
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
  location.reload();
  return true;
}

function removeContact(user) {
  let data = synchGETRequest(
    "../backend/inbox/contacts/remove.php?cookie=" +
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

function getContacts() {
  let output = [];
  let userList = [];
  let data = synchGETRequest(
    "../backend/inbox/contacts/all.php?cookie=" +
      loggedUser
  );
  try {
    data = JSON.parse(data);
  } catch (error) {
    showErrorMst(data);
    return { contacts: [], usernames: [] };
  }
  for (person of data) {
    output.push(person.first_name + " " + person.last_name);
    userList.push(person.username);
  }
  return { contacts: output, usernames: userList };
}

toggleOn = false;

loadContacts(getContacts());

var showButton = document.getElementById("contact_options");
var indicator = showButton.querySelector("i");
showButton.addEventListener("click", (evemt) => {
  toggleOn = !toggleOn;
  if (toggleOn) {
    //indicator.setAttribute("class", "fa fa-caret-up");
    document.getElementById("contact_members").style.display = "block";
  } else {
    //indicator.setAttribute("class", "fa fa-caret-down");
    document.getElementById("contact_members").style.display = "none";
  }
});

var deleteContactButtons = document.querySelectorAll(".delete_contact");
for (deleteContact of deleteContactButtons) {
  deleteContact.addEventListener("click", (event) => {
    var thisButton = event.target;
    if (thisButton.tagName.toLowerCase() == "i") {
      thisButton = thisButton.parentElement;
    }
    var contactName = thisButton.parentElement.querySelector("span").innerHTML;
    console.log("Removing " + contactName + " from contacts...");

    if (removeContact(contactName)) {
      thisButton.parentElement.style.display = "none";
    }
  });
}

function loadContacts(contacts_usernames) {
  let contacts = contacts_usernames.contacts;
  let usernames = contacts_usernames.usernames;
  let contact_members = document.getElementById("contact_members");
  let contact;
  for (let i = 0; i < contacts.length; i++) {
    contact = contacts[i];
    var panel_member = document.createElement("div");
    panel_member.setAttribute("class", "panel_member");
    var badge = document.createElement("i");
    badge.setAttribute("class", "far fa-id-badge");
    var nameEl = document.createElement("p");
    nameEl.addEventListener("click", (event) => {
      if (window.location.pathname.includes("send.php")) {
        document.getElementById("to").value = usernames[i];
      } else {
        window.location.assign("send.php?to=" + usernames[i]);
      }
    });
    nameEl.innerHTML = contact;
    var usernameEl = document.createElement("span");
    usernameEl.setAttribute("style", "display:none");
    usernameEl.innerHTML = usernames[i];

    var buttonEl = document.createElement("button");
    buttonEl.setAttribute("class", "delete_contact");
    var deleteIcon = document.createElement("i");
    deleteIcon.setAttribute("class", "fa fa-times");
    buttonEl.appendChild(deleteIcon);

    panel_member.appendChild(badge);
    panel_member.appendChild(nameEl);
    panel_member.appendChild(usernameEl);
    panel_member.appendChild(buttonEl);

    contact_members.appendChild(panel_member);
  }
}