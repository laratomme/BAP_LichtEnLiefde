<!-- Usergroup Overview -->
<div>
    <?php foreach ($usergroups as $usergroup) : ?>
        <div><?php echo $usergroup['UserGroupID'] ?> - <?php echo $usergroup['Name'] ?></div>
    <?php endforeach ?>
</div>