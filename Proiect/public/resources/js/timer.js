// Function to initialize countdown timers
// Function to initialize countdown timers
function initializeCountdownTimers() {
    const countDownElems = document.getElementsByClassName("timer");
    let timers = [];

    Array.from(countDownElems).forEach((countDownElem) => {
        let timeString = countDownElem ? countDownElem.innerText : "00:00:00:00";
        let timeArray = timeString.split(":");
        let time = convertTimeToSeconds(timeArray);
        let timerInterval;

        function updateCountDown() {
            if (time <= 0) {
                clearInterval(timerInterval);
                return;
            }

            let days = Math.floor(time / (24 * 60 * 60));
            let hours = Math.floor((time % (24 * 60 * 60)) / (60 * 60));
            let minutes = Math.floor((time % (60 * 60)) / 60);
            let seconds = Math.floor(time % 60);

            days = days < 10 ? "0" + days : days;
            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            let formattedTime = "";

            if (days > 0) {
                formattedTime = `${days}:${hours}:${minutes}:${seconds}`;
            } else if (hours > 0) {
                formattedTime = `${hours}:${minutes}:${seconds}`;
            } else {
                formattedTime = `${minutes}:${seconds}`;
            }

            countDownElem.innerText = formattedTime;
            time--;
        }

        timerInterval = setInterval(updateCountDown, 1000);
        timers.push(timerInterval);
    });

    // Return the timers array so that it can be used to stop the timers if needed
    return timers;
}
function convertTimeToSeconds(timeArray) {
    let days = 0;
    let hours = 0;
    let minutes = 0;
    let seconds = 0;

    if (timeArray.length >= 4) {
        days = parseInt(timeArray[0]) || 0;
        hours = parseInt(timeArray[1]) || 0;
        minutes = parseInt(timeArray[2]) || 0;
        seconds = parseInt(timeArray[3]) || 0;
    } else if (timeArray.length === 3) {
        hours = parseInt(timeArray[0]) || 0;
        minutes = parseInt(timeArray[1]) || 0;
        seconds = parseInt(timeArray[2]) || 0;
    } else if (timeArray.length === 2) {
        minutes = parseInt(timeArray[0]) || 0;
        seconds = parseInt(timeArray[1]) || 0;
    } else if (timeArray.length === 1) {
        seconds = parseInt(timeArray[0]) || 0;
    }

    // Check if the input time is "00:01" and adjust seconds accordingly
    if (days === 0 && hours === 0 && minutes === 0 && seconds === 1) {
        return 1;
    }

    let totalSeconds =
        days * 24 * 60 * 60 + hours * 60 * 60 + minutes * 60 + seconds;

    return totalSeconds;
}

// Call the initializeCountdownTimers function initially
let timers = initializeCountdownTimers();

// Function to stop all timers
function stopTimers() {
    timers.forEach((timer) => {
        clearInterval(timer);
    });
}

document.addEventListener('DOMContentLoaded', initializeCountdownTimers);
