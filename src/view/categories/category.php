<!-- Onderliggende Categories -->
<?php if (!empty($children)) { ?>
    <div>
        <?php foreach ($children as $child) : ?>
            <a href="index.php?page=category&id=<?php echo $child['CategoryID'] ?>">
                <div><?php echo $child['CategoryID'] ?> - <?php echo $child['Name'] ?></div>
                <div>
                    <img src="<?php echo $child['Icon'] ?>" alt="Icoon">
                </div>
                <div>
                    <p>Bekijk Category</p>
                </div>
            </a>
        <?php endforeach ?>
    </div>
<?php } ?>

<!-- Gelinkte Artikels -->
<?php if (!empty($articles)) { ?>
    <div>
        <?php foreach ($articles as $article) : ?>
            <a href="index.php?page=article&id=<?php echo $article['ArticleID'] ?>">
                <div><?php echo $article['ArticleID'] ?> - <?php echo $article['Title'] ?></div>
                <div><?php echo $article['ArticleTypeName'] ?></div>
                <div>
                    <img src="<?php echo $article['Icon'] ?>" alt="Icoon">
                </div>
                <div>
                    <p>Bekijk Article</p>
                </div>
            </a>
        <?php endforeach ?>
    </div>
<?php } ?>