require('./style.css');
require('./validate.js');

{
    // Voice Recognition
    const SpeechRecognition = window.speechRecognition || window.webkitSpeechRecognition;

    const speechButton = document.querySelector('.search-speech-button');
    const searchForm = document.querySelector('.search-wrap');
    const searchInput = document.querySelector('.search-input');

    let recog = new SpeechRecognition();
    recog.lang = 'nl-NL';
    recog.interimResults = false;
    recog.maxAlternatives = 1;

    recog.onerror = (e) => {
        console.log('Error tijdens herkennen van de stem');
    }

    recog.onaudiostart = (e) => {
        speechButton.classList.add('speech-active');
        let audioStart = new Audio('/assets/sounds/notification-start.mp3');
        audioStart.play();
    }

    recog.onspeechend = () => {
        recog.stop();
    }

    recog.onaudioend = (e) => {
        speechButton.classList.remove('speech-active');
        let audioEnd = new Audio('/assets/sounds/notification-stop.mp3');
        audioEnd.play();
    }

    recog.onresult = (e) => {
        const speechResult = e.results[0][0].transcript;
        searchInput.value = speechResult;
        searchForm.submit();
    }

    //Notifciation sounds from Zapsplat.com

    // javascript forms
    const checkboxForm = document.querySelector('.icoon-aanpassen');

    const init = () => {
        if (speechButton) {
            speechButton.addEventListener("click", (e) => {
                e.preventDefault();
                recog.start();
            });
        }

        if (checkboxForm) {
            checkboxForm.addEventListener('click', () => {
                const displays = document.querySelectorAll('.display-icons');
                displays.forEach(display => {
                    if (checkboxForm.checked) {
                        display.classList.remove('hidden');
                    } else {
                        display.classList.add('hidden');
                    }
                });
            });
        }
    }

    init();
}
