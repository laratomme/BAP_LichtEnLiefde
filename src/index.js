require('./style.css'); {
    const SpeechRecognition = window.speechRecognition || window.webkitSpeechRecognition;

    const speechButton = document.querySelector('.search-speech-button');
    const searchForm = document.querySelector('.search-wrap');
    const searchInput = document.querySelector('.search-input');

    let recog = new SpeechRecognition();
    recog.lang = 'nl-NL';
    recog.interimResults = false;
    recog.maxAlternatives = 1;

    const init = () => {
        if (speechButton) {
            speechButton.addEventListener("click", (e) => {
                e.preventDefault();
                recog.start();
            });
        }
    }

    recog.onerror = (e) => {
        console.log('Error tijdens herkennen van de stem');
    }

    recog.onaudiostart = (e) => {
        // Stylen dat we nu recorden
        console.log('Audio Start');
    }

    recog.onspeechend = () => {
        recog.stop();
    }

    recog.onaudioend = (e) => {
        // Stylen dat we niet meer recorden
        console.log('Audio End');
    }

    recog.onresult = (e) => {
        const speechResult = e.results[0][0].transcript;
        searchInput.value = speechResult;
        searchForm.submit();
    }

    init();
}