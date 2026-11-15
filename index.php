<?php
// Catálogo público. El cliente puede añadir artículos al carrito (se guarda en la sesión).
require 'logica.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    exigir('cliente');
    $id = (int)post('id');
    $a = articulo_por_id($id);
    if ($a && $a['stock'] > 0) {
        // la cantidad en el carrito nunca supera el stock
        $_SESSION['carrito'][$id] = min(($_SESSION['carrito'][$id] ?? 0) + 1, $a['stock']);
        aviso('Artículo añadido al carrito.');
    }
    header('Location: index.php');
    exit;
}
$articulos = listar_articulos();
$titulo = 'Catálogo de zapatillas';
include 'cabecera.php';
?>
<div class="grid">
<?php foreach ($articulos as $a): ?>
  <article class="card">
    <h2><?= e($a['nombre']) ?></h2>
    <p class="mu"><?= e($a['marca']) ?></p>
    <p><?= e($a['descripcion']) ?></p>
    <p class="precio"><?= number_format($a['precio'], 2, ',', '.') ?> €</p>
    <p class="mu">Stock: <?= (int)$a['stock'] ?></p>
    <?php if (usuario() && usuario()['rol'] === 'cliente'): ?>
      <form method="post"><input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
        <button <?= $a['stock'] < 1 ? 'disabled' : '' ?>>Añadir al carrito</button></form>
    <?php elseif (!usuario()): ?>
      <a href="login.php">Accede para comprar</a>
    <?php endif; ?>
  </article>
<?php endforeach; ?>
</div>
<?php include 'pie.php'; ?>
