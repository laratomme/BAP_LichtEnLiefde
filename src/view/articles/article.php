<!-- Artikel -->
<h1><?php echo $article['Title'] ?></h1>
<div>
    <button class="button-afspelen-article" type="button" onclick="speakArticle()">Lees Inhoud</button>
    <button class="button-pauzeer-article" type="button" onclick="pauseArticle()">Pauze</button>
    <button class="button-pauzeer-article" type="button" onclick="stopArticle()">Stop</button>
    <div class="inhoud-content"><?php echo $article['Content'] ?></div>
</div>

<?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>
    <div class="beheer-art-flex">
        <!-- Manage Artikel -->
        <a class="button-aanmaken button-link" href="index.php?page=articles&id=<?php echo $article['ArticleID'] ?>">
            <div class="button-blue">
                <p>Inhoud bewerken</p>
                <img src="../../assets/img/icons/edit.svg" alt="Icoon bewerken folder met potlood">
            </div>
        </a>
        <a class="button-aanmaken button-link" href="index.php?page=articles&action=delete&id=<?php echo $article['ArticleID']; ?>&categoryid=<?php echo $article['CategoryID']; ?>">
            <div class="button-blue">
                <p>Inhoud verwijderen</p>
                <img src="../../assets/img/icons/delete-article.svg" alt="Icoon verwijderen folder met kruis">
            </div>
        </a>
    </div>
<?php } ?>
<script>
    const synth = speechSynthesis;
    const content = document.querySelector('.inhoud-content');

    let manualPause = false;

    document.addEventListener("keypress", (event) => {
        if (event.key == "Enter") {
            speakArticle();
        }
    });

    window.onbeforeunload = () => {
        synth.cancel();
    };

    const speakArticle = () => {
        if (!synth.speaking) {
            manualPause = false;

            let message = content.textContent;

            let synthUtter = new SpeechSynthesisUtterance(message);

            synthUtter.onstart = function(event) {
                resumeInfinity();
            };

            synthUtter.onend = (e) => {
                clearTimeout(timeoutResumeInfinity)
            }

            synthUtter.onerror = (e) => {
                console.log('Error Speaking');
            }

            synthUtter.voice = synth.getVoices().filter((a) => {
                return a.lang == 'nl-NL';
            })[0];
            synthUtter.pitch = <?php echo !empty($_SESSION["uiData"]['VoicePitch']) ? $_SESSION["uiData"]['VoicePitch'] : 1.0 ?>;
            synthUtter.rate = <?php echo !empty($_SESSION["uiData"]['VoiceRate']) ? $_SESSION["uiData"]['VoiceRate'] : 0.8 ?>;
            synth.cancel();
            synth.speak(synthUtter);
            return;
        }
        pauseArticle();
    };

    const resumeInfinity = () => {
        if (!manualPause) {
            synth.pause();
            synth.resume();
        }
        timeoutResumeInfinity = setTimeout(resumeInfinity, 1000);
    }

    const pauseArticle = () => {
        if (manualPause) {
            manualPause = false;
            synth.resume();
        } else {
            manualPause = true;
            synth.pause();
        }
    }

    const stopArticle = () => {
        synth.cancel();
    }
</script>