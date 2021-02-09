<!-- Artikel -->
<h1><?php echo $article['Title'] ?></h1>
<div class="afspelen-buttons">
  <button class="synth-play button-blue" type="button">Lees Inhoud<img class="afspelen-icon" src="../../assets/img/icons/afspelen.svg" alt="Afspelen geluid icoon"></button>
  <button class="synth-pause button-white" type="button">Pauze<img class="afspelen-icon" src="../../assets/img/icons/pauze.svg" alt="Pauzeer icoon"></button>
  <button class="synth-stop button-white" type="button">Stop<img class="afspelen-icon" src="../../assets/img/icons/stop.svg" alt="Stop icoon"></button>
</div>
<div class="synth-text"><?php echo $article['Content'] ?></div>

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
<div class="hidden">
  <span class="synth-pitch"><?php echo !empty($_SESSION["uiData"]['VoicePitch']) ? $_SESSION["uiData"]['VoicePitch'] : 1.0 ?></span>
  <span class="synth-rate"><?php echo !empty($_SESSION["uiData"]['VoiceRate']) ? $_SESSION["uiData"]['VoiceRate'] : 0.8 ?></span>
</div>