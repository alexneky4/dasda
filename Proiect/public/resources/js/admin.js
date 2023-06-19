const search_users = document.getElementById('search-users');

search_users.addEventListener('keyup', (e) => {
    const name = search_users.value;

    let rows = document.querySelectorAll('.user-row');

    rows.forEach((row) => {
        let name_row = row.getElementsByClassName('username')[0].textContent;
        let email_row = row.getElementsByClassName('email')[0].textContent;
        let gender_row = row.getElementsByClassName('gender')[0].textContent;
        let dateOfBirth_row = row.getElementsByClassName('date-of-birth')[0].textContent;
        let country_row = row.getElementsByClassName('country')[0].textContent;
        let is_admin_row = row.getElementsByClassName('is-admin')[0].textContent;

        if (name === '' || name_row.toLowerCase().includes(name.toLowerCase()) || email_row.toLowerCase().includes(name.toLowerCase()) || gender_row.toLowerCase().includes(name.toLowerCase()) ||
            dateOfBirth_row.toLowerCase().includes(name.toLowerCase()) || country_row.toLowerCase().includes(name.toLowerCase()) || is_admin_row.toLowerCase().includes(name.toLowerCase())) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });

});

const search_tags = document.getElementById('search-tags');

search_tags.addEventListener('keyup', (e) => {
    const name = search_tags.value;

    let tagElements = document.querySelectorAll('.tag-element');

    tagElements.forEach((tagElement) => {
        let name_tag = tagElement.children[0].textContent;

        if (name === '' || name_tag.toLowerCase().includes(name.toLowerCase())) {
            tagElement.style.display = 'flex';
        } else {
            tagElement.style.display = 'none';
        }
    });
});

document.querySelectorAll('.delete-user').forEach((deleteUser) => {
    deleteUser.addEventListener('click', (e) => {
        let username = deleteUser.parentElement.parentElement.getElementsByClassName('username')[0].textContent;

        fetch(`/ProiectAPI/users/${username}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                key: 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx',
            })
        }).then((response) => {
            return response.json();
        }).then((data) => {
            if (data.status === 'success') {
                deleteUser.parentElement.parentElement.remove();
            }
        });
    });
});

function deleteTag(tag_element)
{
    let tag_name = tag_element.children[0].textContent;
    fetch(`/ProiectAPI/tags/${tag_name}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            key: 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx',
        })
    }).then((response) => {
        return response.json();
    }).then((data) => {
        if (data.status === 'success') {
            tag_element.remove();
        }
    });
}

document.querySelectorAll('.delete-tag').forEach((deleteTagButton) => {
    deleteTagButton.addEventListener('click', (e) => {
        deleteTag(deleteTagButton.parentElement);
    });
});

document.getElementById('add-tag').addEventListener('click', (e) => {
    let tag_name = document.getElementById('search-tags').value;
    fetch(`/ProiectAPI/tags/`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Cache-Control': 'no-cache'
        },
        body: JSON.stringify({
            key: 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx',
            tag_name: tag_name
        })
    }).then((response) => {
        return response.json();
    }).then((data) => {
        if (data.status === 'success') {
            let tagElement = document.createElement('li');
            tagElement.classList.add('tag-element');
            tagElement.innerHTML = `
                <span class="tag-name">${tag_name}</span>
                <button class="delete-tag">Delete</button>
            `;
            document.getElementsByClassName('tags-list')[0].appendChild(tagElement);
            document.getElementById('add-tag').value = '';
            tagElement.getElementsByClassName('delete-tag')[0].addEventListener('click', (e) => {
                deleteTag(tagElement);
            });
        }
    });
});