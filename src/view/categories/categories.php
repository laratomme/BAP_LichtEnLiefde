<!-- Categories -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <h1 class="h1 header-beheren">Categorieën</h1>
        <!-- List -->
        <?php if (count($categories) == 0) { ?>
            <p class="info-tekst">Geen Categorieën toegevoegd.</p>
        <?php } else { ?>

            <div class="grid-categories">
                <div>
                    <p>Naam</p>
                </div>
                <div>
                    <p>Beschrijving</p>
                </div>
                <div>
                    <p>Bovenliggende categorie</p>
                </div>
                <div>
                    <p>Gebruikergroep</p>
                </div>
                <div>
                </div>
            </div>

            <?php foreach ($categories as $category) : ?>
                <div class="grid-categories-data">
                    <div>
                        <p class="grid-categories-data--item"><?php echo $category['Name'] ?></p>
                    </div>
                    <div>
                        <p class="grid-categories-data--item"><?php echo $category['Description'] ?></p>
                    </div>
                    <div>
                        <p class="grid-categories-data--item"><?php echo $category['CategoryParentName'] ?></p>
                    </div>
                    <div>
                        <p class="grid-categories-data--item"><?php echo $category['UserGroupID'] ?></p>
                    </div>

                    <a class="button-link button-bewerken" href="index.php?page=categories&id=<?php echo $category['CategoryID'] ?>">
                        <div class="button-yellow">
                            <p>Bewerken</p>
                        </div>
                    </a>
                </div>

            <?php endforeach ?>

        <?php } ?>

        <a class="button-aanmaken button-link" href="index.php?page=categories&action=create">
            <div class="button-blue">
                <p>Categorie aanmaken</p>
            </div>
        </a>

    <?php } else { ?>
        <a class="button-link" href="index.php?page=categories">
            <div class="button-blue button-back">
                <img src="../../assets/img/icons/icon-arrow-white.svg" alt="Pijl naar links icoon">
                <p>Categorieën</p>
            </div>
        </a>
        <!-- Detail -->
        <div class="categorie-form">
            <h1 class="h1">Categorie</h1>
            <form class="form-grid" enctype="multipart/form-data" action="index.php?page=categories" method="post">
                <input type="hidden" name="id" value="<?php if (!empty($category['CategoryID'])) {
                                                            echo $category['CategoryID'];
                                                        } ?>" />
                <input type="hidden" name="iconid" value="<?php if (!empty($category['IconID'])) {
                                                                echo $category['IconID'];
                                                            } ?>" />
                <div class="form-grid-items">
                    <label for="name">Naam</label>
                    <input id="name" type="text" name="name" placeholder="Categorie Naam" value="<?php if (!empty($category['Name'])) {
                                                                                                        echo $category['Name'];
                                                                                                    } ?>" minlength="3" maxlength="64" required />
                </div>
                <div class="form-grid-items">
                    <label for="description">Beschrijving</label>
                    <input id="description" type="text" name="description" placeholder="Beschrijving" value="<?php if (!empty($category['Description'])) {
                                                                                                                    echo $category['Description'];
                                                                                                                } ?>" minlength="3" maxlength="256" />
                </div>
                <div class="form-grid-items">
                    <label for="onmainmenu">Zichtbaar op hoofdmenu:</label>
                    <input id="onmainmenu" type="checkbox" name="onmainmenu" <?php if (!empty($category['OnMainMenu'])) {
                                                                                    echo "checked";
                                                                                } ?> />
                </div>
                <div class="form-grid-items">
                    <label for="categoryparentid">Bovenliggende categorie</label>
                    <select id="categoryparentid" name="categoryparentid">
                        <option value> -- Geen bovenliggende categorie -- </option>
                        <?php if (count($parents) > 0) { ?>
                            <?php foreach ($parents as $parent) : ?>
                                <option value="<?php echo $parent['CategoryID']; ?>" <?php if (!empty($category['CategoryParentID'])) {
                                                                                            echo $parent['CategoryID'] === $category['CategoryParentID'] ? "selected" : "";
                                                                                        } ?>><?php echo $parent['Name'] ?></option>
                            <?php endforeach ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-grid-items">
                    <label for="usergroupid">Gebruikergroep</label>
                    <select id="usergroupid" name="usergroupid">
                        <option value> -- Users -- </option>
                        <?php if (count($usergroups) > 0) { ?>
                            <?php foreach ($usergroups as $usergroup) : ?>
                                <option value="<?php echo $usergroup['UserGroupID']; ?>" <?php if (!empty($category['UserGroupID'])) {
                                                                                                echo $usergroup['UserGroupID'] === $category['UserGroupID'] ? "selected" : "";
                                                                                            } ?>><?php echo $usergroup['Name'] ?></option>
                            <?php endforeach ?>
                        <?php } ?>
                    </select>
                </div>

                <?php if (!empty($_GET['id']) && !empty($category['Icon'])) { ?>
                    <div class="form-grid-items">
                        <label for="icon">Huidig Icoon</label>
                        <img src="<?php echo $category['Icon'] ?>" alt="Icoon">
                    </div>

                    <div class="form-grid-items">
                        <label for="updateicon">Icoon Aanpassen:</label>
                        <input id="updateicon" type="checkbox" name="updateicon" />
                    </div>
                <?php } ?>

                <div class="form-grid-items">
                    <label for="iconsetid">Icoon Kiezen:</label>
                    <select id="iconsetid" name="iconsetid">
                        <option value> -- None chosen -- </option>
                        <?php foreach ($iconsets as $iconset) : ?>
                            <option value="<?php echo $iconset['IconSetID']; ?>"><?php echo $iconset['Icon'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-grid-items">
                    <label for="iconfile">Icoon Uploaden:</label>
                    <input id="iconfile" type="file" name="iconfile" accept=".gif,.jpg,.jpeg,.png,.svg" />
                </div>

                <?php if (empty($_GET['id'])) { ?>
                    <button class="button-yellow button-submit-yellow" type="submit" name="action" value="create">Category Toevoegen</button>
                <?php } else { ?>
                    <button class="button-white button-delete" type="submit" name="action" value="delete">Category Verwijderen</button>
                    <button class="button-blue button-submit" type="submit" name="action" value="update">Category Wijzigen</button>
                <?php } ?>

            </form>
        </div>
    <?php } ?>
</main>