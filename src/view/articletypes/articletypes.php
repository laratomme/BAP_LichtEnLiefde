<!-- Article Types -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <!-- List -->
        <?php if (count($articletypes) == 0) { ?>
            <div>
                <p>Geen Artikel Types toegevoegd.</p>
            </div>
        <?php } else { ?>
            <div>
                <?php foreach ($articletypes as $articletype) : ?>
                    <div><?php echo $articletype['ArticleTypeID'] ?> - <?php echo $articletype['Name'] ?> - <?php echo $articletype['Description'] ?></div>
                    <div><?php echo $articletype['IconID'] ?></div>
                    <div>
                        <a href="index.php?page=articletypes&id=<?php echo $articletype['ArticleTypeID'] ?>">
                            <p>Bekijk Artikel Type</p>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        <?php } ?>
        <div>
            <a href="index.php?page=articletypes&action=create">
                <div>
                    <p>Artikel Type aanmaken</p>
                </div>
            </a>
        </div>
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

                <?php if (!empty($_GET['id']) && !empty($icon['Icon'])) { ?>
                    <div>
                        <label for="icon">Huidig Icoon</label>
                        <img src="<?php echo $icon['Icon'] ?>" alt="Icoon">
                    </div>

                    <div>
                        <label for="updateicon">Icoon Aanpassen:</label>
                        <input id="updateicon" type="checkbox" name="updateicon" checked />
                    </div>
                <?php } ?>

                <div>
                    <label for="customicon">Icoon Uploaden:</label>
                    <input id="customicon" type="file" name="customicon" accept=".gif,.jpg,.jpeg,.png,.svg" />
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