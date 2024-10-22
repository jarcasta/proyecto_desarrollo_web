<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Llamadas de Atención</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Llamadas de Atención de Empleados</h1>
        <p>Fecha: <?= date('d/m/Y') ?></p>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Fecha de Ocurrencia</th>
                <th>Empleado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($warnings as $warning): ?>
                <tr>
                    <td><?= htmlspecialchars($warning['id']) ?></td>
                    <td><?= htmlspecialchars($warning['description']) ?></td>
                    <td><?= htmlspecialchars($warning['occurrence_date']) ?></td>
                    <td><?= htmlspecialchars($warning['first_name'] . ' ' . $warning['last_name']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
