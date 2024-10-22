<?php 
$title = 'Dashboard'; 
ob_start(); 
?>

<h1 class="mb-4">Bienvenido al Dashboard</h1>

<div class="row">
    <!-- Tarjeta: Total de Empleados -->
    <div class="col-md-4">
        <div class="card text-bg-primary mb-3">
            <div class="card-header">Total de Empleados</div>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($totalEmployees) ?></h5>
                <p class="card-text">Cantidad total de empleados registrados.</p>
                <a href="/empleados" class="btn btn-light">Ver Empleados</a>
                <a href="/dashboard/pdf/empleados" class="btn btn-secondary">Generar PDF</a>
            </div>
        </div>
    </div>

    <!-- Tarjeta: Salario Total -->
    <div class="col-md-4">
        <div class="card text-bg-success mb-3">
            <div class="card-header">Salario Total</div>
            <div class="card-body">
                <h5 class="card-title">$<?= number_format($totalSalary, 2) ?></h5>
                <p class="card-text">Suma total de los salarios de todos los empleados.</p>
                <a href="/empleados" class="btn btn-light">Ver Detalles</a>
                <!-- Implementa una ruta para generar PDF de salarios si lo deseas -->
                <!-- <a href="/dashboard/pdf/salarios" class="btn btn-secondary">Generar PDF</a> -->
            </div>
        </div>
    </div>

    <!-- Tarjeta: Salarios por Tienda -->
    <div class="col-md-4">
        <div class="card text-bg-warning mb-3">
            <div class="card-header">Salarios por Tienda</div>
            <div class="card-body">
                <h5 class="card-title"><?= count($salaryByStore) ?> Tiendas</h5>
                <p class="card-text">Salarios de empleados agrupados por tienda.</p>
                <a href="/empleados" class="btn btn-light">Ver Salarios</a>
                <!-- Implementa una ruta para generar PDF de salarios por tienda si lo deseas -->
                <!-- <a href="/dashboard/pdf/salarios_tienda" class="btn btn-secondary">Generar PDF</a> -->
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Tarjeta: Total de Logros -->
    <div class="col-md-4">
        <div class="card text-bg-info mb-3">
            <div class="card-header">Total de Logros</div>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($totalAchievements) ?></h5>
                <p class="card-text">Cantidad total de logros positivos registrados.</p>
                <a href="/achievements" class="btn btn-light">Ver Logros</a>
                <a href="/dashboard/pdf/logros" class="btn btn-secondary">Generar PDF</a>
            </div>
        </div>
    </div>

    <!-- Tarjeta: Total de Llamadas de Atención -->
    <div class="col-md-4">
        <div class="card text-bg-danger mb-3">
            <div class="card-header">Total de Llamadas de Atención</div>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($totalWarnings) ?></h5>
                <p class="card-text">Cantidad total de llamadas de atención negativas registradas.</p>
                <a href="/achievements" class="btn btn-light">Ver Llamadas</a>
                <a href="/dashboard/pdf/llamadas" class="btn btn-secondary">Generar PDF</a>
            </div>
        </div>
    </div>

    <!-- Tarjeta: Consulta de Empleados -->
    <div class="col-md-4">
        <div class="card text-bg-secondary mb-3">
            <div class="card-header">Consulta de Empleados</div>
            <div class="card-body">
                <h5 class="card-title">Buscar Empleado</h5>
                <p class="card-text">Consulta información detallada de un empleado en particular.</p>
                <a href="/empleados" class="btn btn-light">Consultar Empleados</a>
                <!-- Podrías agregar un botón para generar un PDF con detalles específicos si lo deseas -->
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include BASE_VIEW_PATH . 'layout.php'; 
?>
