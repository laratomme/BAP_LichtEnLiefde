<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Licht en Liefde Platform</title>
  <?php echo $css; ?>
</head>

<body>

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

  <?php echo $js; ?>
</body>

</html>