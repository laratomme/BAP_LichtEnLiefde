<!-- Content Types -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <!-- List -->
        <?php if (count($contenttypes) == 0) { ?>
            <div>
                <p>Geen Content Types toegevoegd.</p>
            </div>
        <?php } else { ?>
            <div>
                <?php foreach ($contenttypes as $contenttype) : ?>
                    <div><?php echo $contenttype['ContentTypeID'] ?> - <?php echo $contenttype['Name'] ?> - <?php echo $contenttype['ContentName'] ?> - <?php echo $contenttype['MetaContentName'] ?></div>
                    <div><?php echo $contenttype['Wrap'] ?></div>
                    <div><?php echo $contenttype['IconID'] ?></div>
                    <div>
                        <a href="index.php?page=contenttypes&id=<?php echo $contenttype['ContentTypeID'] ?>">
                            <p>Bekijk Content Type</p>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        <?php } ?>
        <div>
            <a href="index.php?page=contenttypes&action=create">
                <div>
                    <p>Content Type aanmaken</p>
                </div>
            </a>
        </div>
    <?php } else { ?>
        <!-- Detail -->
        <div>
            <form enctype="multipart/form-data" action="index.php?page=contenttypes" method="post">
                <input type="hidden" name="id" value="<?php if (!empty($contenttype['ContentTypeID'])) {
                                                            echo $contenttype['ContentTypeID'];
                                                        } ?>" />
                <input type="hidden" name="iconid" value="<?php if (!empty($contenttype['IconID'])) {
                                                                echo $contenttype['IconID'];
                                                            } ?>" />
                <div>
                    <label for="name">Naam</label>
                    <input id="name" type="text" name="name" placeholder="Content Type Naam" value="<?php if (!empty($contenttype['Name'])) {
                                                                                                        echo $contenttype['Name'];
                                                                                                    } ?>" minlength="3" maxlength="64" required />
                </div>
                <div>
                    <label for="contentname">Naam van Content Tag</label>
                    <input id="contentname" type="text" name="contentname" placeholder="Naam van Content Tag" value="<?php if (!empty($contenttype['ContentName'])) {
                                                                                                                            echo $contenttype['ContentName'];
                                                                                                                        } ?>" minlength="3" maxlength="64" />
                </div>
                <div>
                    <label for="metacontentname">Naam van Meta Content Naam</label>
                    <input id="metacontentname" type="text" name="metacontentname" placeholder="Naam van Meta Content Tag" value="<?php if (!empty($contenttype['MetaContentName'])) {
                                                                                                                                        echo $contenttype['MetaContentName'];
                                                                                                                                    } ?>" minlength="3" maxlength="64" />
                </div>
                <div>
                    <label for="wrap">Wrap</label>
                    <input id="wrap" type="text" name="wrap" placeholder="Content Type Wrap" value="<?php if (!empty($contenttype['Wrap'])) {
                                                                                                        echo $contenttype['Wrap'];
                                                                                                    } ?>" minlength="3" maxlength="256" required />
                </div>

                <?php if (!empty($_GET['id']) && !empty($icon['Icon'])) { ?>
                    <div>
                        <label for="icon">Huidig Icoon</label>
                        <img src="<?php echo $icon['Icon'] ?>" alt="Icoon">
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
                    <button type="submit" name="action" value="create">Content Type Toevoegen</button>
                <?php } else { ?>
                    <button type="submit" name="action" value="update">Content Type Wijzigen</button>
                    <button type="submit" name="action" value="delete">Content Type Verwijderen</button>
                <?php } ?>
                <a href="index.php?page=contenttypes">
                    <div>
                        <p>Terug</p>
                    </div>
                </a>
            </form>
        </div>
    <?php } ?>
</main>