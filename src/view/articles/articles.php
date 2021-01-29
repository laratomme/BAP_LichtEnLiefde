<!-- Artikels -->
<main>
    <?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
        <!-- List -->
        <?php if (count($articles) == 0) { ?>
            <div>
                <p>Geen Artikels toegevoegd.</p>
            </div>
        <?php } else { ?>
            <div>
                <?php foreach ($articles as $article) : ?>
                    <div><?php echo $article['ArticleID'] ?> - <?php echo $article['Title'] ?></div>
                    <div><?php echo $article['Description'] ?></div>
                    <div><?php echo $article['ArticleTypeID'] ?> - <?php echo $article['CategoryID'] ?> - <?php echo $article['UserGroupID'] ?></div>
                    <div>
                        <a href="index.php?page=articles&id=<?php echo $article['ArticleID'] ?>">
                            <p>Bekijk Artikel</p>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        <?php } ?>
        <div>
            <a href="index.php?page=articles&action=create">
                <div>
                    <p>Artikel aanmaken</p>
                </div>
            </a>
        </div>
    <?php } else { ?>
        <!-- Detail -->
        <div>
            <form action="index.php?page=articles" method="post">
                <input type="hidden" name="id" value="<?php if (!empty($article['ArticleID'])) {
                                                            echo $article['ArticleID'];
                                                        } ?>" />
                <div>
                    <label for="title">Titel</label>
                    <input id="title" type="text" name="title" placeholder="Titel" value="<?php if (!empty($article['Title'])) {
                                                                                                echo $article['Title'];
                                                                                            } ?>" minlength="3" maxlength="64" required />
                </div>
                <div>
                    <label for="description">Omschrijving</label>
                    <input id="description" type="text" name="description" placeholder="Omschrijving" value="<?php if (!empty($article['Description'])) {
                                                                                                                    echo $article['Description'];
                                                                                                                } ?>" minlength="3" maxlength="256" />
                </div>
                <div>
                    <label for="articletypeid">Artikel Type</label>
                    <select id="articletypeid" name="articletypeid">
                        <option value> -- Kies een Artikel Type -- </option>
                        <?php foreach ($articletypes as $articletype) : ?>
                            <option value="<?php echo $articletype['ArticleTypeID']; ?>" <?php if (!empty($article['ArticleTypeID'])) {
                                                                                                echo $articletype['ArticleTypeID'] === $article['ArticleTypeID'] ? "selected" : "";
                                                                                            } ?>><?php echo $articletype['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div>
                    <label for="categoryid">Category</label>
                    <select id="categoryid" name="categoryid">
                        <option value> -- Kies een Category -- </option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['CategoryID']; ?>" <?php if (!empty($article['CategoryID'])) {
                                                                                        echo $category['CategoryID'] === $article['CategoryID'] ? "selected" : "";
                                                                                    } ?>><?php echo $category['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div>
                    <label for="usergroupid">Gebruikergroep</label>
                    <select id="usergroupid" name="usergroupid">
                        <option value> -- Users -- </option>
                        <?php foreach ($usergroups as $usergroup) : ?>
                            <option value="<?php echo $usergroup['UserGroupID']; ?>" <?php if (!empty($article['UserGroupID'])) {
                                                                                            echo $usergroup['UserGroupID'] === $article['UserGroupID'] ? "selected" : "";
                                                                                        } ?>><?php echo $usergroup['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <?php if (empty($_GET['id'])) { ?>
                    <button type="submit" name="action" value="create">Artikel Toevoegen</button>
                <?php } else { ?>
                    <button type="submit" name="action" value="update">Artikel Wijzigen</button>
                    <button type="submit" name="action" value="delete">Artikel Verwijderen</button>
                <?php } ?>
                <a href="index.php?page=articles">
                    <div>
                        <p>Terug</p>
                    </div>
                </a>
            </form>
        </div>
    <?php } ?>
</main>