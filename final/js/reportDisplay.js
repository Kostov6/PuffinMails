window.onload = function () {
    var main = document.getElementsByTagName('main')[0];
    var ban = document.getElementById('ban');

    var h4 = document.createElement('h4');
    h4.appendChild(document.createTextNode(report['title']));
    main.insertBefore(h4, ban);

    var div = document.createElement('div');
    div.appendChild(document.createTextNode('от: ' + report['first_name'] + ' ' + report['last_name'] + ', ' + report['faculty_number']));
    main.insertBefore(div, ban);

    div = document.createElement('div');
    div.appendChild(document.createTextNode('докладван: ' + report['reported']['first_name'] + ' ' + report['reported']['last_name'] + ', ' + report['reported']['faculty_number']));
    main.insertBefore(div, ban);

    div = document.createElement('div');
    div.appendChild(document.createTextNode('изпратено на: ' + report['time_sent']));
    main.insertBefore(div, ban);

    var p = document.createElement('p');
    p.appendChild(document.createTextNode(report['content']));
    main.insertBefore(p, ban);

    var currDate = new Date();
    var banUntil = new Date(report['reported']['ban_until']);

    if (banUntil >= currDate) {
        document.getElementById('ban').setAttribute('class','hidden');

        document.getElementById('ban_info').textContent = 'Потребителя има забрана да изпраща до: ' + report['reported']['ban_until'];
    } 
    else if (report['reported']['seen']) {
        document.getElementById('ban').setAttribute('class','hidden');

        document.getElementById('ban_info').textContent = 'Потребителя вече е получил забрана от това докладване!';
    }

    var form = document.getElementById('ban');

    for (var i = 0; i < errors.length; ++i) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(errors[i]));
        div.setAttribute('class','error');
        div.setAttribute('id', 'error' + i);
        form.appendChild(div);
    }
};

function validate() {
    var dateInput = document.getElementById('ban_date').value;
    var date = new Date(dateInput);
    var currDate = new Date();

    if (date < currDate) {
        document.getElementById('date_error').textContent = "Не може да се забрани със задна дата!";

        var form = document.getElementById('ban');

        for (var i = 0; i < document.getElementsByClassName('error').length - 1; ++i) {
            form.removeChild(document.getElementById('error' + i));
        }

        return false;
    } 
    document.getElementById('date_error').textContent = "";
}