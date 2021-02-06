<!-- Artikel -->
<h1><?php echo $article['Title'] ?></h1>
<div>
    <div><?php echo $article['Content'] ?></div>
</div>

<?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>
    <div class="beheer-art-flex">
        <!-- Manage Artikel -->
        <a class="button-aanmaken button-link" href="index.php?page=articles&id=<?php echo $article['ArticleID'] ?>">
            <div class="button-blue">
                <p>Inhoud bewerken</p>
                <img src="../../assets/img/icons/edit.svg" alt="Icoon bewerken folder met potlood">
            </div>
        </a>
        <a class="button-aanmaken button-link" href="index.php?page=articles&action=delete&id=<?php echo $article['ArticleID']; ?>&categoryid=<?php echo $article['CategoryID']; ?>">
            <div class="button-blue">
                <p>Inhoud verwijderen</p>
                <img src="../../assets/img/icons/delete-article.svg" alt="Icoon verwijderen folder met kruis">
            </div>
        </a>
    </div>
<?php } ?>