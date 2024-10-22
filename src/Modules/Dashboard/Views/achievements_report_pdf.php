<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Logros</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Reporte de Logros de Empleados</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Fecha de Ocurrencia</th>
                <th>Empleado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($achievements as $achievement): ?>
            <tr>
                <td><?= htmlspecialchars($achievement['id']) ?></td>
                <td><?= htmlspecialchars($achievement['description']) ?></td>
                <td><?= $achievement['type'] === 'positive' ? 'Logro' : 'Llamada de Atención' ?></td>
                <td><?= htmlspecialchars($achievement['occurrence_date']) ?></td>
                <td><?= htmlspecialchars($achievement['first_name'] . ' ' . $achievement['last_name']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
