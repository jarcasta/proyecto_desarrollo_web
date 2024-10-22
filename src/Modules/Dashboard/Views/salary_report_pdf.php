<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Salario Total</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .content { text-align: center; }
        .amount { font-size: 24px; color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Salario Total</h1>
        <p>Fecha: <?= date('d/m/Y') ?></p>
    </div>
    <div class="content">
        <p><strong>Suma Total de Salarios:</strong></p>
        <p class="amount">$<?= number_format($totalSalary, 2) ?></p>
    </div>
</body>
</html>
