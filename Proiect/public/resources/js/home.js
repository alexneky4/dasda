// let hamburgerMenu = document.getElementById("hamburger-menu");
//
// hamburgerMenu.addEventListener('click', () => {
//     let links = document.getElementById("mobile-links");
//     if(links.style.display == "none")
//     {
//
//       links.style.display = "block";
//     }
//     else
//     {
//       links.style.display = "none";
//     }
// })

const searchInput = document.getElementById('search-bar');
const titles = document.getElementsByClassName("title");
const description = document.getElementsByClassName("description");

if(searchInput) {
    searchInput.addEventListener('keyup', function (event) {

            const searchQuery = event.target.value.toLowerCase();
            for (let i = 0; i < titles.length; i++) {
                const currentTitle = titles[i].textContent.toLowerCase();
                const currentDescription = description[i].textContent.toLowerCase();
                if (currentTitle.includes(searchQuery) || currentDescription.includes(searchQuery)) {
                    titles[i].parentElement.parentElement.parentElement.style.display = "block";
                } else {
                    titles[i].parentElement.parentElement.parentElement.style.display = "none";
                }
            }
        }
    );
}


var submitButton = document.getElementById("submit-tags");
if (submitButton) {
    submitButton.addEventListener("click", function(e) {
        e.preventDefault();
        var selectedTags = [];
        var checkboxes = document.querySelectorAll('input[name="selectedTags[]"]:checked');
        checkboxes.forEach(function(checkbox) {
            selectedTags.push(checkbox.value);
        });

        var queryParams = selectedTags.map(function(tagId) {
            return 'tag' + tagId + '=' + tagId;
        }).join('&');

        var currentUrl = window.location.href;
        var redirectUrl = currentUrl.split('?')[0]; // Remove existing query parameters
        if (queryParams.length > 0) {
            redirectUrl += '?' + queryParams;
        }

        window.location.href = redirectUrl;
    });

    // Check the checkboxes based on the query parameters
    var urlParams = new URLSearchParams(window.location.search);
    var checkboxes = document.querySelectorAll('input[name="selectedTags[]"]');
    checkboxes.forEach(function(checkbox) {
        var tagId = checkbox.value;
        if (urlParams.has('tag' + tagId)) {
            checkbox.checked = true;
        }
    });
}


