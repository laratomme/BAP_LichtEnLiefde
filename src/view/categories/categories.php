<!-- Categories -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <!-- List -->
        <?php if (count($categories) == 0) { ?>
            <div>
                <p>Geen Categories toegevoegd.</p>
            </div>
        <?php } else { ?>
            <div>
                <?php foreach ($categories as $category) : ?>
                    <div><?php echo $category['CategoryID'] ?> - <?php echo $category['Name'] ?> - <?php echo $category['OnMainMenu'] ?></div>
                    <div><?php echo $category['Description'] ?></div>
                    <div><?php echo $category['CategoryParentID'] ?> - <?php echo $category['CategoryParentName'] ?> - <?php echo $category['UserGroupID'] ?> - <?php echo $category['IconID'] ?></div>
                    <div>
                        <a href="index.php?page=categories&id=<?php echo $category['CategoryID'] ?>">
                            <p>Bekijk Category</p>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        <?php } ?>
        <div>
            <a href="index.php?page=categories&action=create">
                <div>
                    <p>Category aanmaken</p>
                </div>
            </a>
        </div>
    <?php } else { ?>
        <!-- Detail -->
        <div>
            <form enctype="multipart/form-data" action="index.php?page=categories" method="post">
                <input type="hidden" name="id" value="<?php if (!empty($category['CategoryID'])) {
                                                            echo $category['CategoryID'];
                                                        } ?>" />
                <input type="hidden" name="iconid" value="<?php if (!empty($category['IconID'])) {
                                                                echo $category['IconID'];
                                                            } ?>" />
                <div>
                    <label for="name">Naam</label>
                    <input id="name" type="text" name="name" placeholder="Category Naam" value="<?php if (!empty($category['Name'])) {
                                                                                                    echo $category['Name'];
                                                                                                } ?>" minlength="3" maxlength="64" required />
                </div>
                <div>
                    <label for="description">Omschrijving</label>
                    <input id="description" type="text" name="description" placeholder="Omschrijving" value="<?php if (!empty($category['Description'])) {
                                                                                                                    echo $category['Description'];
                                                                                                                } ?>" minlength="3" maxlength="256" />
                </div>

                <div>
                    <label for="onmainmenu">Zichtbaar op hoofdmenu:</label>
                    <input id="onmainmenu" type="checkbox" name="onmainmenu" <?php if (!empty($category['OnMainMenu'])) {
                                                                                    echo "checked";
                                                                                } ?> />
                </div>

                <div>
                    <label for="categoryparentid">Parent Category</label>
                    <select id="categoryparentid" name="categoryparentid">
                        <option value> -- No Parent -- </option>
                        <?php foreach ($parents as $parent) : ?>
                            <option value="<?php echo $parent['CategoryID']; ?>" <?php if (!empty($category['CategoryParentID'])) {
                                                                                        echo $parent['CategoryID'] === $category['CategoryParentID'] ? "selected" : "";
                                                                                    } ?>><?php echo $parent['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div>
                    <label for="usergroupid">Gebruikergroep</label>
                    <select id="usergroupid" name="usergroupid">
                        <option value> -- Users -- </option>
                        <?php foreach ($usergroups as $usergroup) : ?>
                            <option value="<?php echo $usergroup['UserGroupID']; ?>" <?php if (!empty($category['UserGroupID'])) {
                                                                                            echo $usergroup['UserGroupID'] === $category['UserGroupID'] ? "selected" : "";
                                                                                        } ?>><?php echo $usergroup['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <?php if (!empty($_GET['id']) && !empty($category['Icon'])) { ?>
                    <div>
                        <label for="icon">Huidig Icoon</label>
                        <img src="<?php echo $category['Icon'] ?>" alt="Icoon">
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
                    <button type="submit" name="action" value="create">Category Toevoegen</button>
                <?php } else { ?>
                    <button type="submit" name="action" value="update">Category Wijzigen</button>
                    <button type="submit" name="action" value="delete">Category Verwijderen</button>
                <?php } ?>
                <a href="index.php?page=categories">
                    <div>
                        <p>Terug</p>
                    </div>
                </a>
            </form>
        </div>
    <?php } ?>
</main>