<!-- Zoek Artikels -->
<?php if (!empty($articles)) { ?>
    <h2 class="header-grey-inhoud">Zoekresultaten</h2>
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
                    <img src="<?php echo $article['Icon'] ?>" alt="Icoon">
                </div>
            </a>
            <div class="inhoud-lijst-lijn"></div>
        <?php endforeach ?>
    </div>
<?php } else { ?>
    <div class="info-box">
        <img src="../../assets/img/icons/info-blue.svg" alt="Blauw info icoon">
        <p>Geen resultaten gevonden.</p>
    </div>
<?php } ?>