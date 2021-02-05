<!-- Users -->
<?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
    <h1 class="beheer-h1">Gebruikers</h1>
    <!-- List -->
    <?php if (count($users) == 0) { ?>
        <div class="info-box">
            <img src="../../assets/img/icons/Icon-Info-Blue.svg" alt="Blauw info icoon">
            <p>Geen Gebruikers toegevoegd.</p>
        </div>
    <?php } else { ?>
        <div class="grid-users">
            <div>
                <p>Naam</p>
            </div>
            <div>
                <p>E-mail</p>
            </div>
            <div>
                <p>Groep</p>
            </div>
            <div>
            </div>
        </div>
        <?php foreach ($users as $user) : ?>
            <div class="grid-users-data">
                <div>
                    <p class="grid-users-data--item"><?php echo $user['FirstName'] ?> <?php echo $user['LastName'] ?></p>
                </div>
                <div>
                    <p class="grid-users-data--item"><?php echo $user['Email'] ?></p>
                </div>
                <div>
                    <p class="grid-users-data--item"><?php echo $user['UserGroupName'] ?></p>
                </div>

                <a class="button-link button-bewerken" href="index.php?page=users&id=<?php echo $user['UserID'] ?>">
                    <div class="button-yellow">
                        <p>Bewerken</p>
                    </div>
                </a>

            </div>
        <?php endforeach ?>

    <?php } ?>

    <a class="button-aanmaken button-link" href="index.php?page=users&action=create">
        <div class="button-blue">
            <p>Gebruiker aanmaken</p>
        </div>
    </a>

<?php } else { ?>
    <div class="beheer-header-grid">
        <a class="button-link" href="index.php?page=users">
            <div class="button-blue button-back">
                <img src="../../assets/img/icons/icon-arrow-white.svg" alt="Pijl naar links icoon">
                <p>Gebruikers</p>
            </div>
        </a>
        <h1 class="beheer-h1">Gebruiker</h1>
    </div>
    <div class="beheren-flex">
        <!-- Detail -->
        <div class="gebruiker-form">
            <form class="form-grid" action="index.php?page=users" method="post">

                <input type="hidden" name="id" value="<?php if (!empty($user['UserID'])) {
                                                            echo $user['UserID'];
                                                        } ?>" />

                <div class="form-grid-items">
                    <label for="firstname">Voornaam</label>
                    <input id="firstname" type="text" name="firstname" placeholder="Voornaam" value="<?php if (!empty($user['FirstName'])) {
                                                                                                            echo $user['FirstName'];
                                                                                                        } ?>" minlength="3" maxlength="128" required />
                </div>
                <div class="form-grid-items">
                    <label for="lastname">Achternaam</label>
                    <input id="lastname" type="text" name="lastname" placeholder="Achternaam" value="<?php if (!empty($user['LastName'])) {
                                                                                                            echo $user['LastName'];
                                                                                                        } ?>" minlength="3" maxlength="129" required />
                </div>
                <div class="form-grid-items">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="voorbeeld@email.com" value="<?php if (!empty($user['Email'])) {
                                                                                                                echo $user['Email'];
                                                                                                            } ?>" minlength="3" maxlength="228" required />
                </div>
                <div class="form-grid-items">
                    <label for="login">Login</label>
                    <input id="login" type="text" name="login" placeholder="Login (e-mail)" value="<?php if (!empty($user['Login'])) {
                                                                                                        echo $user['Login'];
                                                                                                    } ?>" minlength="3" maxlength="64" required />
                </div>
                <div class="form-grid-items">
                    <label for="password">Wachtwoord</label>
                    <input id="password" type="text" name="password" placeholder="Wachtwoord" value="<?php if (!empty($user['Password'])) {
                                                                                                            echo $user['Password'];
                                                                                                        } ?>" minlength="3" maxlength="64" required />
                </div>
                <div class="form-grid-items">
                    <label for="usergroupid">Gebruikergroep</label>
                    <select id="usergroupid" name="usergroupid" required>
                        <?php foreach ($usergroups as $usergroup) : ?>
                            <option value="<?php echo $usergroup['UserGroupID']; ?>" <?php if (!empty($user['UserGroupID'])) {
                                                                                            echo $usergroup['UserGroupID'] === $user['UserGroupID'] ? "selected" : "";
                                                                                        } ?>><?php echo $usergroup['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <?php if (empty($_GET['id'])) { ?>
                    <button class="button-yellow button-submit-yellow" type="submit" name="action" value="create">Gebruiker Toevoegen</button>
                <?php } else { ?>
                    <div class="buttons-beheren">
                        <button class="button-white button-delete" type="submit" name="action" value="delete">Gebruiker Verwijderen</button>
                        <button class="button-blue button-submit" type="submit" name="action" value="update">Gebruiker Wijzigen</button>
                    </div>
                <?php } ?>


            </form>
        </div>
    </div>

<?php } ?>