<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Licht en Liefde Platform</title>
  <?php echo $css; ?>
</head>

<body>

  <div class="layout">

    <?php
    if (!empty($_SESSION['error'])) {
      echo '<div class="error box">' . $_SESSION['error'] . '</div>';
    }
    if (!empty($_SESSION['info'])) {
      echo '<div class="info box">' . $_SESSION['info'] . '</div>';
    }
    ?>

    <header class="header">
      <div class="header-items container">
        <a class="logo-lichtenliefde" href="index.php?page=layout">
          <img src="../../assets/img/logolichtenliefde.svg" alt="Home Licht en Liefde Platform">
        </a>
        <div class="header-buttons">
          <a class="button-link" href="index.php?page=contact">
            <div class="button-white">
              <p>Contact</p>
              <img src="../../assets/img/icons/icon-contact-blue.svg" alt="Telefoon in chatballon icoon">
            </div>
          </a>
          <?php if (empty($_SESSION["userData"])) { ?>
            <a class="button-link" href="index.php?page=login">
              <div class="button-blue">
                <p>Login</p>
                <img src="../../assets/img/icons/icon-login-white.svg" alt="Gesloten slot login icoon">
              </div>
            </a>
          <?php } else { ?>
            <a class="button-link" href="index.php?page=login&action=logout">
              <div class="button-blue">
                <p>Logout</p>
                <img src="../../assets/img/icons/icon-logout-white.svg" alt="Open slot logout icoon">
              </div>
            </a>
          <?php } ?>

        </div>
      </div>

      <div class="search">

        <div class="search-container">
          <a class="settings" href="index.php?page=settings">
            <img src="../../assets/img/icons/icon-settings-white.svg" alt="Wit icoon instellingen">
            <p class="hidden">Instellingen</p>
          </a>

          <div class="search-wrap">
            <input class="search-input" type="search" id="search" name="search" aria-label="Zoek doorheen het platform" placeholder="Ik zoek naar...">
            <button class="button-link search-button">Zoeken <img class="search-icon" src="../../assets/img/icons/icon-zoeken-zwart.svg" alt="Zwart vergrootglas zoek icoon"></button>
          </div>
        </div>

      </div>

      <?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>

        <nav class="beheerder-nav">
          <ul class="nav-list">
            <li><a class="nav-link" href="index.php?page=users">Gebruikers</a></li>
            <li><a class="nav-link" href="index.php?page=usergroups">Groepen</a></li>
            <li><a class="nav-link" href="index.php?page=categories">Categorieën</a></li>
            <li><a class="nav-link" href="index.php?page=articles">Artikels</a></li>
            <li><a class="nav-link" href="index.php?page=articletypes">Artikel types</a></li>
          </ul>
        </nav>
      <?php } ?>

    </header>

    <?php if (!empty($crumbs)) { ?>
      <div class="breadcrumbs container">
        <p>U bevindt zich op</p>
        <?php foreach ($crumbs as $crumb) : ?>

          <a href="<?php if (!empty($crumb['id'])) {
                      echo "index.php?page=" . $crumb['page'] . "&id=" . $crumb['id'];
                    } else {
                      echo "index.php?page=" . $crumb['page'];
                    } ?>">
            <?php echo $crumb['name']; ?>
          </a>

        <?php endforeach ?>
      </div>
    <?php } ?>

    <main class="main container">
      <?php echo $content; ?>
    </main>

    <footer class="footer">
      <div class="container">
        <address>
          <div class="address-item">
            <p>Licht en Liefde</p>
            <span class="vl"></span>
          </div>

          <div class="address-item">
            <p>Oudenburgweg 40, 8490 Varsenare</p>
            <span class="vl"></span>
          </div>

          <div class="address-item">
            <p>+32 (0)50 40 60 50</p>
            <span class="vl"></span>
          </div>

          <div class="address-item">
            <a href="mailto:info@lichtenliefde.be">E-mail: info@lichtenliefde.be</a>
          </div>

        </address>
      </div>
    </footer>

  </div>

  <?php echo $js; ?>

</body>

</html>