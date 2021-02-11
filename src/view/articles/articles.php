<!-- Artikels (inhoud) -->
<!-- https://xdsoft.net/jodit/ -->
<?php if (empty($_GET['action']) && empty($_GET['id'])) { ?>
  <h1 class="beheer-h1">Inhoud lijst</h1>
  <!-- List -->
  <?php if (count($articles) == 0) { ?>
    <div class="info-box">
      <img src="../../assets/img/icons/info-blue.svg" alt="Blauw info icoon">
      <p>Geen inhoud toegevoegd.</p>
    </div>
  <?php } else { ?>

    <!-- Lijst van inhoud -->
    <div class="grid-articles">
      <div>
        <p>Titel</p>
      </div>
      <div>
        <p>Beschrijving</p>
      </div>
      <div>
        <p>Inhoud Type</p>
      </div>
      <div>
        <p>Categorie</p>
      </div>
      <div>
        <p>Gebruikergroep</p>
      </div>
    </div>

    <?php foreach ($articles as $article) : ?>
      <div class="grid-articles-data">
        <div>
          <p class="grid-articles-data--item"><?php echo $article['Title'] ?></p>
        </div>
        <div>
          <p class="grid-articles-data--item"><?php echo $article['Description'] ?></p>
        </div>
        <div>
          <p class="grid-articles-data--item"><?php echo $article['ArticleTypeName'] ?></p>
        </div>
        <div>
          <p class="grid-articles-data--item"><?php echo $article['CategoryName'] ?></p>
        </div>
        <div>
          <p class="grid-articles-data--item"><?php echo $article['UserGroupName'] ?></p>
        </div>

        <a class="button-bewerken button-link" href="index.php?page=articles&id=<?php echo $article['ArticleID'] ?>">
          <div class="button-yellow">
            <p>Bewerken</p>
          </div>
        </a>
      </div>

    <?php endforeach ?>

  <?php } ?>

  <a class="button-aanmaken button-link" href="index.php?page=articles&action=create">
    <div class="button-blue">
      <p>Inhoud aanmaken</p>
    </div>
  </a>

<?php } else { ?>

  <!-- Detail -->
  <div class="beheer-header-grid">

    <div>
      <a class="button-link" href="index.php?page=articles">
        <div class="button-blue button-back">
          <img src="../../assets/img/icons/arrow.svg" alt="Pijl naar links icoon">
          <p>Inhoud lijst</p>
        </div>
      </a>

      <?php if (!empty($_GET['id'])) { ?>
        <a class="button-link" href="index.php?page=article&id=<?php echo $article['ArticleID'] ?>">
          <div class="button-blue button-back">
            <img src="../../assets/img/icons/arrow.svg" alt="Pijl naar links icoon">
            <p>Bekijk inhoud</p>
          </div>
        </a>
      <?php } ?>
    </div>

    <h1 class="beheer-h1">Inhoud</h1>
  </div>

  <!-- Inhoud aanmaken -->
  <div class="artikels-form">
    <form action="index.php?page=articles" method="post">
      <div class="form-grid artikel-form-input">
        <input type="hidden" name="id" value="<?php if (!empty($article['ArticleID'])) {
                                                echo $article['ArticleID'];
                                              } ?>" />
        <p>Vul alle velden in om inhoud aan te maken.</p>
        <div class="form-grid-items">
          <label for="title">Titel</label>
          <input id="title" type="text" name="title" placeholder="Titel" value="<?php if (!empty($article['Title'])) {
                                                                                  echo $article['Title'];
                                                                                } ?>" minlength="3" maxlength="64" required />
        </div>
        <div class="form-grid-items">
          <label for="description">Beschrijving <span class="optioneel">(optioneel)</span></label>
          <input id="description" type="text" name="description" placeholder="Beschrijving" value="<?php if (!empty($article['Description'])) {
                                                                                                      echo $article['Description'];
                                                                                                    } ?>" minlength="3" maxlength="256" />
        </div>
        <div class="form-grid-items">
          <label for="articletypeid">Inhoud Type</label>
          <select id="articletypeid" name="articletypeid">
            <option value> -- Kies een Inhoud Type -- </option>
            <?php if (count($articletypes) > 0) { ?>
              <?php foreach ($articletypes as $articletype) : ?>
                <option value="<?php echo $articletype['ArticleTypeID']; ?>" <?php if (!empty($article['ArticleTypeID'])) {
                                                                                echo $articletype['ArticleTypeID'] === $article['ArticleTypeID'] ? "selected" : "";
                                                                              } ?>><?php echo $articletype['Name'] ?></option>
              <?php endforeach ?>
            <?php } ?>
          </select>
        </div>
        <div class="form-grid-items">
          <label for="category">Categorie</label>
          <select id="category" name="category" class="category-control">
            <option value> -- Kies een Categorie -- </option>
            <?php if (count($categories) > 0) { ?>
              <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['CategoryID'] . '_' . $category['UserGroupID']; ?>" <?php if (!empty($article['CategoryID'])) {
                                                                                                          echo $category['CategoryID'] === $article['CategoryID'] ? "selected" : "";
                                                                                                        } ?>><?php echo $category['Name'] ?></option>
              <?php endforeach ?>
            <?php } ?>
          </select>
        </div>
        <div class="form-grid-items">
          <label for="usergroupid">Gebruikergroep <span class="optioneel">(zichtbaar voor)</span></label>
          <select id="usergroupid" name="usergroupid" class="usergroup-control" <?php echo !empty($article['ParentUserGroupID']) ? 'disabled' : ''; ?>>
            <option value>Iedereen</option>
            <?php if (count($usergroups) > 0) { ?>
              <?php foreach ($usergroups as $usergroup) : ?>
                <option value="<?php echo $usergroup['UserGroupID']; ?>" <?php if (!empty($article['UserGroupID'])) {
                                                                            echo $usergroup['UserGroupID'] === $article['UserGroupID'] ? "selected" : "";
                                                                          } ?>><?php echo $usergroup['Name'] ?></option>
              <?php endforeach ?>
            <?php } ?>
          </select>
        </div>
        <div class="form-grid-items">
          <label for="externalurl">Externe Link <span class="optioneel">(optioneel)</span></label>
          <input id="externalurl" type="text" name="externalurl" placeholder="Externe Url" value="<?php if (!empty($article['ExternalUrl'])) {
                                                                                                    echo $article['ExternalUrl'];
                                                                                                  } ?>" minlength="3" maxlength="256" />
        </div>
      </div>

      <!-- Jodit Editor -->
      <div class="edit-area">
        <textarea id="area_editor" name="content"><?php if (!empty($article['Content'])) {
                                                    echo $article['Content'];
                                                  } ?></textarea>
      </div>

      <!-- Inhoud beheren buttons -->
      <div class="form-grid">
        <?php if (empty($_GET['id'])) { ?>
          <button class="button-yellow button-submit-yellow" type="submit" name="action" value="create">Inhoud Toevoegen</button>
        <?php } else { ?>
          <div class="buttons-beheren">
            <button class="button-white button-delete" type="submit" name="action" value="delete">Inhoud Verwijderen</button>
            <button class="button-blue button-submit" type="submit" name="action" value="update">Inhoud Wijzigen</button>
          </div>
        <?php } ?>
      </div>
    </form>
  </div>
