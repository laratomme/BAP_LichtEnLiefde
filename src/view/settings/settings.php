<!-- Instellingen -->
<div class="settings-flex">
  <h1>Instellingen</h1>
  <form class="settings-grid" action="index.php?page=settings" method="post">

    <!-- Lettergrootte -->
    <fieldset>
      <legend class="settings-h2">Lettergrootte</legend>
      <div class="settings-radios">
        <input type="radio" id="fontsize100" name="font" value="font-size-100" <?php echo $_SESSION["uiData"]['Font'] === "font-size-100" ? "checked" : "" ?>>
        <label class="radio" for="fontsize100">100%</label>

        <input type="radio" id="fontsize125" name="font" value="font-size-125" <?php echo $_SESSION["uiData"]['Font'] === "font-size-125" ? "checked" : "" ?>>
        <label class="radio" for="fontsize125">125%</label>

        <input type="radio" id="fontsize150" name="font" value="font-size-150" <?php echo $_SESSION["uiData"]['Font'] === "font-size-150" ? "checked" : "" ?>>
        <label class="radio" for="fontsize150">150%</label>
      </div>
    </fieldset>

    <div class="settings-line"></div>

    <!-- Contrast/ kleur -->
    <fieldset>
      <legend class="settings-h2">Kleur</legend>
      <div class="settings-radios">
        <input type="radio" id="nocolor" name="contrast" value="nocolor" <?php echo $_SESSION["uiData"]['Contrast'] === "nocolor" ? "checked" : "" ?>>
        <label class="radio" for="nocolor">Zwart/wit</label>

        <input type="radio" id="color" name="contrast" value="color" <?php echo $_SESSION["uiData"]['Contrast'] === "color" ? "checked" : "" ?>>
        <label class="radio" class="label-kleur" for="color">Kleur</label>
      </div>
    </fieldset>

    <div class="settings-line"></div>

    <!-- Voorlees stem -->
    <fieldset>
      <legend class="settings-h2">Audio Assist - Stem</legend>
      <div class="voice-settings">
        <div class="voice-setting">
          <label for="voicerate">Tempo</label>
          <input class="voicerate-slider" type="range" min="0.5" max="1.5" step="0.1" id="voicerate" name="voicerate" value="<?php echo !empty($_SESSION["uiData"]['VoiceRate']) ? $_SESSION["uiData"]['VoiceRate'] : "0.8" ?>">
          <div class="voicerate-waarde synth-rate"><?php echo !empty($_SESSION["uiData"]['VoiceRate']) ? $_SESSION["uiData"]['VoiceRate'] : "0.8" ?></div>
        </div>
        <div class="voice-setting">
          <label for="voicepitch">Pitch</label>
          <input class="voicepitch-slider" type="range" min="0" max="1.5" step="0.1" id="voicepitch" name="voicepitch" value="<?php echo !empty($_SESSION["uiData"]['VoicePitch']) ? $_SESSION["uiData"]['VoicePitch'] : "1" ?>">
          <div class="voicepitch-waarde synth-pitch"><?php echo !empty($_SESSION["uiData"]['VoicePitch']) ? $_SESSION["uiData"]['VoicePitch'] : "1" ?></div>
        </div>
      </div>
      <button class="button-white button-voice-test synth-play">Test stem</button>
    </fieldset>

    <div class="settings-line"></div>

    <div class="form-grid-items settings-button">
      <button class="button-yellow" type="submit" name="action" value="update">Pas aan</button>
    </div>
  </form>
</div>
<div class="synth-text hidden">Zo klinkt mijn stem met deze instellingen.</div>

<!-- Voorlees stem script -->
<script>
  var pitch = document.querySelector('.voicepitch-slider');
  var pitchValue = document.querySelector('.voicepitch-waarde');
  pitch.onchange = () => {
    pitchValue.textContent = pitch.value;
  }

  var rate = document.querySelector('.voicerate-slider');
  var rateValue = document.querySelector('.voicerate-waarde');
  rate.onchange = () => {
    rateValue.textContent = rate.value;
  }
</script>
