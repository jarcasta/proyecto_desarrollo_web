<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Mi Aplicación') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.2.7/dist/css/tempus-dominus.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.2.7/dist/js/tempus-dominus.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Mi Aplicación</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/') ? 'active' : '' ?>"
                            href="/">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/posiciones') === 0) ? 'active' : '' ?>"
                            href="/posiciones">Posiciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/tiendas') === 0) ? 'active' : '' ?>"
                            href="/tiendas">Tiendas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/empleados') === 0) ? 'active' : '' ?>"
                            href="/empleados">Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/achievements') === 0) ? 'active' : '' ?>"
                            href="/achievements">Logros/Llamadas de Atención</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
</body>

</html>