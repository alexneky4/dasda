let inputComponents = document.getElementsByClassName("input-component-name");
let lastInputComponent = inputComponents[inputComponents.length - 1];

const form = document.querySelector('form');
form.addEventListener('submit', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
    }
});

const allComponentsGroup = document.getElementsByClassName("all-components-group")[0];


function callCreateInputComponent(event){
    if (event.key !== "Enter") {
        return;
    }
    createInputComponent();
}

lastInputComponent.addEventListener("keydown", callCreateInputComponent);
function createInputComponent(){
    document.querySelectorAll('.no-components-message').forEach((element) => {
        element.remove();
    });

    const newComponentGroup = document.createElement("div");
    newComponentGroup.classList.add("component-group");

    let lastPos = inputComponents.length + 1;

    newComponentGroup.innerHTML = `
    <div class="component-name-group">
        <label for="component-${lastPos}">Component Name <span class="red">*</span></label>
        <div class="component-name-input-group">
            <input type="text" class="input-component-name" name="component-${lastPos}" placeholder="Component name" required>
            <button type="button" class="remove-component-button" onclick="removeComponent(event)">X</button>
        </div>
    </div>

    <div class="component-description-group">
        <label for="component-${lastPos}-description">Component Description</label>
        <textarea id="component-${lastPos}-description" name="component-${lastPos}-description" rows="5"></textarea>
    </div>

    <div class="component-image-group">
        <label for="component-${lastPos}-images">Any images you wish to add for this component</label>
        <input type="file" id="component-${lastPos}-images" name="component-${lastPos}-images[]" accept="image/*" multiple>
    </div>
    `;
    
    allComponentsGroup.appendChild(newComponentGroup);
    
    const inputComponent = newComponentGroup.getElementsByClassName("input-component-name")[0];
    inputComponent.addEventListener("keydown", callCreateInputComponent);

    lastInputComponent.removeEventListener("keydown", callCreateInputComponent);

    lastInputComponent = inputComponent;
}

function removeComponent(event) {
    const button = event.target;
    const component = button.parentElement.parentElement.parentElement;
    component.remove();

    for (var i = 0; i < inputComponents.length; i++) {
        let num = i + 1;
        inputComponents[i].name = `component-${num}`;
        const groupComponent = inputComponents[i].parentElement.parentElement.parentElement;
        groupComponent.children[0].children[0].htmlFor = `component-${num}`;
        groupComponent.children[1].children[0].htmlFor = `component-${num}-description`;
        groupComponent.children[1].children[1].id = `component-${num}-description`;
        groupComponent.children[1].children[1].name = `component-${num}-description`;
        groupComponent.children[2].children[0].htmlFor = `component-${num}-images`;
        groupComponent.children[2].children[1].id = `component-${num}-images`;
        groupComponent.children[2].children[1].name = `component-${num}-images`;
    }
    if(inputComponents.length !== 0) {
        inputComponents[inputComponents.length - 1].addEventListener("keydown", callCreateInputComponent);
    } else {
        noComponentsMessage = document.createElement("p");
        noComponentsMessage.classList.add("no-components-message");
        noComponentsMessage.innerHTML = "No components added yet";
        allComponentsGroup.appendChild(noComponentsMessage);
    }
}

function validateForm() {
    let returnValue = true;

    if(document.querySelectorAll('div .error-message').length > 0) {
        returnValue = false;
    }

    console.log(returnValue);

    return returnValue;
}

function removeErrorMessage(group) {
    let errorMessage = group.getElementsByClassName('error-message');
    if (errorMessage.length > 0) {
        if(group.children[1].value.trim() !== '') {
            group.removeChild(errorMessage[0]);
        }
    }
}
document.getElementById('form-name').addEventListener('input', function(event) {
    removeErrorMessage(event.target.parentElement);
});