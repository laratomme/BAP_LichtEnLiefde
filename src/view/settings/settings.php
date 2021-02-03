<div class="settings-flex">
    <h1>Instellingen</h1>
    <form class="settings-grid" action="index.php?page=settings" method="post">

        <p class="settings-h2">Lettergrootte</p>
        <div class="settings-radios">
            <input type="radio" id="fontsize100" name="font" value="font-size-100" <?php echo $_SESSION["uiData"]['Font'] === "font-size-100" ? "checked" : "" ?>>
            <label class="radio" for="fontsize100">100%</label>

            <input type="radio" id="fontsize125" name="font" value="font-size-125" <?php echo $_SESSION["uiData"]['Font'] === "font-size-125" ? "checked" : "" ?>>
            <label class="radio" for="fontsize125">125%</label>

            <input type="radio" id="fontsize150" name="font" value="font-size-150" <?php echo $_SESSION["uiData"]['Font'] === "font-size-150" ? "checked" : "" ?>>
            <label class="radio" for="fontsize150">150%</label>
        </div>

        <div class="settings-line"></div>

        <p class="settings-h2">Kleur</p>
        <div class="settings-radios">
            <input type="radio" id="nocolor" name="contrast" value="nocolor" <?php echo $_SESSION["uiData"]['Contrast'] === "nocolor" ? "checked" : "" ?>>
            <label class="radio" for="nocolor">Zwart/wit</label>

            <input type="radio" id="color" name="contrast" value="color" <?php echo $_SESSION["uiData"]['Contrast'] === "color" ? "checked" : "" ?>>
            <label class="radio" class="label-kleur" for="color">Kleur</label>
        </div>

        <div class="settings-line"></div>

        <p class="settings-h2">Audio Assist</p>

        <div class="form-grid-items settings-button">
            <button class="button-yellow" type="submit" name="action" value="update">Pas aan</button>
        </div>

    </form>

</div>