<?php } ?>

<!-- Jodit Editor Script/ Styling -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js"></script>
<script>
  const editorController = document.querySelector('#area_editor')

  const init = () => {
    if (editorController) {
      let editor = new Jodit('#area_editor', {
        language: 'nl',
        textIcons: false,
        toolbarButtonSize: 'small',
        iframe: false,
        iframeStyle: '*,.jodit-wysiwyg {color:red;}',
        height: 500,
        defaultMode: Jodit.MODE_WYSIWYG,
        observer: {
          timeout: 100
        },
        uploader: {
          url: '/uploader.php',
          format: 'json',
          isSuccess: function(resp) {
            return !resp.error;
          },
          getMsg: function(resp) {
            return resp.msg.join !== undefined ? resp.msg.join(' ') : resp.msg;
          },
          process: function(resp) {
            return {
              files: resp['files'],
              tags: resp['tags'],
              error: resp.error,
              msg: resp.msg
            };
          },
          error: function(e) {
            this.events.fire('errorPopap', [e.getMessage(), 'error', 4000]);
          },
          defaultHandlerSuccess: function(data, resp) {
            if (data['files'] && data['files'].length) {
              for (let i = 0; i < data['files'].length; i += 1) {
                switch (data['tags'][i]) {
                  case 'img':
                    this.selection.insertImage(data['files'][i]);
                    break;
                  case 'video':
                    $html = '<video controls controlslist="nodownload" width="500" src="' + data['files'][i] + '">De Browser ondersteund geen video</video>';
                    this.selection.insertHTML($html);
                    break;
                  case 'audio':
                    $html = '<audio controls controlslist="nodownload" src="' + data['files'][i] + '">De Browser ondersteund geen audio</audio>';
                    this.selection.insertHTML($html);
                    break;
                  default:
                    $html = '<a class="article-link" href="' + data['files'][i] + '">' + data['files'][i] + '</a>';
                    this.selection.insertHTML($html);
                    break;
                }
              }
            }
          },
          defaultHandlerError: function(resp) {
            this.events.fire('errorPopap', [this.options.uploader.getMsg(resp)]);
          }
        },
        commandToHotkeys: {
          'openreplacedialog': 'ctrl+p'
        }
      });
    }
  }

  init();
</script>
