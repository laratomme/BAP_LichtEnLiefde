<!-- Article Types -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <h1 class="h1 header-beheren">Inhoud types</h1>
        <!-- List -->
        <?php if (count($articletypes) == 0) { ?>
            <p class="info-tekst">Geen Inhoud types toegevoegd.</p>
        <?php } else { ?>

            <div class="grid-types">
                <div>
                    <p>Naam</p>
                </div>
                <div>
                    <p>Beschrijving</p>
                </div>
                <div></div>
            </div>

            <?php foreach ($articletypes as $articletype) : ?>
                <div class="grid-types-data">
                    <div>
                        <p class="grid-types-data--item"><?php echo $articletype['Name'] ?></p>
                    </div>
                    <div>
                        <p class="grid-types-data--item"><?php echo $articletype['Description'] ?></p>
                    </div>

                    <a class="button-link button-bewerken" href="index.php?page=articletypes&id=<?php echo $articletype['ArticleTypeID'] ?>">
                        <div class="button-yellow">
                            <p>Bewerken</p>
                        </div>
                    </a>
                </div>

            <?php endforeach ?>

        <?php } ?>

        <a class="button-link button-aanmaken" href="index.php?page=articletypes&action=create">
            <div class="button-blue">
                <p>Type aanmaken</p>
            </div>
        </a>

    <?php } else { ?>
        <!-- Detail -->
        <div>
            <form enctype="multipart/form-data" action="index.php?page=articletypes" method="post">
                <input type="hidden" name="id" value="<?php if (!empty($articletype['ArticleTypeID'])) {
                                                            echo $articletype['ArticleTypeID'];
                                                        } ?>" />
                <input type="hidden" name="iconid" value="<?php if (!empty($articletype['IconID'])) {
                                                                echo $articletype['IconID'];
                                                            } ?>" />
                <div>
                    <label for="name">Naam</label>
                    <input id="name" type="text" name="name" placeholder="Artikel Type Naam" value="<?php if (!empty($articletype['Name'])) {
                                                                                                        echo $articletype['Name'];
                                                                                                    } ?>" minlength="3" maxlength="64" required />
                </div>
                <div>
                    <label for="description">Beschrijving</label>
                    <input id="description" type="text" name="description" placeholder="Artikel Type Beschrijving" value="<?php if (!empty($articletype['Description'])) {
                                                                                                                                echo $articletype['Description'];
                                                                                                                            } ?>" minlength="3" maxlength="128" />
                </div>

                <?php if (!empty($_GET['id']) && !empty($articletype['Icon'])) { ?>
                    <div>
                        <label for="icon">Huidig Icoon</label>
                        <img src="<?php echo $articletype['Icon'] ?>" alt="Icoon">
                    </div>

                    <div>
                        <label for="updateicon">Icoon Aanpassen:</label>
                        <input id="updateicon" type="checkbox" name="updateicon" />
                    </div>
                <?php } ?>

                <div>
                    <label for="iconsetid">Icoon Kiezen:</label>
                    <select id="iconsetid" name="iconsetid">
                        <option value> -- None chosen -- </option>
                        <?php foreach ($iconsets as $iconset) : ?>
                            <option value="<?php echo $iconset['IconSetID']; ?>"><?php echo $iconset['Icon'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div>
                    <label for="iconfile">Icoon Uploaden:</label>
                    <input id="iconfile" type="file" name="iconfile" accept=".gif,.jpg,.jpeg,.png,.svg" />
                </div>

                <?php if (empty($_GET['id'])) { ?>
                    <button type="submit" name="action" value="create">Artikel Type Toevoegen</button>
                <?php } else { ?>
                    <button type="submit" name="action" value="update">Artikel Type Wijzigen</button>
                    <button type="submit" name="action" value="delete">Artikel Type Verwijderen</button>
                <?php } ?>
                <a href="index.php?page=articletypes">
                    <div>
                        <p>Terug</p>
                    </div>
                </a>
            </form>
        </div>
    <?php } ?>
</main>