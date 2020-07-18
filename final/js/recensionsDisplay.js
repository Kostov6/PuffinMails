window.onload = function () {
    var recensions = document.getElementById('recensions');
    recensions.style.width = '50%';

    for (var i = 0; i < users.length; ++i) {
        var tr = document.createElement('tr');
        
        var td = document.createElement('td');
        td.appendChild(document.createTextNode(users[i]['first_name'] + ' ' + users[i]['last_name']));
        tr.appendChild(td);

        td = document.createElement('td');
        td.appendChild(document.createTextNode(users[i]['faculty_number']));
        tr.appendChild(td);

        td = document.createElement('td');
        td.appendChild(document.createTextNode(users[i]['number_theme']));
        tr.appendChild(td);

        td = document.createElement('td');
        td.appendChild(document.createTextNode(users[i]['recension_number']));
        tr.appendChild(td);

        recensions.appendChild(tr);
    }

    if (events.length > 0) {
        document.getElementById('add_event').setAttribute('class','hidden');
        
        var eventTable = document.getElementById('events');
        eventTable.setAttribute('class','events');

        //check if event has ended

        for (var i = 0; i < events.length; ++i) {
            var tr = document.createElement('tr');
            
           /*var td = document.createElement('td');
            td.appendChild(document.createTextNode(events[i]['event_title']));
            tr.appendChild(td);*/

            td = document.createElement('td');
            td.appendChild(document.createTextNode(events[i]['end_date']));
            tr.appendChild(td);

            eventTable.appendChild(tr);
        }
    }

    var form = document.getElementById('add_event');

    for (var i = 0; i < errors.length; ++i) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(errors[i]));
        div.setAttribute('class','error');
        div.setAttribute('id', 'error' + i);
        form.appendChild(div);
    }
};

function validate() {
    var dateInput = document.getElementById('end_date').value;
    var date = new Date(dateInput);
    var currDate = new Date();

    if (date < currDate) {
        document.getElementById('date_error').textContent = "Крайния срок не може да е в миналото!";

        var form = document.getElementById('add_event');

        for (var i = 0; i < document.getElementsByClassName('error').length - 1; ++i) {
            form.removeChild(document.getElementById('error' + i));
        }

        return false;
    } 
    document.getElementById('date_error').textContent = "";
}