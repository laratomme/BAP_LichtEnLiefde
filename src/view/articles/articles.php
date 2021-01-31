<!-- Artikels -->
<!-- https://xdsoft.net/jodit/ -->
<?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
    <h1>Artikels</h1>
    <!-- List -->
    <?php if (count($articles) == 0) { ?>
        <div>
            <p>Geen Artikels toegevoegd.</p>
        </div>
    <?php } else { ?>

        <div class="grid-articles">
            <div>
                <p>Titel</p>
            </div>
            <div>
                <p>Beschrijving</p>
            </div>
            <div>
                <p>Artikel Type</p>
            </div>
            <div>
                <p>Categorie</p>
            </div>
            <div>
                <p>Gebruikers groep</p>
            </div>
        </div>

        <?php foreach ($articles as $article) : ?>
            <div class="grid-articles-data">
                <div>
                    <p class="grid-articles-data--item"><?php echo $article['Title'] ?></p>
                </div>
                <div>
                    <p class="grid-articles-data--item"><?php echo $article['Description'] ?></p>
                </div>
                <div>
                    <p class="grid-articles-data--item"><?php echo $article['ArticleTypeName'] ?></p>
                </div>
                <div>
                    <p class="grid-articles-data--item"><?php echo $article['CategoryName'] ?></p>
                </div>
                <div>
                    <p class="grid-articles-data--item"><?php echo $article['UserGroupName'] ?></p>
                </div>


                <a class="button-bewerken button-link" href="index.php?page=articles&id=<?php echo $article['ArticleID'] ?>">
                    <div class="button-yellow">
                        <p>Bewerken</p>
                    </div>
                </a>
            </div>

        <?php endforeach ?>

    <?php } ?>

    <a class="button-aanmaken button-link" href="index.php?page=articles&action=create">
        <div class="button-blue">
            <p>Artikel aanmaken</p>
        </div>
    </a>

<?php } else { ?>
    <h1>Artikel</h1>
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
                    <option value>Iedereen</option>
                    <?php foreach ($usergroups as $usergroup) : ?>
                        <option value="<?php echo $usergroup['UserGroupID']; ?>" <?php if (!empty($article['UserGroupID'])) {
                                                                                        echo $usergroup['UserGroupID'] === $article['UserGroupID'] ? "selected" : "";
                                                                                    } ?>><?php echo $usergroup['Name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div>
                <textarea id="area_editor" name="content"><?php if (!empty($article['Content'])) {
                                                                echo $article['Content'];
                                                            } ?></textarea>
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
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js"></script>
<!-- <link rel="stylesheet" href="../../css/jodit.min.css" />
<script src="../../js/jodit.min.js"></script> -->
<script>
    var editor = new Jodit('#area_editor', {
        language: 'nl',
        textIcons: false,
        toolbarButtonSize: 'small',
        iframe: false,
        iframeStyle: '*,.jodit-wysiwyg {color:red;}',
        minHeight: 300,
        maxHeight: 500,
        defaultMode: Jodit.MODE_WYSIWYG,
        observer: {
            timeout: 100
        },
        uploader: {
            // url: 'http://localhost:8888/upload.php',
            "insertImageAsBase64URI": true
        },
        commandToHotkeys: {
            'openreplacedialog': 'ctrl+p'
        }
        // buttons: ['symbol'],
        // disablePlugins: 'hotkeys,mobile'
    });
</script>