<!-- Artikel -->
<?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>
    <div>
        <!-- Manage Artikel -->
        <a class="button-aanmaken button-link" href="index.php?page=articles&id=<?php echo $article['ArticleID'] ?>">
            <div class="button-blue">
                <p>Artikel bewerken</p>
            </div>
        </a>
        <a class="button-aanmaken button-link" href="index.php?page=articles&action=delete&id=<?php echo $article['ArticleID']; ?>&categoryid=<?php echo $article['CategoryID']; ?>">
            <div class="button-blue">
                <p>Artikel verwijderen</p>
            </div>
        </a>
    </div>
<?php } ?>
<h1><?php echo $article['Title'] ?></h1>
<div>
    <div><?php echo $article['ArticleID'] ?> - <?php echo $article['Title'] ?></div>
    <div><?php echo $article['Content'] ?></div>
</div>