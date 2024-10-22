<?php $title = 'Logros y Llamadas de Atención'; ?>
<?php ob_start(); ?>

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
    <h2>Logros y Llamadas de Atención</h2>
    <a href="/achievement" class="btn btn-primary">Registrar Nuevo</a>
</div>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Fecha de Ocurrencia</th>
            <th>Empleado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($achievements as $achievement): ?>
        <tr>
            <td><?= htmlspecialchars($achievement['id']) ?></td>
            <td><?= htmlspecialchars($achievement['description']) ?></td>
            <td>
                <?= $achievement['type'] === 'positive' ? 'Logro' : 'Llamada de Atención' ?>
            </td>
            <td><?= htmlspecialchars($achievement['occurrence_date']) ?></td>
            <td><?= htmlspecialchars($achievement['first_name'] . ' ' . $achievement['last_name']) ?></td>
            <td>
                <a href="/achievement/<?= $achievement['id'] ?>" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Editar
                </a>
                <form id="delete-form-<?= $achievement['id'] ?>" method="post" action="/achievement/eliminar/<?= $achievement['id'] ?>" style="display:inline;">
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeletion('delete-form-<?= $achievement['id'] ?>')">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var deleteAchievementId;

    var confirmDeleteModal = document.getElementById('confirmDeleteModal')
    confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        deleteAchievementId = button.getAttribute('data-achievement-id')
    })

    document.getElementById('confirmDeleteButton').addEventListener('click', function () {
        document.getElementById('delete-form-' + deleteAchievementId).submit()
    })

    function confirmDeletion(formId) {
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'))
        deleteModal.show()
        deleteAchievementId = formId.split('-').pop()
    }
</script>

<?php $content = ob_get_clean(); ?>
<?php include BASE_VIEW_PATH . 'layout.php'; ?>
