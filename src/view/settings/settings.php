<form action="index.php?page=settings" method="post">
    <div>
        <input type="radio" id="fontsize100" name="font" value="font-size-100" <?php echo $_SESSION["uiData"]['Font'] === "font-size-100" ? "checked" : "" ?>>
        <label for="fontsize100">100</label><br>
    </div>
    <div>
        <input type="radio" id="fontsize125" name="font" value="font-size-125" <?php echo $_SESSION["uiData"]['Font'] === "font-size-125" ? "checked" : "" ?>>
        <label for="fontsize125">125</label><br>
    </div>
    <div>
        <input type="radio" id="fontsize150" name="font" value="font-size-150" <?php echo $_SESSION["uiData"]['Font'] === "font-size-150" ? "checked" : "" ?>>
        <label for="fontsize150">150</label><br>
    </div>

    <div>
        <input type="radio" id="nocolor" name="contrast" value="nocolor" <?php echo $_SESSION["uiData"]['Contrast'] === "nocolor" ? "checked" : "" ?>>
        <label for="nocolor">zwart wit</label><br>
    </div>
    <div>
        <input type="radio" id="color" name="contrast" value="color" <?php echo $_SESSION["uiData"]['Contrast'] === "color" ? "checked" : "" ?>>
        <label for="color">kleur</label><br>
    </div>
    <button type="submit" name="action" value="update">Update</button>
</form>