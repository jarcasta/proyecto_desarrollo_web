<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Salarios por Tienda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .store-name {
            background-color: #dcdcdc;
            font-weight: bold;
        }

        .total-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .grand-total {
            border-top: 2px solid #000;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h1>Reporte de Salarios por Tienda</h1>
    <p>Fecha: <?= date('d/m/Y') ?></p>
    <?php
    $grandTotalSalary = 0;
    ?>

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
                <?php
                $storeTotalSalary = 0;
                foreach ($store['employees'] as $empleado):
                    $storeTotalSalary += $empleado['salary'];
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($empleado['first_name']) ?></td>
                        <td><?= htmlspecialchars($empleado['last_name']) ?></td>
                        <td>$<?= number_format($empleado['salary'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="2">Total Salarios en <?= htmlspecialchars($store['store_name']) ?>:</td>
                    <td>$<?= number_format($storeTotalSalary, 2) ?></td>
                </tr>
            </tbody>
        </table>
        <?php
        $grandTotalSalary += $storeTotalSalary;
        ?>
    <?php endforeach; ?>

    <table>
        <tr class="grand-total">
            <td colspan="2">Total Salarios de Todas las Tiendas:</td>
            <td>$<?= number_format($grandTotalSalary, 2) ?></td>
        </tr>
    </table>
</body>

</html>