let components = "",
    ages = "0,150",
    time = "1";

var container = document.getElementsByClassName("pie_chart")[0];

// function give_dates() {
//     //console.log("Hello");
//     const response = new XMLHttpRequest();
//     response.onload = function() {
//         console.log(this.responseText);
//     }
//     response.open("GET","/ProiectAPI/statistics?time=" + time + "&age=" + ages);
//     response.send();
// }

function convert_components(str) {
    if(str == "Component 1") return "1";
    else if(str == "Component 2") return "2";
    else if(str == "Overall") return "0";
    else return "A";
}

function convert_ages(str) {
    if(str == "Under 18 years") return "0,17";
    else if(str == "18-29 years") return "18,29";
    else if(str == "30-39 years") return "30,39";
    else if(str == "40-49 years") return "40,49";
    else if(str == "50-59 years") return "50,59";
    else if(str == "60 years or older") return "60,150";
    else return "0,150";
}

function convert_times(str) {
    if(str == "Any time") return "1";
    else if(str == "One hour ago") return "1h";
    else if(str == "6 hours ago") return "6h";
    else if(str == "12 hours ago") return "12h";
    else if(str == "24 hours ago") return "24h";
    else if(str == "One week ago") return "1w";
    else if(str == "One month ago") return "1m";
    else return "1y";
}


var overallCheckbox = document.getElementById('overall');
var componentCheckboxes = document.querySelectorAll('input[name="selectedComponents[]"]');

overallCheckbox.addEventListener('change', function () {
    var isChecked = overallCheckbox.checked;
    componentCheckboxes.forEach(function (checkbox) {
        checkbox.checked = isChecked;
    });
});

componentCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        if (!checkbox.checked) {
            overallCheckbox.checked = false;
        }
    });
});

const selectBtn1 = document.querySelector(".container-one .select-btn");
selectBtn1.addEventListener("click", () => {
    selectBtn1.classList.toggle("open");
});


const selectBtn2 = document.querySelector(".container-two .select-btn");

selectBtn2.addEventListener("click", () => {
    selectBtn2.classList.toggle("open");
});

const selectBtn3 = document.querySelector(".container-three .select-btn");

selectBtn3.addEventListener("click", () => {
    selectBtn3.classList.toggle("open");
});


function changeTitle(label) {
    var selectedValue = label.textContent;
    var btnText = document.querySelector('.container-three .select-btn .btn-text');
    btnText.textContent = selectedValue;
}

function removeDivs() {
    const divs = document.querySelectorAll(".component-result");
    divs.forEach(div => {
        div.remove();
    })
}

//this function is where I modified the code
function removeButtons() {
    var button = document.getElementById("format-buttons");
    if(button) {
        button.remove();
    }
}

