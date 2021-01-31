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
        <a class="logo" href="index.php?page=layout">Logo Licht en Liefde</a>
        <div class="header-buttons">
          <a class="button-link" href="index.php?page=contact">
            <div class="button-white">
              <p>Contact</p>
              <img src="../../assets/img/icons/icon-contact-blue.svg" alt="Telefoon in chatballon icoon">
            </div>
          </a>
          <?php if (empty($_SESSION["userData"])) { ?>
            <a class="button-link" href="index.php?page=login">
              <div class="button-yellow">
                <p>Login</p>
                <img src="../../assets/img/icons/icon-login-black.svg" alt="Slot login icoon">
              </div>
            </a>
          <?php } else { ?>
            <a class="button-link" href="index.php?page=login&action=logout">
              <div class="button-yellow">
                <p>Logout</p>
                <img src="../../assets/img/icons/icon-login-black.svg" alt="Slot login icoon">
              </div>
            </a>
          <?php } ?>

        </div>
      </div>

      <div class="search"></div>

      <?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["UserGroupID"] === -1) { ?>

        <nav class="beheerder-nav">
          <ul class="nav-list">
            <li><a class="nav-link" href="index.php?page=users">Gebruikers</a></li>
            <li><a class="nav-link" href="index.php?page=usergroups">Groepen</a></li>
            <li><a class="nav-link" href="index.php?page=categories">Categorieën</a></li>
            <li><a class="nav-link" href="index.php?page=articles">Artikels</a></li>
            <li><a class="nav-link" href="index.php?page=articletypes">Artikel types</a></li>
            <li><a class="nav-link" href="index.php?page=iconsets">Iconen</a></li>
          </ul>
        </nav>
      <?php } ?>

    </header>

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