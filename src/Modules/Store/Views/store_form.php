<?php $title = isset($tienda) ? 'Editar Tienda' : 'Crear Tienda'; ?>
<?php ob_start(); ?>

<h2 class="mb-4"><?= $title ?></h2>

<?php if (isset($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<form method="post" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="name" class="form-label">Nombre:</label>
        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= isset($tienda['name']) ? htmlspecialchars($tienda['name']) : '' ?>" required>
        <?php if (isset($errors['name'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['name']) ?>
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-success"><?= isset($tienda) ? 'Actualizar' : 'Crear' ?></button>
    <a href="/tiendas" class="btn btn-secondary">Cancelar</a>
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