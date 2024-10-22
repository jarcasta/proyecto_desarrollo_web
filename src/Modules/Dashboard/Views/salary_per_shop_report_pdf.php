<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Salarios por Tienda</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .store-name { background-color: #dcdcdc; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Salarios por Tienda</h1>
        <p>Fecha: <?= date('d/m/Y') ?></p>
    </div>
    <?php foreach ($salaryByStore as $store): ?>
        <h2><?= htmlspecialchars($store['store_name']) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Salario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($store['employees'] as $empleado): ?>
                    <tr>
                        <td><?= htmlspecialchars($empleado['first_name']) ?></td>
                        <td><?= htmlspecialchars($empleado['last_name']) ?></td>
                        <td>$<?= number_format($empleado['salary'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</body>
</html>
