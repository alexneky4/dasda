function validateForm() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var returnValue = true;

    if(document.querySelectorAll('div .error-message').length > 0) {
        returnValue = false;
    }

    if (username.trim() === '' && !hasErrorMessage(document.getElementById('username'))) {
        var newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please enter a username!';
        newErrorMessage.classList.add('error-message');
        var group = document.getElementsByClassName('username-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if (password.trim() === '' && !hasErrorMessage(document.getElementById('password'))) {
        var newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please enter a password!';
        newErrorMessage.classList.add('error-message');
        var group = document.getElementsByClassName('password-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    return returnValue;
}

function hasErrorMessage(input) {
    var errorMessage = input.parentElement.getElementsByClassName('error-message');
    return errorMessage.length > 0;
}

function removeErrorMessage(group) {
    var errorMessage = group.getElementsByClassName('error-message');
    if (errorMessage.length > 0) {
        if(group.children[1].value.trim() !== '') {
            group.removeChild(errorMessage[0]);
        }
    }
}
document.querySelectorAll('[class*="group"]').forEach(function(group) {
    group.addEventListener('input', function() {
        removeErrorMessage(group);
    });
});