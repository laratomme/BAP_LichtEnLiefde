<!-- Icon Sets -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <!-- List -->
        <?php if (count($iconsets) == 0) { ?>
            <div>
                <p>Geen IconSets toegevoegd.</p>
            </div>
        <?php } else { ?>
            <div>
                <?php foreach ($iconsets as $iconset) : ?>
                    <div><?php echo $iconset['IconSetID'] ?> - <?php echo $iconset['Icon'] ?></div>
                    <div>
                        <a href="index.php?page=iconsets&id=<?php echo $iconset['IconSetID'] ?>">
                            <p>Wijzig IconSet</p>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        <?php } ?>
        <div>
            <a href="index.php?page=iconsets&action=create">
                <div>
                    <p>Icon Sets aanmaken</p>
                </div>
            </a>
        </div>
    <?php } else { ?>
        <!-- Detail -->
        <div>
            <form enctype="multipart/form-data" action="index.php?page=iconsets" method="post">
                <input type="hidden" name="id" value="<?php if (!empty($iconset['IconSetID'])) {
                                                            echo $iconset['IconSetID'];
                                                        } ?>" />
                <?php if (!empty($_GET['id']) && !empty($iconset['Icon'])) { ?>
                    <div>
                        <label for="icon">Huidig Icoon</label>
                        <img src="<?php echo $iconset['Icon'] ?>" alt="Icoon">
                    </div>
                <?php } ?>

                <div>
                    <label for="iconfile">Icoon Uploaden:</label>
                    <input id="iconfile" type="file" name="iconfile" accept=".gif,.jpg,.jpeg,.png,.svg" required />
                </div>

                <?php if (empty($_GET['id'])) { ?>
                    <button type="submit" name="action" value="create">Icon Set Toevoegen</button>
                <?php } else { ?>
                    <button type="submit" name="action" value="update">Icon Set Wijzigen</button>
                    <button type="submit" name="action" value="delete">Icon Set Verwijderen</button>
                <?php } ?>
                <a href="index.php?page=iconsets">
                    <div>
                        <p>Terug</p>
                    </div>
                </a>
            </form>
        </div>
    <?php } ?>
</main>