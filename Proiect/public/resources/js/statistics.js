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

