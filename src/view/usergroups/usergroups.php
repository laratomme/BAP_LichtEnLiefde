<!-- Gebruiker Groepen -->
<?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
    <h1 class="beheer-h1">Gebruikers Groepen</h1>
    <!-- List -->
    <?php if (count($usergroups) == 0) { ?>
        <div class="info-box">
            <img src="../../assets/img/icons/info-blue.svg" alt="Blauw info icoon">
            <p>Geen Groepen toegevoegd.</p>
        </div>
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
                        <p>Bekijk groep</p>
                    </div>
                </a>
            </div>

        <?php endforeach ?>

    <?php } ?>

    <a class="button-aanmaken button-link" href="index.php?page=usergroups&action=create">
        <div class="button-blue">
            <p>Groep aanmaken</p>
        </div>
    </a>

<?php } else { ?>
    <div class="beheer-header-grid">
        <a class="button-link" href="index.php?page=usergroups">
            <div class="button-blue button-back">
                <img src="../../assets/img/icons/arrow.svg" alt="Pijl naar links icoon">
                <p>Groepen</p>
            </div>
        </a>
        <h1 class="beheer-h1">Gebruikers Groep</h1>
    </div>

    <!-- Detail -->
    <div class="groups-form">
        <form class="form-grid" action="index.php?page=usergroups" method="post">
            <input type="hidden" name="id" value="<?php if (!empty($usergroup['UserGroupID'])) {
                                                        echo $usergroup['UserGroupID'];
                                                    } ?>" />
            <div class="form-grid-items">
                <label for="name">Groep naam</label>
                <input id="name" type="text" name="name" placeholder="Groep naam" value="<?php if (!empty($usergroup['Name'])) {
                                                                                                echo $usergroup['Name'];
                                                                                            } ?>" minlength="3" maxlength="64" required />
            </div>
            <?php if (empty($_GET['id'])) { ?>
                <button class="button-yellow button-submit-yellow" type="submit" name="action" value="create">Groep Toevoegen</button>
            <?php } else { ?>
                <div class="buttons-beheren">
                    <button class="button-white button-delete" type="submit" name="action" value="delete">Groep Verwijderen</button>
                    <button class="button-blue button-submit" type="submit" name="action" value="update">Groep Wijzigen</button>
                </div>
            <?php } ?>

        </form>
    </div>
<?php } ?>
