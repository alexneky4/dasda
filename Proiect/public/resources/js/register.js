let countries = [
    'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Australia',
    'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin',
    'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi',
    'Côte d\'Ivoire', 'Cabo Verde', 'Cambodia', 'Cameroon', 'Canada', 'Central African Republic', 'Chad', 'Chile', 'China',
    'Colombia', 'Comoros', 'Congo', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic',
    'Democratic Republic of the Congo', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador', 'Egypt',
    'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Eswatini', 'Ethiopia', 'Fiji', 'Finland',
    'France', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau',
    'Guyana', 'Haiti', 'Holy See', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland',
    'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos',
    'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Madagascar', 'Malawi',
    'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia',
    'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia',
    'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'North Korea', 'North Macedonia',
    'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine State', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru',
    'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia',
    'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia',
    'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa',
    'South Korea', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Sweden', 'Switzerland', 'Syria', 'Taiwan',
    'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey',
    'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States of America',
    'Uruguay', 'Uzbekistan', 'Vanuatu', 'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'
];

function validateForm() {
    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let dateOfBirth = document.getElementById('date-of-birth').value;
    let gender = document.getElementById('gender').value;
    let country = document.getElementById('country').value;

    let returnValue = true;

    if(document.getElementsByClassName('error-message').length > 0) {
        returnValue = false;
    }

    if (username.trim() === '' && !hasErrorMessage(document.getElementById('username'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please enter a username!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('username-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if (email.trim() === '' && !hasErrorMessage(document.getElementById('email'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please enter an email address!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('email-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if (password.trim() === '' && !hasErrorMessage(document.getElementById('password'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please enter a password!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('password-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if(!/^[\w]+$/.test(username) && !hasErrorMessage(document.getElementById('username'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Username can only contain letters, numbers and underscores!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('username-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if(!/^[\w.]+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/.test(email) && !hasErrorMessage(document.getElementById('email'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please enter a valid email address!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('email-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if(!/^[\w]+$/.test(password) && !hasErrorMessage(document.getElementById('password'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Password can only contain letters, numbers and underscores!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('password-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if (dateOfBirth.trim() === '' && !hasErrorMessage(document.getElementById('date-of-birth'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please enter a date of birth!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('date-of-birth-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if(gender.trim() === 'Gender' && !hasErrorMessage(document.getElementById('gender'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please select a gender!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('gender-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if(country.trim() === '' && !hasErrorMessage(document.getElementById('country'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please select a country!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('country-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    if(country.trim() !== '' && !countries.includes(country) && !hasErrorMessage(document.getElementById('country'))) {
        let newErrorMessage = document.createElement('p');
        newErrorMessage.innerText = 'Please select a valid country!';
        newErrorMessage.classList.add('error-message');
        let group = document.getElementsByClassName('country-group');
        group[0].appendChild(newErrorMessage);
        returnValue = false;
    }

    return returnValue;
}

function hasErrorMessage(input) {
    let errorMessage = input.parentElement.getElementsByClassName('error-message');
    return errorMessage.length > 0;
}

function removeErrorMessage(group) {
    let errorMessage = group.getElementsByClassName('error-message');
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

let input = document.getElementById('country');
input.addEventListener('input', function() {
    let inputValue = this.value;
    let countryList = document.getElementById('country-list');
    let countryListItems = document.getElementById('country-list-items');

    countryListItems.innerHTML = '';

    let matchingCountries = countries.filter(function(country) {
        return inputValue.length > 0 && country.toLowerCase().startsWith(inputValue.toLowerCase()) && country !== inputValue;
    });

    for (let i = 0; i < matchingCountries.length; i++) {
        let li = document.createElement('li');
        li.textContent = matchingCountries[i];
        li.addEventListener('click', function() {
            removeErrorMessage(document.getElementsByClassName('country-group')[0]);
            input.value = this.textContent;
            countryList.style.display = 'none';
        });
        countryListItems.appendChild(li);
    }

    if (matchingCountries.length > 0) {
        countryList.style.display = 'flex';
    } else {
        countryList.style.display = 'none';
    }
});

input.addEventListener('keydown', function(e) {
    let countryList = document.getElementById('country-list');
    let countryListItems = document.getElementById('country-list-items');

    // If the tab key is pressed
    if (e.key === 'Tab') {
        e.preventDefault();

        if (countryListItems.childNodes.length > 0) {
            input.value = countryListItems.childNodes[0].textContent;
            countryList.style.display = 'none';
        }
    }
});

input.addEventListener('focusin', function() {
    let countryList = document.getElementById('country-list');
    let countryListItems = document.getElementById('country-list-items');

    countryListItems.innerHTML = '';

    for (let i = 0; i < countries.length; i++) {
        let li = document.createElement('li');
        li.textContent = countries[i];
        li.addEventListener('click', function() {
            removeErrorMessage(document.getElementsByClassName('country-group')[0]);
            input.value = this.textContent;
            countryList.style.display = 'none';
        });
        countryListItems.appendChild(li);
    }
    countryList.style.display = 'flex';
});

input.addEventListener('focusout', function() {
    let countryList = document.getElementById('country-list');
    setTimeout(function() {
        countryList.style.display = 'none';
    }, 100);
});