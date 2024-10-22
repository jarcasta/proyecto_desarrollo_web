<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Empleados</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
        img { width: 50px; height: 50px; object-fit: cover; }
    </style>
</head>
<body>
    <h1>Reporte General de Empleados</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fotografía</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha de Nacimiento</th>
                <th>Puesto</th>
                <th>Salario</th>
                <th>Tienda</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $empleado): ?>
            <tr>
                <td><?= htmlspecialchars($empleado['id']) ?></td>
                <td>
                    <?php if ($empleado['photo_path']): ?>
                        <img src="<?= $_SERVER['DOCUMENT_ROOT'] . '/' . htmlspecialchars($empleado['photo_path']) ?>" alt="Foto de <?= htmlspecialchars($empleado['first_name'] . ' ' . $empleado['last_name']) ?>">
                    <?php else: ?>
                        <img src="<?= $_SERVER['DOCUMENT_ROOT'] . '/images/default_avatar.png' ?>" alt="Foto por Defecto">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($empleado['first_name']) ?></td>
                <td><?= htmlspecialchars($empleado['last_name']) ?></td>
                <td><?= htmlspecialchars($empleado['date_of_birth']) ?></td>
                <td><?= htmlspecialchars($empleado['position']) ?></td>
                <td>$<?= number_format($empleado['salary'], 2) ?></td>
                <td><?= htmlspecialchars($empleado['store']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
