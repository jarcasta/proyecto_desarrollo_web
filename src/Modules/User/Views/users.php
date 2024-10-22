<?php $title = 'Lista de Usuarios'; ?>
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
    <h2>Usuarios</h2>
    <a href="/usuario" class="btn btn-primary">Crear Nuevo Usuario</a>
</div>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= htmlspecialchars($usuario['id']) ?></td>
            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
            <td><?= htmlspecialchars($usuario['correo']) ?></td>
            <td>
                <a href="/usuario/<?= $usuario['id'] ?>" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Editar
                </a>
                <form id="delete-form-<?= $usuario['id'] ?>" method="post" action="/usuario/eliminar/<?= $usuario['id'] ?>" style="display:inline;">
                    <!-- CSRF Tokens (si los has implementado) -->
                    <input type="hidden" name="<?= htmlspecialchars($csrf['name_key']) ?>" value="<?= htmlspecialchars($csrf['name']) ?>">
                    <input type="hidden" name="<?= htmlspecialchars($csrf['value_key']) ?>" value="<?= htmlspecialchars($csrf['value']) ?>">
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeletion('delete-form-<?= $usuario['id'] ?>')">
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
        if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
            document.getElementById(formId).submit();
        }
    }
</script>

<?php 
$content = ob_get_clean(); 
include BASE_VIEW_PATH . 'layout.php'; 
?>
