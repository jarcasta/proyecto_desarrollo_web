<?php 
$title = isset($empleado) ? 'Editar Empleado' : 'Crear Empleado'; 
ob_start(); 
?>

<h2 class="mb-4"><?= htmlspecialchars($title) ?></h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

    <div class="mb-3">
        <label for="first_name" class="form-label">Nombres:</label>
        <input type="text" class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" id="first_name" name="first_name" value="<?= htmlspecialchars($empleado['first_name'] ?? '') ?>" required>
        <?php if (isset($errors['first_name'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['first_name']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="last_name" class="form-label">Apellidos:</label>
        <input type="text" class="form-control <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>" id="last_name" name="last_name" value="<?= htmlspecialchars($empleado['last_name'] ?? '') ?>" required>
        <?php if (isset($errors['last_name'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['last_name']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="date_of_birth" class="form-label">Fecha de Nacimiento:</label>
        <input type="text" class="form-control <?= isset($errors['date_of_birth']) ? 'is-invalid' : '' ?>" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($empleado['date_of_birth'] ?? '') ?>" required>
        <?php if (isset($errors['date_of_birth'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['date_of_birth']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="photo" class="form-label">Fotografía:</label>
        <?php if (isset($empleado['photo_path']) && $empleado['photo_path']): ?>
            <div class="mb-2">
                <img src="/<?= htmlspecialchars($empleado['photo_path']) ?>" alt="Foto de <?= htmlspecialchars($empleado['first_name'] . ' ' . $empleado['last_name']) ?>" class="img-thumbnail" width="150">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control <?= isset($errors['photo']) ? 'is-invalid' : '' ?>" id="photo" name="photo" accept="image/*">
        <?php if (isset($errors['photo'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['photo']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="position_id" class="form-label">Puesto:</label>
        <select class="form-select <?= isset($errors['position_id']) ? 'is-invalid' : '' ?>" id="position_id" name="position_id" required>
            <option value="">Selecciona un puesto</option>
            <?php foreach ($posiciones as $posicion): ?>
                <option value="<?= htmlspecialchars($posicion['id']) ?>" <?= (isset($empleado['position_id']) && $empleado['position_id'] == $posicion['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($posicion['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['position_id'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['position_id']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="salary" class="form-label">Salario:</label>
        <input type="number" step="0.01" class="form-control <?= isset($errors['salary']) ? 'is-invalid' : '' ?>" id="salary" name="salary" value="<?= htmlspecialchars($empleado['salary'] ?? '') ?>" required>
        <?php if (isset($errors['salary'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['salary']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="store_id" class="form-label">Tienda:</label>
        <select class="form-select <?= isset($errors['store_id']) ? 'is-invalid' : '' ?>" id="store_id" name="store_id" required>
            <option value="">Selecciona una tienda</option>
            <?php foreach ($tiendas as $tienda): ?>
                <option value="<?= htmlspecialchars($tienda['id']) ?>" <?= (isset($empleado['store_id']) && $empleado['store_id'] == $tienda['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tienda['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['store_id'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['store_id']) ?>
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-success"><?= isset($empleado) ? 'Actualizar' : 'Crear' ?></button>
    <a href="/empleados" class="btn btn-secondary">Cancelar</a>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dateInput = document.getElementById('date_of_birth');
        if (dateInput) {
            new Datepicker(dateInput, {
                format: 'yyyy-mm-dd',
                autoClose: true,
                maxDate: new Date(),
                todayHighlight: true
            });
        }
    });

    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>

<?php 
$content = ob_get_clean(); 
include BASE_VIEW_PATH . 'layout.php'; 
?>
