<!-- Onderliggende Categories -->
<?php if (!empty($children)) { ?>
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