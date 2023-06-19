document.querySelectorAll('.carousel-control-prev').forEach((button) => {
   button.addEventListener('click', function(event) {
        let carousel = event.target.closest('.carousel');
        let totalItems = carousel.getElementsByClassName('carousel-item').length;
        let index = parseInt(carousel.dataset.index, 10);
        if (index === 0) {
            index = totalItems - 1;
        } else {
            index--;
        }

        carousel.dataset.index = index.toString();

        changeItem(index, carousel);
    });
});

document.querySelectorAll('.carousel-control-next').forEach((button) => {
    button.addEventListener('click', function (event) {
        let carousel = event.target.closest('.carousel');
        let totalItems = carousel.getElementsByClassName('carousel-item').length;
        let index = parseInt(carousel.dataset.index, 10);
        if (index === (totalItems - 1)) {
            index = 0;
        } else {
            index++;
        }

        carousel.dataset.index = index.toString();

        changeItem(index, carousel);
    })
});

function changeItem(index, carousel) {
    let items = carousel.getElementsByClassName('carousel-item');
    let totalItems = items.length;

    for (let i = 0; i < totalItems; i++) {
        items[i].classList.remove('active');
    }
    items[index].classList.add('active');
}

let emotions = [
    ['rage', '#FF6A6E'],
    ['anger', '#FF898E'],
    ['annoyance', '#FFA6AB'],
    ['aggressiveness', '#FF867E'],
    ['vigilance', '#FFB383'],
    ['anticipation', '#FFCFA3'],
    ['interest', '#FFDDB5'],
    ['optimism', '#FFBB52'],
    ['ecstasy', '#FFD800'],
    ['joy', '#FFE84C'],
    ['serenity', '#FFF190'],
    ['love', '#C7D044'],
    ['admiration', '#9ED660'],
    ['trust', '#B7E17D'],
    ['acceptance', '#D0ED9B'],
    ['submission', '#5CCE61'],
    ['terror', '#00B267'],
    ['fear', '#34C280'],
    ['apprehension', '#7EDD9D'],
    ['awe', '#1BB8B2'],
    ['amazement', '#00ACD9'],
    ['surprise', '#34BCE7'],
    ['distraction', '#80D6F0'],
    ['disapproval', '#1F9FD9'],
    ['grief', '#3A95D5'],
    ['sadness', '#72B4E0'],
    ['pensiveness', '#9CC7EB'],
    ['remorse', '#6783C6'],
    ['loathing', '#936EB6'],
    ['disgust', '#A890CC'],
    ['boredom', '#BFA6DB'],
    ['contempt', '#C15789'],
];

function modifyListEmotions(emotion_group, focus)
{
    const input = emotion_group.getElementsByClassName('input-emotion')[0];
    const inputValue = input.value;
    let emotionList = emotion_group.getElementsByClassName('emotion-list')[0];
    let emotionListItems = emotion_group.getElementsByClassName('emotion-list-items')[0];

    emotionListItems.innerHTML = '';

    let matchingEmotions = emotions.filter(function(emotion) {
        return inputValue.length === 0 || emotion[0].toLowerCase().startsWith(inputValue.toLowerCase()) && emotion[0] !== inputValue;
    });

    if(matchingEmotions.length === 0 && focus) {
        matchingEmotions = emotions;
    }

    matchingEmotions.forEach(function(emotion) {
        let emotionListItem = document.createElement('li');
        emotionListItem.classList.add('emotion-list-item');
        emotionListItem.innerHTML = emotion[0];
        emotionListItem.style.color = emotion[1];
        emotionListItem.addEventListener('click', function(event) {
            let errorMessage = emotion_group.getElementsByClassName('error-message');
            if (errorMessage.length > 0) {
                if(emotion_group.children[1].value.trim() !== '') {
                    emotion_group.removeChild(errorMessage[0]);
                }
            }
            input.value = this.textContent;
            emotionList.style.display = 'none';
        });
        emotionListItems.appendChild(emotionListItem);
    });

    if (matchingEmotions.length > 0) {
        emotionList.style.display = 'flex';
    } else {
        emotionList.style.display = 'none';
    }
}

document.querySelectorAll('.input-emotion').forEach((input) => {
    input.addEventListener('keyup', function(event) {
        let emotion_group = event.target.closest('.emotion-group');
        modifyListEmotions(emotion_group, false);
    });
});

document.querySelectorAll('.input-emotion').forEach((input) => {
    input.addEventListener('keydown', function(event) {
        let emotionList = input.parentElement.getElementsByClassName('emotion-list')[0];
        let emotionListItems = emotionList.getElementsByClassName('emotion-list-items')[0];

        if (event.key === 'Tab') {
            event.preventDefault();

            if (emotionListItems.children.length > 0) {
                emotionListItems.children[0].click();
            }
        }
    })
});

document.querySelectorAll('.input-emotion').forEach((input) => {
    input.addEventListener('focus', function(event) {
        let emotion_group = event.target.closest('.emotion-group');
        modifyListEmotions(emotion_group, true);
    });
});

document.querySelectorAll('.input-emotion').forEach((input) => {
    input.addEventListener('focusout', function(event) {
        let emotion_group = event.target.closest('.emotion-group');
        let emotionList = emotion_group.getElementsByClassName('emotion-list')[0];
        setTimeout(function() {
            emotionList.style.display = 'none';
        }, 100);
    });
});

function validateForm()
{
    let inputEmotionsValid = true;

    document.querySelectorAll('[class*="group"]').forEach(function(group) {
        if(group.classList[0] !== 'description-group') {
            if(hasErrorMessage(group)) {
                inputEmotionsValid = false;
            }
        }
    });

     document.querySelectorAll('.input-emotion').forEach((input) => {
        let temp = false;
        for(let i = 0; i < emotions.length; i++) {
            if(input.value === emotions[i][0]) {
                temp = true;
            }
        }

        if(temp === false) {
            let group = input.parentElement;
            if(!hasErrorMessage(group)) {
                let newErrorMessage = document.createElement('p');
                newErrorMessage.innerText = 'Please select a valid emotion!';
                newErrorMessage.classList.add('error-message');
                group.appendChild(newErrorMessage);
                inputEmotionsValid = false;
            }
        }
    });

    return inputEmotionsValid;
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


