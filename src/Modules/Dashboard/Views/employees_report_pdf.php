<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Empleados</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
        img { width: 50px; height: 50px; object-fit: cover; }
    </style>
</head>
<body>
    <h1>Reporte General de Empleados</h1>
    <p>Fecha: <?= date('d/m/Y') ?></p>
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
                    <?php
                        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/' . htmlspecialchars($empleado['photo_path']);
                        if (!file_exists($imagePath)) {
                            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/default_avatar.jpg';
                        }

                        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                        $mime = '';
                        switch (strtolower($extension)) {
                            case 'jpg':
                            case 'jpeg':
                                $mime = 'image/jpeg';
                                break;
                            case 'png':
                                $mime = 'image/png';
                                break;
                            case 'gif':
                                $mime = 'image/gif';
                                break;
                            default:
                                $mime = 'image/jpeg';
                                break;
                        }

                        $imageData = base64_encode(file_get_contents($imagePath));
                        $src = 'data:' . $mime . ';base64,' . $imageData;
                    ?>
                    <img src="<?= $src ?>" alt="Foto de <?= htmlspecialchars($empleado['first_name'] . ' ' . $empleado['last_name']) ?>">
                </td>
                <td><?= htmlspecialchars($empleado['first_name']) ?></td>
                <td><?= htmlspecialchars($empleado['last_name']) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y', strtotime($empleado['date_of_birth']))) ?></td>
                <td><?= htmlspecialchars($empleado['position']) ?></td>
                <td>$<?= number_format($empleado['salary'], 2) ?></td>
                <td><?= htmlspecialchars($empleado['store']) ?></td>
            </tr>
            <?php endforeach; ?>
            <!-- Fila para el total de salarios -->
            <tr>
                <td colspan="6" style="text-align: right;"><strong>Total Salarios:</strong></td>
                <td colspan="2"><strong>$<?= number_format($totalSalary, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
