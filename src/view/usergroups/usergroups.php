<!-- Usergroups -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <!-- List -->
        <?php if (count($usergroups) == 0) { ?>
            <div>
                <p>Geen Usergroups toegevoegd.</p>
            </div>
        <?php } else { ?>
            <div>
                <?php foreach ($usergroups as $usergroup) : ?>
                    <div><?php echo $usergroup['UserGroupID'] ?> - <?php echo $usergroup['Name'] ?></div>
                    <div>
                        <a href="index.php?page=usergroups&id=<?php echo $usergroup['UserGroupID'] ?>">
                            <p>Bekijk Usergroup</p>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        <?php } ?>
        <div>
            <a href="index.php?page=usergroups&action=create">
                <div>
                    <p>Usergroup aanmaken</p>
                </div>
            </a>
        </div>
    <?php } else { ?>
        <!-- Detail -->
        <div>
            <form action="index.php?page=usergroups" method="post">
                <input type="hidden" name="id" value="<?php if (!empty($usergroup['UserGroupID'])) {
                                                            echo $usergroup['UserGroupID'];
                                                        } ?>" />
                <div>
                    <label for="name">Naam</label>
                    <input id="name" type="text" name="name" placeholder="Usergroup Naam" value="<?php if (!empty($usergroup['Name'])) {
                                                                                                        echo $usergroup['Name'];
                                                                                                    } ?>" minlength="3" maxlength="64" required />
                </div>
                <?php if (empty($_GET['id'])) { ?>
                    <button type="submit" name="action" value="create">Usergroup Toevoegen</button>
                <?php } else { ?>
                    <button type="submit" name="action" value="update">Usergroup Wijzigen</button>
                    <button type="submit" name="action" value="delete">Usergroup Verwijderen</button>
                <?php } ?>
                <a href="index.php?page=usergroups">
                    <div>
                        <p>Terug</p>
                    </div>
                </a>
            </form>
        </div>
    <?php } ?>
</main>