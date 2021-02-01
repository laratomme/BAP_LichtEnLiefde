<!-- Usergroups -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <h1 class="h1">Gebruikers Groepen</h1>
        <!-- List -->
        <?php if (count($usergroups) == 0) { ?>
            <p class="info-tekst">Geen Gebruikers Groepen toegevoegd.</p>
        <?php } else { ?>
            <div class="grid-groups">
                <div>
                    <p>Groep naam</p>

                </div>
                <div>
                </div>
            </div>

            <?php foreach ($usergroups as $usergroup) : ?>

                <div class="grid-groups-data">
                    <div class="grid-groups-data--item">
                        <p><?php echo $usergroup['Name'] ?></p>
                    </div>

                    <a class="button-link button-bewerken" href="index.php?page=usergroups&id=<?php echo $usergroup['UserGroupID'] ?>">
                        <div class="button-yellow">
                            <p>Bekijk Usergroup</p>
                        </div>
                    </a>
                </div>

            <?php endforeach ?>

        <?php } ?>

        <a class="button-aanmaken button-link" href="index.php?page=usergroups&action=create">
            <div class="button-blue">
                <p>Gebruikers Groep aanmaken</p>
            </div>
        </a>

    <?php } else { ?>
        <h1 class="h1">Gebruikers Groep</h1>
        <a class="button-link"  href="index.php?page=usergroups">
            <div class="button-blue">
                <p>Terug</p>
            </div>
        </a>
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

            </form>
        </div>
    <?php } ?>
</main>