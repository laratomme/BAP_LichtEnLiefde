<!-- Onderliggende Categorieën -->
<h1><?php echo $category['Name'] ?></h1>
<?php if (!empty($children)) { ?>
    <h2 class="header-grey-cat">Categorieën</h2>
    <div class="categories-flex">
        <?php foreach ($children as $child) : ?>

            <a class="cat-link" href="<?php if (empty($child['ExternalUrl'])) { ?>
                    index.php?page=category&id=<?php echo $child['CategoryID'] ?>
                    <?php } else { ?>
                        <?php echo $child['ExternalUrl']; ?>
                        <?php } ?>" <?php if (!empty($child['ExternalUrl'])) {
                                        echo "target=\"_blank\"";
                                    } ?>>
                <div class="card-category">
                    <div class="card-category--icon">
                        <?php if (strpos($child['Icon'], '.svg') !== false) { ?>
                            <?php echo file_get_contents(__DIR__ . '/' . $child['Icon']); ?>
                        <?php } else { ?>
                            <img src="<?php echo $child['Icon'] ?>" alt="<?php echo $child['Name'] ?>">
                        <?php } ?>
                    </div>
                    <div class="card-category--label">
                        <p><?php echo $child['Name'] ?></p>
                    </div>
                </div>
            </a>

        <?php endforeach ?>
    </div>
<?php } ?>

<!-- Manage Categorie -->
<?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>
    <div class="beheer-cat-flex">
        <a class="button-aanmaken button-link" href="index.php?page=categories&id=<?php echo $category['CategoryID'] ?>">
            <div class="button-blue">
                <p>Categorie bewerken</p>
                <img src="../../assets/img/icons/edit.svg" alt="Icoon bewerken folder met potlood">
            </div>
        </a>
        <a class="button-aanmaken button-link" href="index.php?page=categories&action=create&parentid=<?php echo $category['CategoryID'] ?>">
            <div class="button-blue">
                <p>Sub-Categorie aanmaken</p>
                <img src="../../assets/img/icons/add-category.svg" alt="Icoon toevoegen folder met plusteken">
            </div>
        </a>
        <?php if (empty($children) && empty($articles)) { ?>
            <a class="button-aanmaken button-link" href="index.php?page=categories&action=delete&id=<?php echo $category['CategoryID'] ?>&parentid=<?php echo $category['CategoryParentID'] ?>">
                <div class="button-blue">
                    <p>Categorie verwijderen</p>
                    <img src="../../assets/img/icons/delete-category.svg" alt="Icoon verwijderen folder met kruis">
                </div>
            </a>
        <?php } ?>
    </div>
<?php } ?>

<!-- Gelinkte Artikels -->
<?php if (!empty($articles)) { ?>
    <h2 class="header-grey-inhoud">Inhoud</h2>
    <div class="inhoud-lijst">
        <?php foreach ($articles as $article) : ?>
            <a class="inhoud-item" href="<?php if (empty($article['ExternalUrl'])) { ?>
                        index.php?page=article&id=<?php echo $article['ArticleID'] ?>
                    <?php } else { ?>
                        <?php echo $article['ExternalUrl']; ?>
                    <?php } ?>" <?php if (!empty($article['ExternalUrl'])) {
                                    echo "target=\"_blank\"";
                                } ?>>
                <div>
                    <p><?php echo $article['Title'] ?></p>
                </div>
                <div class="inhoud-item-label">
                    <p><?php echo $article['ArticleTypeName'] ?></p>
                    <img src="<?php echo $article['Icon'] ?>" alt="<?php echo $article['ArticleTypeName'] ?>">
                </div>
            </a>
            <div class="inhoud-lijst-lijn"></div>
        <?php endforeach ?>
    </div>
<?php } ?>

<!-- Manage Artikels -->
<?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>
    <div class="beheer-art-flex">
        <a class="button-aanmaken button-link" href="index.php?page=articles&action=create&categoryid=<?php echo $category['CategoryID'] ?>">
            <div class="button-blue">
                <p>Inhoud aanmaken</p>
                <img src="../../assets/img/icons/add-article.svg" alt="Icoon toevoegen van document met plus teken">
            </div>
        </a>
    </div>
<?php } ?>
