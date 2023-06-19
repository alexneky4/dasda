const formElements = document.getElementsByClassName("created-form");
const textWrappers = document.getElementsByClassName("text-wrapper");
// console.log(formElements);
for (let i = 0; i < formElements.length; i++) {
  let form = formElements[i];
  let textWrapper = textWrappers[i];
  let clientHeight = textWrapper.clientHeight;
  let scrollHeight = textWrapper.scrollHeight;
  // console.log(scrollHeight);
  // console.log(clientHeight);
  if ( scrollHeight > clientHeight) {
    const divButton = document.createElement("div");
    divButton.classList.add("button-div");
    const expandButton = document.createElement("button");
    expandButton.classList.add("show-more-button");
    expandButton.textContent = "Show more";
    divButton.appendChild(expandButton);
    form.after(divButton);
    expandButton.addEventListener("click", function () {
      if (textWrapper.classList.contains("expanded")) {
        textWrapper.classList.remove("expanded");
        expandButton.textContent = "Show more";
      } else {
        textWrapper.classList.add("expanded");
        expandButton.textContent = "Show less";
      }
    });
  }
}

const editButton = document.getElementById("edit-button");

editButton.addEventListener('click', function() {
        window.location.href = '/Proiect/edit-profile';
})

const loadMoreCreatedFormsButton = document.getElementById("load-created");
const createdForms = document.getElementById("created-forms-list");
const username = document.getElementById("username").innerText;
let numberFormsCreated = 0;
let userId; // Variable to store the user ID

if(loadMoreCreatedFormsButton) {
    loadMoreCreatedFormsButton.addEventListener("click", () => {
        numberFormsCreated++;

        // Check if the user ID is already fetched
        if (userId) {
            fetchFormsCreatedData(userId);
        } else {
            const userUrl = '/ProiectAPI/users/' + username;
            fetch(userUrl)
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error("Error retrieving user data");
                    }
                })
                .then(data => {
                    userId = data['id']; // Store the user ID for future use
                    fetchFormsCreatedData(userId);
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }
    });

    function fetchFormsCreatedData(userId) {
        const formsUrl = '/ProiectAPI/forms?creator-id=' + encodeURIComponent(userId) +
            '&nr-forms=' + encodeURIComponent(numberFormsCreated.toString());

        fetch(formsUrl)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Error retrieving forms data");
                }
            })
            .then(data => {
                data.forEach(formData => {
                    const sectionElement = document.createElement('section');
                    sectionElement.classList.add('created-form');

                    const aElement = document.createElement('a');
                    aElement.href = "feedback";

                    const formInfoDiv = document.createElement('div');
                    formInfoDiv.classList.add('form-info');

                    const h1Element = document.createElement('h1');
                    h1Element.textContent = formData.name;
                    formInfoDiv.appendChild(h1Element);

                    const timeFormDiv = document.createElement('div');
                    timeFormDiv.classList.add('time-form');

                    const p1Element = document.createElement('p');
                    p1Element.textContent = formData.ending_date;
                    timeFormDiv.appendChild(p1Element);

                    const p2Element = document.createElement('p');
                    p2Element.classList.add("timer");
                    p2Element.textContent = formatTimeRemaining(formData.ending_date);
                    timeFormDiv.appendChild(p2Element);

                    formInfoDiv.appendChild(timeFormDiv);

                    aElement.appendChild(formInfoDiv);

                    const textWrapperDiv = document.createElement('div');
                    textWrapperDiv.classList.add('text-wrapper');

                    const pElement = document.createElement('p');
                    pElement.textContent = formData.description;
                    textWrapperDiv.appendChild(pElement);

                    aElement.appendChild(textWrapperDiv);

                    sectionElement.appendChild(aElement);

                    createdForms.insertBefore(sectionElement, loadMoreCreatedFormsButton);
                })
                const event = new Event('DOMContentLoaded');
                document.dispatchEvent(event);
                if (data.length < 3) {
                    loadMoreCreatedFormsButton.remove();

                    // Create and append a paragraph indicating no more forms
                    const noFormsParagraph = document.createElement('p');
                    noFormsParagraph.textContent = 'There are no more forms that you created';
                    createdForms.appendChild(noFormsParagraph);
                }
            })
            .catch(error => {
                loadMoreCreatedFormsButton.remove();

                // Create and append a paragraph indicating no more forms
                const noFormsParagraph = document.createElement('p');
                noFormsParagraph.textContent = 'There are no more forms that you created';
                createdForms.appendChild(noFormsParagraph);
            });
    }
}


const loadMoreTakenFormsButton = document.getElementById("load-taken");
const takenForms = document.getElementById("completed-forms-list");
console.log(takenForms);
let numberFormsTaken = 0;

