window.onload = function () {
    if (!showAdminOptions) {

        var elements = document.getElementsByClassName('admin');

        for (var i = 0; i < elements.length; ++i) {
            elements[i].setAttribute('class', 'pages admin hidden');
        }
    }
}