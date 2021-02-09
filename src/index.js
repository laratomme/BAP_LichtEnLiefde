require('./style.css');;

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
        ///Notifciation sounds from Zapsplat.com

    // Speech Synthesis
    let synth;
    let voice;
    let attempts = 0;
    const loadVoices = () => {
        attempts++;
        const voices = synth.getVoices();
        if (voices.length) {
            voice = voices.find(_voice => /nl[-_]NL/.test(_voice.lang));
        }
        if (!voice) {
            if (attempts < 10) {
                setTimeout(() => {
                    loadVoices();
                }, 250);
            } else {
                console.error('`nl-NL` voice not found.');
            }
        }
    }

    if ('speechSynthesis' in window) {
        synth = window.speechSynthesis;
        loadVoices();
    }

    window.onbeforeunload = () => {
        synth.cancel();
    };

    // Speech Functions
    const pitchControl = document.querySelector('.synth-pitch');
    const rateControl = document.querySelector('.synth-rate');
    const playControl = document.querySelector('.synth-play');
    const pauseControl = document.querySelector('.synth-pause');
    const stopControl = document.querySelector('.synth-stop');
    const textControl = document.querySelector('.synth-text');

    let manualPause = false;
    let timeoutResumeInfinity;

    const readSynthText = () => {
        if (!synth.speaking) {
            manualPause = false;

            let message = textControl.textContent;

            let synthUtter = new SpeechSynthesisUtterance(message);
            synthUtter.addEventListener('error', error => console.error(error));

            synthUtter.onstart = (e) => {
                resumeInfinity();
            };

            synthUtter.onend = (e) => {
                clearTimeout(timeoutResumeInfinity)
            }

            synthUtter.voice = voice;
            synthUtter.lang = voice.lang;
            synthUtter.pitch = pitchControl.textContent;
            synthUtter.rate = rateControl.textContent;
            synth.cancel();
            synth.speak(synthUtter);
            return;
        } else {
            pauseSynthText();
        }
    };

    const resumeInfinity = () => {
        if (!manualPause) {
            synth.pause();
            synth.resume();
        }
        timeoutResumeInfinity = setTimeout(resumeInfinity, 1000);
    }

    const pauseSynthText = () => {
        if (manualPause) {
            manualPause = false;
            synth.resume();
        } else {
            manualPause = true;
            synth.pause();
        }
    }

    const stopSynthText = () => {
        synth.cancel();
    }

    // Key Events
    document.addEventListener("keypress", (e) => {
        if (e.key == "Enter") {
            readSynthText();
        }
    });

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

        if (playControl) {
            playControl.addEventListener("click", (e) => {
                e.preventDefault();
                readSynthText();
            });
        }

        if (pauseControl) {
            pauseControl.addEventListener("click", (e) => {
                e.preventDefault();
                pauseSynthText();
            });
        }

        if (stopControl) {
            stopControl.addEventListener("click", (e) => {
                e.preventDefault();
                stopSynthText();
            });
        }
    }

    init();
}
