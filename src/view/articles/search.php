<!-- Zoek Artikels -->
<?php if (!empty($articles)) { ?>
    <h1 class="h2 header-grey-zoek">Zoekresultaten</h1>
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
<?php } else { ?>
    <div class="info-box">
        <img src="../../assets/img/icons/info-blue.svg" alt="Blauw info icoon">
        <p>Geen zoekresultaten gevonden.</p>
    </div>
<?php } ?>
