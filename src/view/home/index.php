<h1 class="h1">Licht en Liefde Platform</h1>
<p>Vind informatie op het webplatform van Netwerk Licht en Liefde.</p>

<div class="flex-cards">
    <?php foreach ($categories as $category) : ?>
        <a class="cat-link" href="<?php if (empty($category['ExternalUrl'])) { ?>
                index.php?page=category&id=<?php echo $category['CategoryID'] ?>
                <?php } else { ?>
                    <?php echo $category['ExternalUrl']; ?>
                    <?php } ?>" <?php if (!empty($category['ExternalUrl'])) {
                                    echo "target=\"_blank\"";
                                } ?>>
            <div class="card-category">
                <div class="card-category--icon">
                    <?php if (strpos($category['Icon'], '.svg') !== false) { ?>
                        <?php echo file_get_contents(__DIR__ . '/' . $category['Icon']); ?>
                    <?php } else { ?>
                        <img src="<?php echo $category['Icon'] ?>" alt="Icoon">
                    <?php } ?>
                </div>
                <div class="card-category--label">
                    <p><?php echo $category['Name'] ?></p>
                </div>
            </div>
        </a>
    <?php endforeach ?>
</div>

<h2>Vragen of problemen?</h2>
<p>Contacteer Netwerk Licht en Liefde of chat met een hulpverlener.</p>

<div class="flex-cards">
    <a href="index.php?page=contact">
        <div class="card-contact">
            <div class="flex-icon"><img class="card-icon" src="../../assets/img/icons/contact.svg" alt="wit icoon van telefoon en mail"></div>
            <div class="card-contact--yellow">
                <p>Contact formulier</p>
            </div>
        </div>
    </a>
    <div class="card-contact">
        <div class="flex-icon"><img class="card-icon" src="../../assets/img/icons/chat.svg" alt="wit icoon van twee tekstbubbels met vraagteken en informatie teken"></div>
        <div class="card-contact--yellow">
            <p>Chat</p>
        </div>
    </div>
</div>