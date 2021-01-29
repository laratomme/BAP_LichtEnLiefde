<h1>Licht en Liefde Platform</h1>
<p>Vind informatie op het webplatform van Netwerk Licht en Liefde.</p>

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

<h2>Vragen of problemen?</h2>
<p>Contacteer Netwerk Licht en Liefde of chat met een hulpverlener.</p>

<div class="flex">
    <div class="card-contact">
        <div>Icon</div>
        <div class="card-contact--yellow">
            <p>Contact formulier</p>
        </div>
    </div>
    <div class="card-contact">
        <div>Icon</div>
        <div class="card-contact--yellow">
            <p>Chat</p>
        </div>
    </div>
</div>