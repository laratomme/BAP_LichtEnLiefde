<!-- Categorieën -->
<?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
  <h1 class="beheer-h1">Categorieën</h1>
  <!-- List -->
  <?php if (count($categories) == 0) { ?>
    <div class="info-box">
      <img src="../../assets/img/icons/info-blue.svg" alt="Blauw info icoon">
      <p>Geen Categorieën toegevoegd.</p>
    </div>
  <?php } else { ?>

    <!-- Lijst van Categorieën -->
    <div class="grid-categories">
      <div>
        <p>Naam</p>
      </div>
      <div>
        <p>Beschrijving</p>
      </div>
      <div>
        <p>Bovenliggende categorie</p>
      </div>
      <div>
        <p>Gebruikergroep</p>
      </div>
      <div>
      </div>
    </div>

    <?php foreach ($categories as $category) : ?>
      <div class="grid-categories-data">
        <div>
          <p class="grid-categories-data--item"><?php echo $category['Name'] ?></p>
        </div>
        <div>
          <p class="grid-categories-data--item"><?php echo $category['Description'] ?></p>
        </div>
        <div>
          <p class="grid-categories-data--item"><?php echo $category['CategoryParentName'] ?></p>
        </div>
        <div>
          <p class="grid-categories-data--item"><?php echo $category['UserGroupName'] ?></p>
        </div>

        <a class="button-link button-bewerken" href="index.php?page=categories&id=<?php echo $category['CategoryID'] ?>">
          <div class="button-yellow">
            <p>Bewerken</p>
          </div>
        </a>
      </div>

    <?php endforeach ?>

  <?php } ?>

  <a class="button-aanmaken button-link" href="index.php?page=categories&action=create">
    <div class="button-blue">
      <p>Categorie aanmaken</p>
    </div>
  </a>

