var listElements = document.querySelectorAll('li');
for (var i = 0; i < listElements.length; i++) {
    var listElement = listElements[i];
    if (listElement.querySelector('ul') || listElement.querySelector('ol')) {
        listElement.style.listStyle = 'none';
    }
}