document.getElementById("verify").addEventListener("click", function() {
    removeDivs();
    removeButtons(); //and here
    // Get the form ID from the URL
    var formId = window.location.pathname.split("/").pop();

    // Base URL
    var url = "/ProiectAPI/statistics/" + formId + "/?";

    var componentsSelected = [];
    var componentsText = [];
    var index1 = 0;

    document.querySelectorAll('.error-message').forEach(e => e.remove());


    // Get selected checkboxes from the first container
    var selectedComponents = document.querySelectorAll(".container-one input[name='selectedComponents[]']:checked");
    if(selectedComponents.length === 0) {
        let errorMessage = document.createElement("div");
        errorMessage.classList.add("error-message");
        errorMessage.textContent = "Please select at least one component!";
        document.getElementsByClassName('container-one')[0].appendChild(errorMessage);
        return;
    }
    let query = "";
    for (var i = 0; i < selectedComponents.length; i++) {
        if(selectedComponents[i].id !== "overall") {
            componentsSelected[index1] = selectedComponents[i].getAttribute("value");
            componentsText[index1] = selectedComponents[i].nextElementSibling.innerText;
            //console.log(componentsText[index1]);
            //console.log(componentsSelected[index1]);
            // if(componentsSelected[index1] != -1) {
            //     arrayIndexes[arrayIndex] = componentsSelected[index1];
            //     console.log(arrayIndexes[arrayIndex]);
            //     arrayIndex++;
            // }
            index1++;
            var value = selectedComponents[i].value;
            query += "component" + index1 + "=" + value + "&";
        }

    }
    index1--;
    var agesSelected = [];
    var index2 = 0;

    // Get selected checkboxes from the second container
    let ageIndex = 0;
    var selectedAges = document.querySelectorAll(".container-two input[name='selectedAges[]']:checked");
    if(selectedAges.length === 0) {
        let errorMessage = document.createElement("div");
        errorMessage.classList.add("error-message");
        errorMessage.textContent = "Please select at least one age group!";
        document.getElementsByClassName('container-two')[0].appendChild(errorMessage);
        return;
    }

    for (var i = 0; i < selectedAges.length; i++) {
        agesSelected[index2] = selectedAges[i].getAttribute("value");
        index2++;
        var value = convert_ages(selectedAges[i].value);
        query += "age" + ageIndex + "=" + value + "&";
        ageIndex++;
    }
    index2--;

    // Get selected radio button value from the third container
    var selectedTime = convert_times(document.querySelector(".container-three input[name='time']:checked").value);
    var input = document.querySelector(".container-three input[name='time']:checked");
    var timeSelected = input.getAttribute("value");
    query += "date=" + selectedTime;
    url += query;
    var nr = 0;
    var labelContainer = document.createElement("div");
    labelContainer.id = "labelContainer";
    labelContainer.style.marginTop = "2rem";
    let oneChartPresent = 0;
    container.appendChild(labelContainer);
    console.log(url);
    fetch(url)
        .then(response => response.json())
        .then(data => {
            // Process the response data
            data.forEach(innerArray => {
                const key = Object.keys(innerArray)[0];
                const part = innerArray[key];
                if(part.length !== 0){
                    oneChartPresent = 1;
                    var emotions = [];
                    var count = [];
                    var barColors = [];
                    var i = 0;
                    part.forEach(component => {
                        emotions[i] = component['emotion'];
                        count[i] = component['COUNT(emotion)'];
                        i++;
                    });
                    i = 0;
                    var matrix_emotions = emotions;
                    var matrix_count = count;
                    var xValues = matrix_emotions;
                    var yValues = matrix_count;
                    var object = {
                        serenity: '#ffed9f',
                        joy: '#ffdc7b',
                        ecstasy: '#ffca05',
                        acceptance: '#cadf8b',
                        trust: '#abd26a',
                        admiration: '#8ac650',
                        apprehension: '#7ac698',
                        fear: '#30b575',
                        terror: '#00a551',
                        distraction: '#89c7e4',
                        surprise: '#36aed7',
                        amazement: '#0099cd',
                        pensiveness: '#a0c0e5',
                        sadness: '#74a8da',
                        grief: '#2983c5',
                        boredom: '#b9aad3',
                        disgust: '#a390c4',
                        loathing: '#8973b3',
                        annoyance: '#f48d80',
                        anger: '#f2736d',
                        rage: '#f05b61',
                        interest: '#fcc487',
                        anticipation: '#f9ad66',
                        vigilance: '#f6923d',
                        contempt: 'rgb(189, 103, 138)',
                        aggressiveness: 'rgb(243, 119, 79)',
                        optimism: 'rgb(251, 174, 33)',
                        love: 'rgb(197, 200, 43)',
                        submission: 'rgb(69, 182, 81)',
                        awe: 'rgb(0, 159, 143)',
                        disapproval: 'rgb(21, 142, 201)',
                        remorse: 'rgb(89, 123, 188)'
                    };
                    for (let j = 0; j < emotions.length; j++) {
                        if (emotions[j] == 'serenity') barColors[j] = object.serenity;
                        else if (emotions[j] == 'joy') barColors[j] = object.joy;
                        else if (emotions[j] == 'ecstasy') barColors[j] = object.ecstasy;
                        else if (emotions[j] == 'acceptance') barColors[j] = object.acceptance;
                        else if (emotions[j] == 'trust') barColors[j] = object.trust;
                        else if (emotions[j] == 'admiration') barColors[j] = object.admiration;
                        else if (emotions[j] == 'apprehension') barColors[j] = object.apprehension;
                        else if (emotions[j] == 'fear') barColors[j] = object.fear;
                        else if (emotions[j] == 'terror') barColors[j] = object.terror;
                        else if (emotions[j] == 'distraction') barColors[j] = object.distraction;
                        else if (emotions[j] == 'surprise') barColors[j] = object.surprise;
                        else if (emotions[j] == 'amazement') barColors[j] = object.amazement;
                        else if (emotions[j] == 'pensiveness') barColors[j] = object.pensiveness;
                        else if (emotions[j] == 'sadness') barColors[j] = object.sadness;
                        else if (emotions[j] == 'grief') barColors[j] = object.grief;
                        else if (emotions[j] == 'boredom') barColors[j] = object.boredom;
                        else if (emotions[j] == 'disgust') barColors[j] = object.disgust;
                        else if (emotions[j] == 'loathing') barColors[j] = object.loathing;
                        else if (emotions[j] == 'annoyance') barColors[j] = object.annoyance;
                        else if (emotions[j] == 'anger') barColors[j] = object.anger;
                        else if (emotions[j] == 'rage') barColors[j] = object.rage;
                        else if (emotions[j] == 'interest') barColors[j] = object.interest;
                        else if (emotions[j] == 'anticipation') barColors[j] = object.anticipation;
                        else if (emotions[j] == 'vigilance') barColors[j] = object.vigilance;
                        else if (emotions[j] == 'contempt') barColors[j] = object.contempt;
                        else if (emotions[j] == 'aggressiveness') barColors[j] = object.aggressiveness;
                        else if (emotions[j] == 'optimism') barColors[j] = object.optimism;
                        else if (emotions[j] == 'love') barColors[j] = object.love;
                        else if (emotions[j] == 'submission') barColors[j] = object.submission;
                        else if (emotions[j] == 'awe') barColors[j] = object.awe;
                        else if (emotions[j] == 'disapproval') barColors[j] = object.disapproval;
                        else if (emotions[j] == 'remorse') barColors[j] = object.remorse;
                    }
                    var matrix_colours = barColors;
                    var title1 = "";
                    var title2 = "";
                    var title3 = "";
                    title1 = componentsText[nr];
                    title2 = "Ages selected: ";
                    for (let m = 0; m < agesSelected.length - 1; m++) {
                        title2 += agesSelected[m] + ", ";
                    }
                    title2 += agesSelected[agesSelected.length - 1];
                    title3 = "Datetime selected: " + timeSelected;
                    var responseDiv = document.createElement("div");
                    responseDiv.className = "component-result";
                    var canvas = document.createElement("canvas");
                    canvas.id = "myChart" + componentsSelected[nr];
                    canvas.style.width = "100%";
                    canvas.style.maxWidth = "60rem";
                    canvas.style.height = "35rem";
                    responseDiv.appendChild(canvas);
                    var button = document.createElement("button");
                    button.className = "responseButton";
                    button.id = "response" + componentsSelected[nr];
                    button.textContent = "Show responses";
                    button.style.marginTop = "2rem";
                    responseDiv.appendChild(button);
                    container.appendChild(responseDiv);
                    button.onclick = function() {
                        getResponses(this,responseDiv);
                    }
                    //          var manipulatedLabels = [];

                    // for (let j = 0; j < emotions.length; j++) {
                    //     var manipulatedLabel = emotions[j].toUpperCase();
                    //     manipulatedLabels.push(manipulatedLabel);
                    //     var labelElement = document.createElement("p");
                    //     labelElement.textContent = manipulatedLabel;
                    //     labelContainer.appendChild(labelElement);
                    // }
                    new Chart("myChart" + componentsSelected[nr], {
                        type: "pie",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: [
                                    title1,
                                    title2,
                                    title3
                                ],
                                fontSize: 15,
                                position: "top"
                            },
                            legend: {
                                display: true,
                                align: "center",
                                labels: {
                                    boxWidth: 20,
                                    maxWidth: 20
                                },
                                responsive: true,
                                maintainAspectRatio: false
                                // width: 800,
                                // height: 800,
                            }
                        }
                    });
                }
                else{
                    var pElement = document.createElement("p");
                    pElement.classList.add("no-response");
                    pElement.textContent = "There were no feedbacks for " + componentsText[nr];
                    var responseDiv = document.createElement("div");
                    responseDiv.className = "component-result";
                    responseDiv.appendChild(pElement);
                    container.appendChild(responseDiv);
                }
                nr++;
            });
            if(oneChartPresent === 1)
            {
                let divElement = document.createElement("div");
                divElement.id = "format-buttons";
                let jsonButtonElement = document.createElement("button");
                jsonButtonElement.id = "jsonButton";
                jsonButtonElement.onclick = function (){
                    let newUrl = "/Proiect/give-statistics/" + formId + "/json?" + query;
                    window.location.href = newUrl;
                }
                jsonButtonElement.innerText = "Download JSON";
                let csvButtonElement = document.createElement("button");
                csvButtonElement.id = "csvButton";
                csvButtonElement.onclick = function (){
                    let newUrl = "/Proiect/give-statistics/" + formId + "/csv?" + query;
                    window.location.href = newUrl;
                }
                csvButtonElement.innerText = "Download CSV";
                divElement.appendChild(jsonButtonElement);
                divElement.appendChild(csvButtonElement);
                container.appendChild(divElement);
            }
        })
        .catch(error => {
            console.log(error);
        });

});

