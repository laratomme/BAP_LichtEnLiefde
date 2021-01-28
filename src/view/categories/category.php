<!-- Onderliggende Categories -->
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

<!-- Gelinkte Artikels -->