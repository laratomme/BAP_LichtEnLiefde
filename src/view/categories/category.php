<!-- Onderliggende Categories -->
<?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>
    <div>
        <!-- Manage Categorie -->
        <a class="button-aanmaken button-link" href="index.php?page=categories&id=<?php echo $category['CategoryID'] ?>">
            <div class="button-blue">
                <p>Categorie bewerken</p>
            </div>
        </a>
        <a class="button-aanmaken button-link" href="index.php?page=categories&action=create&parentid=<?php echo $category['CategoryID'] ?>">
            <div class="button-blue">
                <p>Sub-Categorie aanmaken</p>
            </div>
        </a>
        <?php if (empty($children) && empty($articles)) { ?>
            <a class="button-aanmaken button-link" href="index.php?page=categories&action=delete&id=<?php echo $category['CategoryID'] ?>&parentid=<?php echo $category['CategoryParentID'] ?>">
                <div class="button-blue">
                    <p>Categorie verwijderen</p>
                </div>
            </a>
        <?php } ?>
    </div>
<?php } ?>
<h1><?php echo $category['Name'] ?></h1>
<?php if (!empty($children)) { ?>
    <h2 class="header-grey-cat">Categorieën</h2>
    <div>
        <?php foreach ($children as $child) : ?>

            <a class="cat-link" href="index.php?page=category&id=<?php echo $child['CategoryID'] ?>">
                <div class="card-category">
                    <div class="card-category--icon">
                        <img src="<?php echo $child['Icon'] ?>" alt="Icoon naam">
                    </div>
                    <div class="card-category--label">
                        <p><?php echo $child['Name'] ?></p>
                    </div>
                </div>
            </a>

        <?php endforeach ?>
    </div>
<?php } ?>

<!-- Gelinkte Artikels -->
<?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>
    <div>
        <!-- Manage Artikels -->
        <a class="button-aanmaken button-link" href="index.php?page=articles&action=create&categoryid=<?php echo $category['CategoryID'] ?>">
            <div class="button-blue">
                <p>Artikel aanmaken</p>
            </div>
        </a>
    </div>
<?php } ?>

<?php if (!empty($articles)) { ?>
    <h2 class="header-grey-inhoud">Inhoud</h2>
    <div class="inhoud-lijst">
        <?php foreach ($articles as $article) : ?>
            <div class="inhoud-lijst-lijn"></div>
            <a class="inhoud-item" href="index.php?page=article&id=<?php echo $article['ArticleID'] ?>">
                <div>
                    <p><?php echo $article['Title'] ?></p>
                </div>
                <div class="inhoud-item-label">
                    <p><?php echo $article['ArticleTypeName'] ?></p>
                    <img src="<?php echo $article['Icon'] ?>" alt="Icoon">
                </div>
            </a>
            <div class="inhoud-lijst-lijn"></div>

            <div class="inhoud-lijst-lijn"></div>
            <a class="inhoud-item" href="index.php?page=article&id=<?php echo $article['ArticleID'] ?>">
                <div>
                    <p><?php echo $article['Title'] ?></p>
                </div>
                <div class="inhoud-item-label">
                    <p><?php echo $article['ArticleTypeName'] ?></p>
                    <img src="<?php echo $article['Icon'] ?>" alt="Icoon">
                </div>
            </a>
            <div class="inhoud-lijst-lijn"></div>

            <div class="inhoud-lijst-lijn"></div>
            <a class="inhoud-item" href="index.php?page=article&id=<?php echo $article['ArticleID'] ?>">
                <div>
                    <p><?php echo $article['Title'] ?></p>
                </div>
                <div class="inhoud-item-label">
                    <p><?php echo $article['ArticleTypeName'] ?></p>
                    <img src="<?php echo $article['Icon'] ?>" alt="Icoon">
                </div>
            </a>
        <?php endforeach ?>
    </div>
<?php } ?>