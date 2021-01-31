<!-- Users -->

<h1>Gebruikers</h1>
<?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
    <!-- List -->
    <?php if (count($users) == 0) { ?>
        <div>
            <p>Geen Users toegevoegd.</p>
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
                <div><p class="grid-users-data--item"><?php echo $user['FirstName'] ?> <?php echo $user['LastName'] ?></p></div>
                <div><p class="grid-users-data--item"><?php echo $user['Email'] ?></p></div>
                <div><p class="grid-users-data--item"><?php echo $user['UserGroupName'] ?></p></div>

                <a class="button-link button-bewerken" href="index.php?page=users&id=<?php echo $user['UserID'] ?>">
                    <div class="button-yellow">
                        <p>Bewerken</p>
                    </div>
                </a>

            </div>
        <?php endforeach ?>

    <?php } ?>

    <a class="button-gebruiker-aanmaken button-link" href="index.php?page=users&action=create">
        <div class="button-blue">
            <p>Gebruiker aanmaken</p>
        </div>
    </a>

<?php } else { ?>
    <!-- Detail -->
    <div>
        <form action="index.php?page=users" method="post">
            <input type="hidden" name="id" value="<?php if (!empty($user['UserID'])) {
                                                        echo $user['UserID'];
                                                    } ?>" />
            <div>
                <label for="firstname">Voornaam</label>
                <input id="firstname" type="text" name="firstname" placeholder="Voornaam" value="<?php if (!empty($user['FirstName'])) {
                                                                                                        echo $user['FirstName'];
                                                                                                    } ?>" minlength="3" maxlength="128" required />
            </div>
            <div>
                <label for="lastname">Achternaam</label>
                <input id="lastname" type="text" name="lastname" placeholder="Achternaam" value="<?php if (!empty($user['LastName'])) {
                                                                                                        echo $user['LastName'];
                                                                                                    } ?>" minlength="3" maxlength="129" required />
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" type="text" name="email" placeholder="Email" value="<?php if (!empty($user['Email'])) {
                                                                                            echo $user['Email'];
                                                                                        } ?>" minlength="3" maxlength="228" required />
            </div>
            <div>
                <label for="login">Login</label>
                <input id="login" type="text" name="login" placeholder="Login" value="<?php if (!empty($user['Login'])) {
                                                                                            echo $user['Login'];
                                                                                        } ?>" minlength="3" maxlength="64" required />
            </div>
            <div>
                <label for="password">Wachtwoord</label>
                <input id="password" type="text" name="password" placeholder="Wachtwoord" value="<?php if (!empty($user['Password'])) {
                                                                                                        echo $user['Password'];
                                                                                                    } ?>" minlength="3" maxlength="64" required />
            </div>
            <div>
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
                <button class="button-yellow" type="submit" name="action" value="create">Gebruiker Toevoegen</button>
            <?php } else { ?>
                <button class="button-yellow" type="submit" name="action" value="update">Gebruiker Wijzigen</button>
                <button class="button-yellow" type="submit" name="action" value="delete">Gebruiker Verwijderen</button>
            <?php } ?>

            <a class="button-link" href="index.php?page=users">
                <div class="button-blue">
                    <p>Terug</p>
                </div>
            </a>

        </form>
    </div>
<?php } ?>