function return_number_components() {
    var selectedComponents = document.querySelectorAll(".container-one input[name='selectedComponents[]']:checked");
    return selectedComponents.length;
}

function getResponses(button,responseDiv) {
    let formId = window.location.pathname.split("/").pop();
    let url = "/ProiectAPI/responses/"  + formId + "/";
    let buttonId = button.id;
    let componentId = buttonId.replace("response", "");
    url = url + "?component=" + componentId + "&";

    let ageIndex = 1;
    var selectedAges = document.querySelectorAll(".container-two input[name='selectedAges[]']:checked");
    for (var i = 0; i < selectedAges.length; i++) {
        var value = convert_ages(selectedAges[i].value);
        url += "age" + ageIndex + "=" + value + "&";
    }
    // Get selected radio button value from the third container
    var selectedTime = convert_times(document.querySelector(".container-three input[name='time']:checked").value);
    var input = document.querySelector(".container-three input[name='time']:checked");
    var timeSelected = input.getAttribute("value");
    url += "date=" + selectedTime;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            let divElement = document.createElement('div');
            divElement.classList.add("table-container");
            var searchInput = document.createElement('input');
            searchInput.type = 'text';
            searchInput.class = 'search-users';
            searchInput.name = 'search-users ' + buttonId.replace("response", "");
            searchInput.placeholder = 'Search users';

            divElement.appendChild(searchInput);
            let table = document.createElement('table');
            let headerRow = document.createElement('tr');
            const dataKeys = Object.keys(data);
            dataKeys.forEach(key =>{
                let innerArray = data[key];
                innerArray.forEach(secondInnerArray => {
                    headerRow.classList.add('column-names');
                    Object.keys(secondInnerArray[0]).forEach(function(key) {
                        var th = document.createElement('th');
                        th.textContent = key.charAt(0).toUpperCase() + key.slice(1); // Capitalize the header text
                        headerRow.appendChild(th);
                    });
                    table.appendChild(headerRow);

                    secondInnerArray.forEach(componentData => {
                        var row = document.createElement('tr');
                        row.classList.add('user-row');
                        Object.keys(componentData).forEach(function(value) {
                            var td = document.createElement('td');
                            td.textContent = componentData[value].toString();
                            td.classList.add(value.toString());
                            row.appendChild(td);
                        });
                        table.appendChild(row);
                    })
                })
            })
            table.id = buttonId.replace("response", "table");
            divElement.appendChild(table);
            searchInput.addEventListener('keyup', function(e) {
                tableSearch(table.id,this,e);
            });
            button.remove();
            responseDiv.appendChild(divElement);
        })
        .catch(error =>{
            console.log(error);
        })
    //button.appendChild(comments);
}

function tableSearch(tableId, searchBar,e){
    const input = searchBar.value;
    let rows = document.querySelectorAll("#" + tableId + " .user-row");
    rows.forEach(row => {
        let username = row.getElementsByClassName('username')[0].textContent;
        let emotion = row.getElementsByClassName('emotion')[0].textContent;
        let description = row.getElementsByClassName('description')[0].textContent;

        if(username.toLowerCase().includes(input) || emotion.toLowerCase().includes(input) || description.toLowerCase().includes(input))
        {
            row.style.display = "table-row";
        }
        else
        {
            row.style.display = "none";
        }
    })
}