<?php } else { ?>

  <!-- Detail -->
  <div class="beheer-header-grid">

    <div>
      <a class="button-link" href="index.php?page=categories">
        <div class="button-blue button-back">
          <img src="../../assets/img/icons/arrow.svg" alt="Pijl naar links icoon">
          <p>Categorieën</p>
        </div>
      </a>

      <?php if (!empty($_GET['id'])) { ?>
        <a class="button-link" href="index.php?page=category&id=<?php echo $category['CategoryID'] ?>">
          <div class="button-blue button-back">
            <img src="../../assets/img/icons/arrow.svg" alt="Pijl naar links icoon">
            <p>Bekijk categorie</p>
          </div>
        </a>
      <?php } ?>
    </div>

    <h1 class="beheer-h1">Categorie</h1>
  </div>

  <!-- Categorie aanmaken -->
  <div class="categorie-form">
    <form class="form-grid" enctype="multipart/form-data" action="index.php?page=categories" method="post">
      <input type="hidden" name="id" value="<?php if (!empty($category['CategoryID'])) {
                                              echo $category['CategoryID'];
                                            } ?>" />
      <input type="hidden" name="iconid" value="<?php if (!empty($category['IconID'])) {
                                                  echo $category['IconID'];
                                                } ?>" />
      <p>Vul alle velden in om een categorie aan te maken.</p>
      <div class="form-grid-items">
        <label for="name">Naam</label>
        <input id="name" type="text" name="name" placeholder="Categorie naam" value="<?php if (!empty($category['Name'])) {
                                                                                        echo $category['Name'];
                                                                                      } ?>" minlength="3" maxlength="64" required />
      </div>
      <div class="form-grid-items">
        <label for="description">Beschrijving <span class="optioneel">(optioneel)</span></label>
        <input id="description" type="text" name="description" placeholder="Beschrijving" value="<?php if (!empty($category['Description'])) {
                                                                                                    echo $category['Description'];
                                                                                                  } ?>" minlength="3" maxlength="256" />
      </div>
      <div class="form-icon-upload">
        <label class="form-icon-upload-label" for="onmainmenu">Zichtbaar op hoofdmenu: <span class="optioneel">(hoofdcategorie)</span></label>
        <input id="onmainmenu" type="checkbox" name="onmainmenu" class="toggle-reverse-zichtbaar" <?php if (!empty($category['OnMainMenu'])) {
                                                                                                    echo "checked";
                                                                                                  } ?> />
      </div>
      <div class="display-reverse-toggle <?php echo !empty($category['OnMainMenu']) ? "hidden" : ""; ?>">
        <div class="form-grid-items">
          <label for="categoryparent">Bovenliggende categorie <span class="optioneel">(subcategorie)</span></label>
          <select id="categoryparent" name="categoryparent" class="category-control">
            <option value> -- Geen bovenliggende categorie -- </option>
            <?php if (count($parents) > 0) { ?>
              <?php foreach ($parents as $parent) : ?>
                <option value="<?php echo $parent['CategoryID'] . '_' . $parent['UserGroupID']; ?>" <?php if (!empty($category['CategoryParentID'])) {
                                                                                                      echo $parent['CategoryID'] === $category['CategoryParentID'] ? "selected" : "";
                                                                                                    } ?>><?php echo $parent['Name'] ?></option>
              <?php endforeach ?>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-grid-items">
        <label for="usergroupid">Gebruikergroep <span class="optioneel">(zichtbaar voor)</span></label>
        <select id="usergroupid" name="usergroupid" class="usergroup-control" <?php echo !empty($category['ParentUserGroupID']) ? 'disabled' : ''; ?>>
          <option value> -- Geen gebruikergroep -- </option>
          <?php if (count($usergroups) > 0) { ?>
            <?php foreach ($usergroups as $usergroup) : ?>
              <option value="<?php echo $usergroup['UserGroupID']; ?>" <?php if (!empty($category['UserGroupID'])) {
                                                                          echo $usergroup['UserGroupID'] === $category['UserGroupID'] ? "selected" : "";
                                                                        } ?>><?php echo $usergroup['Name'] ?></option>
            <?php endforeach ?>
          <?php } ?>
        </select>
      </div>
      <div class="form-grid-items">
        <label for="externalurl">Externe Link <span class="optioneel">(optioneel)</span></label>
        <input id="externalurl" type="text" name="externalurl" placeholder="Url" value="<?php if (!empty($category['ExternalUrl'])) {
                                                                                          echo $category['ExternalUrl'];
                                                                                        } ?>" minlength="3" maxlength="256" />
      </div>

      <?php if (!empty($_GET['id']) && !empty($category['Icon'])) { ?>
        <div class="form-icon-upload">
          <label class="form-icon-upload-label" for="icon">Huidig Icoon:</label>
          <img src="<?php echo $category['Icon'] ?>" alt="Huidig Icoon">
        </div>

        <div class="form-icon-upload">
          <label class="form-icon-upload-label" for="updateicon">Icoon Aanpassen:</label>
          <input class="toggle-zichtbaar" id="updateicon" type="checkbox" name="updateicon" />
        </div>
      <?php } ?>

      <div class="default-iconen display-toggle <?php echo !empty($_GET['id']) && !empty($category['Icon']) ? "hidden" : ""; ?>">
        <div class="icoon-kiezen-p">
          <p>Default iconen:</p>
        </div>

        <div class="icons-flex">
          <label class="form-icon-label" for="icondefault4">
            <input type="radio" id="icondefault4" class="icon-picker default-icon" name="defaulticon" value="../../assets/img/icons/category-folder.svg" <?php echo empty($_GET['id']) ? "checked" : "" ?>>
            <img src="../../assets/img/icons/category-folder.svg">
          </label>

          <label class="form-icon-label" for="icondefault">
            <input type="radio" id="icondefault" class="icon-picker" name="defaulticon" value="../../assets/img/icons/category-binder.svg">
            <img src="../../assets/img/icons/category-binder.svg">
          </label>

          <label class="form-icon-label" for="icondefault2">
            <input type="radio" id="icondefault2" class="icon-picker" name="defaulticon" value="../../assets/img/icons/category-book.svg">
            <img src="../../assets/img/icons/category-book.svg">
          </label>

          <label class="form-icon-label" for="icondefault3">
            <input type="radio" id="icondefault3" class="icon-picker" name="defaulticon" value="../../assets/img/icons/category-clipboard.svg">
            <img src="../../assets/img/icons/category-clipboard.svg">
          </label>

          <label class="form-icon-label" for="icondefault5">
            <input type="radio" id="icondefault5" class="icon-picker" class="icon-picker" name="defaulticon" value="../../assets/img/icons/category-pc.svg">
            <img src="../../assets/img/icons/category-pc.svg">
          </label>

          <label class="form-icon-label" for="icondefault6">
            <input type="radio" id="icondefault6" class="icon-picker" name="defaulticon" value="../../assets/img/icons/category-person.svg">
            <img src="../../assets/img/icons/category-person.svg">
          </label>

          <label class="form-icon-label" for="icondefault7">
            <input type="radio" id="icondefault7" class="icon-picker" name="defaulticon" value="../../assets/img/icons/category-info.svg">
            <img src="../../assets/img/icons/category-info.svg">
          </label>
        </div>
      </div>

      <div class="display-toggle <?php echo !empty($_GET['id']) && !empty($category['Icon']) ? "hidden" : ""; ?>">
        <div class="form-icon-upload icoon-uploaden">
          <label class="form-icon-upload-label" for="iconfile">Icoon Uploaden: <span class="optioneel">(optioneel)</span></label>
          <input id="iconfile" class="custom-icon-picker" type="file" name="iconfile" accept=".gif,.jpg,.jpeg,.png,.svg" />
        </div>
      </div>

      <!-- Categorie beheren buttons -->
      <?php if (empty($_GET['id'])) { ?>
        <button class="button-yellow button-submit-yellow" type="submit" name="action" value="create">Categorie Toevoegen</button>
      <?php } else { ?>
        <div class="buttons-beheren">
          <button class="button-white button-delete" type="submit" name="action" value="delete">Categorie Verwijderen</button>
          <button class="button-blue button-submit" type="submit" name="action" value="update">Categorie Wijzigen</button>
        </div>
      <?php } ?>
    </form>
  </div>

<?php } ?>
