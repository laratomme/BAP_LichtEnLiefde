<div>
    <?php foreach ($categories as $category) : ?>
        <a href="index.php?page=category&id=<?php echo $category['CategoryID'] ?>">
            <div><?php echo $category['CategoryID'] ?> - <?php echo $category['Name'] ?></div>
            <div>
                <img src="<?php echo $category['Icon'] ?>" alt="Icoon">
            </div>
            <div>
                <p>Bekijk Category</p>
            </div>
        </a>
    <?php endforeach ?>
</div>