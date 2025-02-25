<!DOCTYPE html>
<html lang="nl-be">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="favicon" type="image/png" src="../../assets/img/logo-lichtenliefde.png" />
  <title>Licht en Liefde Platform</title>
  <?php echo $css; ?>
</head>

<body class="<?php echo $_SESSION["uiData"]['Contrast'] ?> <?php echo $_SESSION["uiData"]['Font'] ?>">

  <div class="layout">

    <!-- Header -->
    <header class="header">
      <a class="skip-link" href='#main'>Naar de hoofdinhoud</a>
      <div class="header-items container">
        <a class="logo-lichtenliefde" href="index.php?page=layout">
          <img src="../../assets/img/logolichtenliefde.svg" alt="Home Licht en Liefde Platform">
        </a>
        <div class="header-buttons">
          <a class="button-link" href="index.php?page=contact">
            <div class="button-white">
              <p>Contact</p>
              <img src="../../assets/img/icons/contact-small.svg" alt="Telefoon in chatballon icoon">
            </div>
          </a>
          <?php if (empty($_SESSION["userData"])) { ?>
            <a class="button-link" href="index.php?page=login">
              <div class="button-blue">
                <p>Login</p>
                <img src="../../assets/img/icons/login.svg" alt="Gesloten slot login icoon">
              </div>
            </a>
          <?php } else { ?>
            <a class="button-link" href="index.php?page=login&action=logout">
              <div class="button-blue">
                <p>Logout</p>
                <img src="../../assets/img/icons/logout.svg" alt="Open slot logout icoon">
              </div>
            </a>
          <?php } ?>

        </div>
      </div>

      <!-- Zoekbar -->
      <div class="search">
        <div class="search-container">
          <a class="settings-link" href="index.php?page=settings">
            <img src="../../assets/img/icons/settings.svg" alt="Wit icoon instellingen">
            <p class="settings-p">Instellingen</p>
          </a>

          <form action="index.php?page=search" method="POST" class="search-wrap">
            <button class="search-speech-button button-blue" type="button">Spreek<?php echo file_get_contents(__DIR__ . '/../assets/img/icons/speak.svg'); ?></button>
            <input class="search-input" type="search" id="search" name="search" aria-label="Zoek doorheen het platform" placeholder="Ik zoek naar..." value="<?php if (!empty($_POST['search'])) {
                                                                                                                                                                echo $_POST['search'];
                                                                                                                                                              } ?>">
            <button class="button-link search-button">Zoeken <img class="search-icon" src="../../assets/img/icons/search.svg" alt="Vergrootglas zoek icoon"></button>
          </form>
        </div>
      </div>

      <?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>

        <!-- Admin (Beheerder) navigatie -->
        <nav class="beheerder-nav">
          <ul class="nav-list">
            <li><a class="nav-link" href="index.php?page=users">Gebruikers</a></li>
            <li><a class="nav-link" href="index.php?page=usergroups">Groepen</a></li>
            <li><a class="nav-link" href="index.php?page=categories">Categorieën</a></li>
            <li><a class="nav-link" href="index.php?page=articles">Inhoud</a></li>
            <li><a class="nav-link" href="index.php?page=articletypes">Inhoud types</a></li>
          </ul>
        </nav>
      <?php } ?>

    </header>

    <!-- Error / Info Pop-ups -->
    <?php
    if (!empty($_SESSION['error'])) {
      echo '<div class="error-box"> <img src="../../assets/img/icons/error-red.svg" alt="Rood error icoon">' . $_SESSION['error'] . '</div>';
    }
    if (!empty($_SESSION['info'])) {
      echo '<div class="info-box"> <img src="../../assets/img/icons/info-blue.svg" alt="Blauw info icoon">' . $_SESSION['info'] . '</div>';
    }
    ?>

    <!-- Breadcrumbs -->
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
          <span>,</span>

        <?php endforeach ?>
      </div>
    <?php } ?>

    <!-- Main Content -->
    <main class="main container" id="main">
      <?php echo $content; ?>
    </main>

    <!-- Footer -->
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
