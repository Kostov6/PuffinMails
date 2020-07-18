let report_button = document.getElementById("report_button");
report_button.addEventListener("click", (event) => {
  let content = document.getElementById("message_content").innerHTML;
  let reported = document.getElementById("message_sender").innerHTML;
  report(loggedUser, reported, content);
});

function report(reporter, reported, currentMsg) {
  let reportMsg = {
    msgType: 7,
    sender: reporter,
    receiver: reported,
    content: currentMsg,
    title: "Reoport for " + reported,
  };
  console.log(reportMsg);

  fetch("../backend/inbox/messages/report.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(reportMsg),
  })
    .then((response) => response.json())
    .then((data) => console.log(data));
}
