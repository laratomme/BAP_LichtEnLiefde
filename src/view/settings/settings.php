<div class="settings-flex">
    <h1>Instellingen</h1>
    <form class="settings-grid" action="index.php?page=settings" method="post">

        <fieldset class="settings-fieldset">
            <legend>Lettergrootte</legend>
            <div class="settings-input">
                <input type="radio" id="fontsize100" name="font" value="font-size-100" <?php echo $_SESSION["uiData"]['Font'] === "font-size-100" ? "checked" : "" ?>>
                <label for="fontsize100">100</label><br>
            </div>
            <div class="settings-input">
                <input type="radio" id="fontsize125" name="font" value="font-size-125" <?php echo $_SESSION["uiData"]['Font'] === "font-size-125" ? "checked" : "" ?>>
                <label for="fontsize125">125</label><br>
            </div>
            <div class="settings-input">
                <input type="radio" id="fontsize150" name="font" value="font-size-150" <?php echo $_SESSION["uiData"]['Font'] === "font-size-150" ? "checked" : "" ?>>
                <label for="fontsize150">150</label><br>
            </div>
        </fieldset>

        <div class="settings-line"></div>

        <fieldset class="settings-fieldset">
            <legend>Kleur</legend>
            <div class="settings-input">
                <input type="radio" id="nocolor" name="contrast" value="nocolor" <?php echo $_SESSION["uiData"]['Contrast'] === "nocolor" ? "checked" : "" ?>>
                <label for="nocolor">Zwart/wit</label><br>
            </div>
            <div class="settings-input">
                <input type="radio" id="color" name="contrast" value="color" <?php echo $_SESSION["uiData"]['Contrast'] === "color" ? "checked" : "" ?>>
                <label class="label-kleur" for="color">Kleur</label><br>
            </div>
        </fieldset>

        <div class="settings-line"></div>

        <fieldset class="settings-fieldset">
            <legend>Audio Assist</legend>
        </fieldset>

        <div class="form-grid-items settings-button">
            <button class="button-yellow" type="submit" name="action" value="update">Update</button>
        </div>

    </form>

</div>