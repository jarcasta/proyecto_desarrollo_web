<?php 
$title = isset($achievement) ? 'Editar Logro/Llamada de Atención' : 'Registrar Logro/Llamada de Atención'; 
ob_start(); 
?>

<h2 class="mb-4"><?= htmlspecialchars($title) ?></h2>

<!-- Mostrar Mensajes de Error (si los hay) -->
<?php if (isset($errors) && !empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<form method="post" class="needs-validation" novalidate>
    <!-- CSRF Tokens (si los has implementado) -->
    <input type="hidden" name="<?= htmlspecialchars($csrf['name_key'] ?? '') ?>" value="<?= htmlspecialchars($csrf['name'] ?? '') ?>">
    <input type="hidden" name="<?= htmlspecialchars($csrf['value_key'] ?? '') ?>" value="<?= htmlspecialchars($csrf['value'] ?? '') ?>">

    <div class="mb-3">
        <label for="description" class="form-label">Descripción:</label>
        <textarea class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>" id="description" name="description" rows="3" required><?= htmlspecialchars($achievement['description'] ?? '') ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['description']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="type" class="form-label">Tipo:</label>
        <select class="form-select <?= isset($errors['type']) ? 'is-invalid' : '' ?>" id="type" name="type" required>
            <option value="">Selecciona un tipo</option>
            <option value="positive" <?= (isset($achievement['type']) && $achievement['type'] === 'positive') ? 'selected' : '' ?>>Logro</option>
            <option value="negative" <?= (isset($achievement['type']) && $achievement['type'] === 'negative') ? 'selected' : '' ?>>Llamada de Atención</option>
        </select>
        <?php if (isset($errors['type'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['type']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="occurrence_date" class="form-label">Fecha de Ocurrencia:</label>
        <input type="text" class="form-control <?= isset($errors['occurrence_date']) ? 'is-invalid' : '' ?>" id="occurrence_date" name="occurrence_date" value="<?= htmlspecialchars($achievement['occurrence_date'] ?? '') ?>" required>
        <?php if (isset($errors['occurrence_date'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['occurrence_date']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="employee_id" class="form-label">Empleado:</label>
        <select class="form-select <?= isset($errors['employee_id']) ? 'is-invalid' : '' ?>" id="employee_id" name="employee_id" required>
            <option value="">Selecciona un empleado</option>
            <?php foreach ($employees as $employee): ?>
                <option value="<?= htmlspecialchars($employee['id']) ?>" <?= (isset($achievement['employee_id']) && $achievement['employee_id'] == $employee['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['employee_id'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($errors['employee_id']) ?>
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-success"><?= isset($achievement) ? 'Actualizar' : 'Registrar' ?></button>
    <a href="/achievements" class="btn btn-secondary">Cancelar</a>
</form>

<!-- Inicializar Datepicker -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('occurrence_date');
        if (dateInput) {
            new tempusDominus.TempusDominus(dateInput, {
                display: {
                    components: {
                        calendar: true,
                        decades: true,
                        month: true,
                        year: true,
                        clock: false
                    }
                },
                localization: {
                    format: 'yyyy-mm-dd'
                }
            });
        }
    });

    // Validación de Formularios con Bootstrap
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
