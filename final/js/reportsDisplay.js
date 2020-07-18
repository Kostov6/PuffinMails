window.onload = function () {
    var reportsTable = document.getElementById('reports');

    for (var i = 0; i < reports.length; ++i) {
        var tr = document.createElement('tr');
        
        var td = document.createElement('td');
        td.appendChild(document.createTextNode(reports[i]['first_name'] + ' ' + reports[i]['last_name']));
        tr.appendChild(td);

        td = document.createElement('td');
        td.appendChild(document.createTextNode(reports[i]['title']));
        tr.appendChild(td);

        td = document.createElement('td');
        td.appendChild(document.createTextNode(reports[i]['time_sent']));
        tr.appendChild(td);

        tr.setAttribute('reportId', reports[i]['msgId']);
        tr.style.cursor = 'pointer';

        var createClickHandler = function(row) {
            return function() {
                var reportId = row.getAttribute('reportId');
                window.location = './report.php?reportId=' + reportId;
            };
        };

        tr.onclick = createClickHandler(tr);

        reportsTable.appendChild(tr);
    }

    var bansTable = document.getElementById('bans');

    for (var i = 0; i < bannedUsers.length; ++i) {
        var tr = document.createElement('tr');
        
        var td = document.createElement('td');
        td.appendChild(document.createTextNode(bannedUsers[i]['first_name'] + ' ' + bannedUsers[i]['last_name']));
        tr.appendChild(td);

        td = document.createElement('td');
        td.appendChild(document.createTextNode(bannedUsers[i]['faculty_number']));
        tr.appendChild(td);

        td = document.createElement('td');
        td.appendChild(document.createTextNode(bannedUsers[i]['ban_until']));
        tr.appendChild(td);

        td = document.createElement('td');
        var button = document.createElement('button');
        button.appendChild(document.createTextNode('Премахни забрана'));
        button.setAttribute('userId', bannedUsers[i]['userID']);

        var createClickHandler = function(button) {
            return function() {
                var userId = button.getAttribute('userId');
                window.location = './unban.php?userId=' + userId;
            };
        };

        button.onclick = createClickHandler(button);
        button.style.cursor = 'pointer';
        td.appendChild(button);
        tr.appendChild(td);

        bansTable.appendChild(tr);
    }
};