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
        <div> <img src="../../assets/img/logo-lichtenliefde-40px.png" alt="Logo Netwerk Licht en Liefde"></div>
        <div>
          <div><a href="index.php?page=contact">Contact</a><img src="../../assets/img/icons/icon-contact-blue-24px.svg" alt="Telefoon in chatballon icoon"></div>
          <a class="button-link" href="index.php?page=login">
            <div class="button-blue">
              <p>Login</p>
              <img src="../../assets/img/icons/icon-login-white-24px.svg" alt="Slot login icoon">
            </div>
          </a>
        </div>
      </div>

      <div class="search"></div>

      <nav class="beheerder-nav">
        <ul class="nav-list">
          <li><a class="nav-link" href="index.php?page=users">Gebruikers</a></li>
          <li><a class="nav-link" href="index.php?page=usergroups">Groepen</a></li>
          <li><a class="nav-link" href="index.php?page=categories">Categorieën</a></li>
          <li><a class="nav-link" href="index.php?page=contenttypes">Info Types</a></li>
          <li><a class="nav-link" href="index.php?page=articles">Artikels</a></li>
          <li><a class="nav-link" href="index.php?page=articletypes">Artikel types</a></li>
          <li><a class="nav-link" href="index.php?page=iconsets">Iconen</a></li>
        </ul>
      </nav>

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