<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Licht en Liefde - <?php echo $title; ?></title>
    <?php echo $css;?>
  </head>
  <body>
    <main>
      <?php
        if(!empty($_SESSION['error'])) {
          echo '<div class="error box">' . $_SESSION['error'] . '</div>';
        }
        if(!empty($_SESSION['info'])) {
          echo '<div class="info box">' . $_SESSION['info'] . '</div>';
        }
      ?>
      <header><h1>Licht en Liefde - <?php echo $title; ?></h1></header>
      <?php echo $content;?>
    </main>
    <?php echo $js; ?>
  </body>
</html>
