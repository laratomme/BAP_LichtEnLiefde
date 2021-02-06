<!-- Categories -->
<?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
    <h1 class="beheer-h1">Categorieën</h1>
    <!-- List -->
    <?php if (count($categories) == 0) { ?>
        <div class="info-box">
            <img src="../../assets/img/icons/info-blue.svg" alt="Blauw info icoon">
            <p>Geen Categorieën toegevoegd.</p>
        </div>
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

    <div class="beheer-header-grid">
        <a class="button-link" href="index.php?page=categories">
            <div class="button-blue button-back">
                <img src="../../assets/img/icons/arrow.svg" alt="Pijl naar links icoon">
                <p>Categorieën</p>
            </div>
        </a>
        <h1 class="beheer-h1">Categorie</h1>
    </div>

    <!-- Detail -->
    <div class="categorie-form">
        <form class="form-grid" enctype="multipart/form-data" action="index.php?page=categories" method="post">
            <input type="hidden" name="id" value="<?php if (!empty($category['CategoryID'])) {
                                                        echo $category['CategoryID'];
                                                    } ?>" />
            <input type="hidden" name="iconid" value="<?php if (!empty($category['IconID'])) {
                                                            echo $category['IconID'];
                                                        } ?>" />
            <div class="form-grid-items">
                <label for="name">Naam</label>
                <input id="name" type="text" name="name" placeholder="Categorie naam" value="<?php if (!empty($category['Name'])) {
                                                                                                    echo $category['Name'];
                                                                                                } ?>" minlength="3" maxlength="64" required />
            </div>
            <div class="form-grid-items">
                <label for="description">Beschrijving</label>
                <input id="description" type="text" name="description" placeholder="Beschrijving" value="<?php if (!empty($category['Description'])) {
                                                                                                                echo $category['Description'];
                                                                                                            } ?>" minlength="3" maxlength="256" />
            </div>
            <div class="form-icon-upload">
                <label class="form-icon-upload-label" for="onmainmenu">Zichtbaar op hoofdmenu:</label>
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
                    <option value> -- Geen gebruikergroep -- </option>
                    <?php if (count($usergroups) > 0) { ?>
                        <?php foreach ($usergroups as $usergroup) : ?>
                            <option value="<?php echo $usergroup['UserGroupID']; ?>" <?php if (!empty($category['UserGroupID'])) {
                                                                                            echo $usergroup['UserGroupID'] === $category['UserGroupID'] ? "selected" : "";
                                                                                        } ?>><?php echo $usergroup['Name'] ?></option>
                        <?php endforeach ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-grid-items">
                <label for="externalurl">Externe Link</label>
                <input id="externalurl" type="text" name="externalurl" placeholder="Url" value="<?php if (!empty($category['ExternalUrl'])) {
                                                                                                    echo $category['ExternalUrl'];
                                                                                                } ?>" minlength="3" maxlength="256" />
            </div>

            <?php if (!empty($_GET['id']) && !empty($category['Icon'])) { ?>
                <div class="form-icon-upload">
                    <label class="form-icon-upload-label" for="icon">Huidig Icoon:</label>
                    <img src="<?php echo $category['Icon'] ?>" alt="Icoon">
                </div>

                <div class="form-icon-upload">
                    <label class="form-icon-upload-label" for="updateicon">Icoon Aanpassen:</label>
                    <input id="updateicon" type="checkbox" name="updateicon" />
                </div>
            <?php } ?>

            <div class="form-grid-items default-iconen">
                <div class="icoon-kiezen-p">
                    <p>Default iconen:</p>
                </div>

                <div class="icons-flex">
                    <label class="form-icon-label" for="iconinfo">
                        <input type="radio" id="iconinfo" name="defaulticon" value="../../assets/img/icons/category-info.svg">
                        <img src="../../assets/img/icons/category-info.svg">
                    </label>

                    <label class="form-icon-label" for="iconinfo2">
                        <input type="radio" id="iconinfo2" name="defaulticon" value="../../assets/img/icons/category-info.svg">
                        <img src="../../assets/img/icons/category-info.svg">
                    </label>

                    <label class="form-icon-label" for="iconinfo3">
                        <input type="radio" id="iconinfo3" name="defaulticon" value="../../assets/img/icons/category-info.svg">
                        <img src="../../assets/img/icons/category-info.svg">
                    </label>
                </div>
            </div>

            <div class="form-icon-upload">
                <label class="form-icon-upload-label" for="iconfile">Icoon Uploaden:</label>
                <input id="iconfile" type="file" name="iconfile" accept=".gif,.jpg,.jpeg,.png,.svg" />
            </div>

            <?php if (empty($_GET['id'])) { ?>
                <button class="button-yellow button-submit-yellow" type="submit" name="action" value="create">Categorie Toevoegen</button>
            <?php } else { ?>
                <div class="buttons-beheren">
                    <button class="button-white button-delete" type="submit" name="action" value="delete">Categorie Verwijderen</button>
                    <button class="button-blue button-submit" type="submit" name="action" value="update">Categorie Wijzigen</button>
                </div>
            <?php } ?>
        </form>
    </div>

<?php } ?>