if(loadMoreTakenFormsButton) {
    loadMoreTakenFormsButton.addEventListener("click", () => {
        numberFormsTaken++;

        // Check if the user ID is already fetched
        if (userId) {
            fetchFormsTakenData(userId);
        } else {
            const userUrl = '/ProiectAPI/users/' + username;
            fetch(userUrl)
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error("Error retrieving user data");
                    }
                })
                .then(data => {
                    userId = data['id']; // Store the user ID for future use
                    fetchFormsTakenData(userId);
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }
    });

    function fetchFormsTakenData(userId) {
        const formsUrl = '/ProiectAPI/forms?user-id=' + encodeURIComponent(userId) +
            '&nr-forms=' + encodeURIComponent(numberFormsTaken.toString());

        fetch(formsUrl)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Error retrieving forms data");
                }
            })
            .then(data => {
                data.forEach(formData => {
                    const section = document.createElement("section");
                    section.classList.add("complete-form-info");

                    const formInfoDiv = document.createElement("div");
                    formInfoDiv.classList.add("form-info");

                    const formNameHeading = document.createElement("h1");
                    formNameHeading.textContent = formData.name;
                    formInfoDiv.appendChild(formNameHeading);

                    const timeFormDiv = document.createElement("div");
                    timeFormDiv.classList.add("time-form");

                    const endDateParagraph = document.createElement("p");
                    endDateParagraph.textContent = formData.ending_date;
                    timeFormDiv.appendChild(endDateParagraph);

                    const timerParagraph = document.createElement("p");
                    timerParagraph.classList.add("timer");
                    timerParagraph.textContent = formatTimeRemaining(formData.ending_date);
                    timeFormDiv.appendChild(timerParagraph);

                    formInfoDiv.appendChild(timeFormDiv);
                    section.appendChild(formInfoDiv);

                    const progressBarContainerDiv = document.createElement("div");
                    progressBarContainerDiv.classList.add("progress-bar-container");

                    const progressBarDiv = document.createElement("div");
                    progressBarDiv.classList.add("progress-bar");

                    const progressDiv = document.createElement("div");
                    progressDiv.classList.add("progress");
                    progressBarDiv.appendChild(progressDiv);

                    progressBarContainerDiv.appendChild(progressBarDiv);

                    const progressPercentSpan = document.createElement("span");
                    progressPercentSpan.classList.add("progress-percent");
                    progressPercentSpan.textContent = "0%";
                    progressBarContainerDiv.appendChild(progressPercentSpan);

                    section.appendChild(progressBarContainerDiv);

                    const percentageProgressDiv = document.createElement("div");
                    percentageProgressDiv.classList.add("percentage-progress");

                    const valuePercentSpan = document.createElement("span");
                    valuePercentSpan.classList.add("value-percent");
                    valuePercentSpan.textContent = "50%";
                    percentageProgressDiv.appendChild(valuePercentSpan);

                    section.appendChild(percentageProgressDiv);
                    takenForms.insertBefore(section, loadMoreTakenFormsButton);
                })
                const event = new Event('DOMContentLoaded');
                document.dispatchEvent(event);
                if (data.length < 3) {
                    loadMoreTakenFormsButton.remove();

                    // Create and append a paragraph indicating no more forms
                    const noFormsParagraph = document.createElement('p');
                    noFormsParagraph.textContent = 'There are no more forms that you took';
                    takenForms.appendChild(noFormsParagraph);
                }
            })
            .catch(error => {
                loadMoreTakenFormsButton.remove();

                // Create and append a paragraph indicating no more forms
                const noFormsParagraph = document.createElement('p');
                noFormsParagraph.textContent = 'There are no more forms that you took';
                takenForms.appendChild(noFormsParagraph);
            });
    }
}

function formatTimeRemaining(endTime) {
    const currentDateTime = new Date();
    const endDateTime = new Date(endTime);

    if (endDateTime < currentDateTime) {
        return '00:00';
    }

    const interval = Math.abs(endDateTime - currentDateTime) / 1000;

    const days = Math.floor(interval / (24 * 60 * 60));
    const hours = Math.floor((interval % (24 * 60 * 60)) / (60 * 60));
    const minutes = Math.floor((interval % (60 * 60)) / 60);
    const seconds = Math.floor(interval % 60);

    let formattedTime = '';

    if (days > 0) {
        formattedTime += String(days).padStart(2, '0') + ':';
    }

    if (hours > 0 || days > 0) {
        formattedTime += String(hours).padStart(2, '0') + ':';
    }

    formattedTime +=
        String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

    return formattedTime;
}


const progressDivs = document.querySelectorAll('.progress');

// Iterate over each progress div
progressDivs.forEach(progressDiv => {
    // Get the corresponding value percent value
    const valuePercent = progressDiv.parentElement.parentElement.nextElementSibling.querySelector('.value-percent').innerText;

    // Remove any '%' symbol and convert to a decimal value
    const progressValue = parseFloat(valuePercent);

    // Set the width of the progress div
    progressDiv.style.width = (progressValue) + '%';
});