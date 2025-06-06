<?php ob_start(); ?>
<!-- index.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal PGP-1 - Controle de Químicos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'templates_html/navbar.php'; ?>

  <div class="container mt-4">
    <?php
      $pagina = $_GET['pagina'] ?? 'home';
      $arquivo = "views/" . $pagina . ".php";
      if (file_exists($arquivo)) {
        include $arquivo;
      } else {
        echo "<div class='alert alert-warning'>Página não encontrada.</div>";
      }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>