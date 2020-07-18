window.onload = function () {
    if (!showAdminOptions) {
        document.getElementById('submit').style = 'display: none;';

        var elements = document.getElementsByClassName('admin');

        for (var i = 0; i < elements.length; ++i) {
            elements[i].setAttribute('class', 'pages admin hidden');
        }
    }
}