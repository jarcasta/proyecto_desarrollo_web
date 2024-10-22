<?php $title = isset($usuario) ? 'Editar Usuario' : 'Crear Usuario'; ?>
<?php ob_start(); ?>

<h2 class="mb-4"><?= $title ?></h2>

<!-- Mostrar Mensajes de Error (si los hay) -->
<?php if (isset($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<form method="post" class="needs-validation" novalidate>
    <!-- CSRF Tokens (si los has implementado) -->
    <input type="hidden" name="<?= htmlspecialchars($csrf['name_key']) ?>" value="<?= htmlspecialchars($csrf['name']) ?>">
    <input type="hidden" name="<?= htmlspecialchars($csrf['value_key']) ?>" value="<?= htmlspecialchars($csrf['value']) ?>">

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>" id="nombre" name="nombre" value="<?= isset($usuario['nombre']) ? htmlspecialchars($usuario['nombre']) : '' ?>" required>
        <?php if (isset($errors['nombre'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['nombre']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="correo" class="form-label">Correo:</label>
        <input type="email" class="form-control <?= isset($errors['correo']) ? 'is-invalid' : '' ?>" id="correo" name="correo" value="<?= isset($usuario['correo']) ? htmlspecialchars($usuario['correo']) : '' ?>" required>
        <?php if (isset($errors['correo'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['correo']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="clave_acceso" class="form-label">Clave de Acceso:</label>
        <input type="password" class="form-control <?= isset($errors['clave_acceso']) ? 'is-invalid' : '' ?>" id="clave_acceso" name="clave_acceso" required>
        <?php if (isset($errors['clave_acceso'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['clave_acceso']) ?>
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-success"><?= isset($usuario) ? 'Actualizar' : 'Crear' ?></button>
    <a href="/usuarios" class="btn btn-secondary">Cancelar</a>
</form>

<script>
    // Ejemplo de validación de Bootstrap
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