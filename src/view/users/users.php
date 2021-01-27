<!-- Users -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <!-- List -->
        <?php if (count($users) == 0) { ?>
            <div>
                <p>Geen Users toegevoegd.</p>
            </div>
        <?php } else { ?>
            <div>
                <?php foreach ($users as $user) : ?>
                    <div><?php echo $user['UserID'] ?> - <?php echo $user['FirstName'] ?> <?php echo $user['LastName'] ?></div>
                    <div><?php echo $user['Email'] ?> - <?php echo $user['Login'] ?> - <?php echo $user['Password'] ?></div>
                    <div><?php echo $user['UserGroupID'] ?></div>
                    <div>
                        <a href="index.php?page=users&id=<?php echo $user['UserID'] ?>">
                            <p>Bekijk Gebruiker</p>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        <?php } ?>
        <div>
            <a href="index.php?page=users&action=create">
                <div>
                    <p>Gebruiker aanmaken</p>
                </div>
            </a>
        </div>
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
                    <select id="usergroupid" name="usergroupid">
                        <?php foreach ($usergroups as $usergroup) : ?>
                            <option value="<?php echo $usergroup['UserGroupID']; ?>" <?php if (!empty($user['UserGroupID'])) {
                                                                                            echo $usergroup['UserGroupID'] === $user['UserGroupID'] ? "selected" : "";
                                                                                        } ?>><?php echo $usergroup['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <?php if (empty($_GET['id'])) { ?>
                    <button type="submit" name="action" value="create">Gebruiker Toevoegen</button>
                <?php } else { ?>
                    <button type="submit" name="action" value="update">Gebruiker Wijzigen</button>
                    <button type="submit" name="action" value="delete">Gebruiker Verwijderen</button>
                <?php } ?>
                <a href="index.php?page=users">
                    <div>
                        <p>Terug</p>
                    </div>
                </a>
            </form>
        </div>
    <?php } ?>
</main>