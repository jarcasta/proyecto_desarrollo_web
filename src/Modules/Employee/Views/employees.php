<?php $title = 'Lista de Empleados'; ?>
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
    <h2>Empleados</h2>
    <a href="/empleado" class="btn btn-primary">Crear Nuevo Empleado</a>
</div>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Foto</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Fecha de Nacimiento</th>
            <th>Puesto</th>
            <th>Salario</th>
            <th>Tienda</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($empleados as $empleado): ?>
        <tr>
            <td><?= htmlspecialchars($empleado['id']) ?></td>
            <td>
                <?php if ($empleado['photo_path']): ?>
                    <img src="/<?= htmlspecialchars($empleado['photo_path']) ?>" alt="Foto de <?= htmlspecialchars($empleado['first_name'] . ' ' . $empleado['last_name']) ?>" class="img-thumbnail" width="100">
                <?php else: ?>
                    <img src="/images/default_avatar.png" alt="Foto por Defecto" class="img-thumbnail" width="100">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($empleado['first_name']) ?></td>
            <td><?= htmlspecialchars($empleado['last_name']) ?></td>
            <td><?= htmlspecialchars($empleado['date_of_birth']) ?></td>
            <td><?= htmlspecialchars($empleado['position']) ?></td>
            <td>$<?= number_format($empleado['salary'], 2) ?></td>
            <td><?= htmlspecialchars($empleado['store']) ?></td>
            <td>
                <a href="/empleado/<?= $empleado['id'] ?>" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Editar
                </a>
                <form id="delete-form-<?= $empleado['id'] ?>" method="post" action="/empleado/eliminar/<?= $empleado['id'] ?>" style="display:inline;">
                    <!-- CSRF Tokens (si los has implementado) -->
                    <input type="hidden" name="<?= htmlspecialchars($csrf['name_key'] ?? '') ?>" value="<?= htmlspecialchars($csrf['name'] ?? '') ?>">
                    <input type="hidden" name="<?= htmlspecialchars($csrf['value_key'] ?? '') ?>" value="<?= htmlspecialchars($csrf['value'] ?? '') ?>">
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeletion('delete-form-<?= $empleado['id'] ?>')">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal para Confirmar Eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este empleado?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var deleteEmployeeId;

    var confirmDeleteModal = document.getElementById('confirmDeleteModal')
    confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        deleteEmployeeId = button.getAttribute('data-employee-id')
    })

    document.getElementById('confirmDeleteButton').addEventListener('click', function () {
        document.getElementById('delete-form-' + deleteEmployeeId).submit()
    })

    function confirmDeletion(formId) {
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'))
        deleteModal.show()
        deleteEmployeeId = formId.split('-').pop()
    }
</script>

<?php $content = ob_get_clean(); ?>
<?php include BASE_VIEW_PATH . 'layout.php'; ?>
