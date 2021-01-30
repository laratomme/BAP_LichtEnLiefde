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

    <header>
      <p>logo</p>
      <nav></nav>
    </header>

    <div class="search">

    </div>

    <main class="main">
      <?php echo $content; ?>
    </main>

    <footer class="footer">
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
    </footer>

  </div>

  <?php echo $js; ?>

</body>

</html>