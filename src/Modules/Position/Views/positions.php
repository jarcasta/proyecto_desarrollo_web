<?php $title = 'Lista de Posiciones'; ?>
<?php ob_start(); ?>

<!-- Mostrar Flash Messages -->
<?php if (isset($flash['success'])): ?>
    <?php foreach ($flash['success'] as $message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($flash['error'])): ?>
    <?php foreach ($flash['error'] as $message): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Posiciones</h2>
    <a href="/posicion" class="btn btn-primary">Crear Nueva Posicion</a>
</div>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posiciones as $posicion): ?>
        <tr>
            <td><?= htmlspecialchars($posicion['id']) ?></td>
            <td><?= htmlspecialchars($posicion['name']) ?></td>
            <td>
                <a href="/posicion/<?= $posicion['id'] ?>" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Editar
                </a>
                <form id="delete-form-<?= $posicion['id'] ?>" method="post" action="/posicion/eliminar/<?= $posicion['id'] ?>" style="display:inline;">
                     <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeletion('delete-form-<?= $posicion['id'] ?>')">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function confirmDeletion(formId) {
        if (confirm('¿Estás seguro de que deseas eliminar este posicion?')) {
            document.getElementById(formId).submit();
        }
    }
</script>

<?php 
$content = ob_get_clean(); 
include BASE_VIEW_PATH . 'layout.php'; 
?>
