<?php

use Dompdf\Dompdf;
use Slim\Views\PhpRenderer;
use App\Modules\Position\Models\Position;
use App\Modules\Store\Models\Store;
use App\Modules\Employee\Models\Employee;
use App\Modules\Achievement\Models\Achievement;
use App\Modules\Dashboard\Controllers\DashboardController;
use App\Modules\Position\Controllers\PositionController;
use App\Modules\Store\Controllers\StoreController;
use App\Modules\Employee\Controllers\EmployeeController;
use App\Modules\Achievement\Controllers\AchievementController;

$container->set('db', function () {
    $host = 'localhost';
    $db   = 'intelafix_db';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    return new PDO($dsn, $user, $pass, $options);
});

$container->set('pdf', function () {
    $dompdf = new Dompdf();
    $dompdf->set_option('defaultFont', 'Arial');
    return $dompdf;
});

$container->set('view_position', function () {
    return new PhpRenderer(__DIR__ . '/Modules/Position/Views/');
});

$container->set('view_store', function () {
    return new PhpRenderer(__DIR__ . '/Modules/Store/Views/');
});

$container->set('view_employee', function () {
    return new PhpRenderer(__DIR__ . '/Modules/Employee/Views/');
});

$container->set('view_achievement', function () {
    return new PhpRenderer(__DIR__ . '/Modules/Achievement/Views/');
});

$container->set('view_dashboard', function () {
    return new PhpRenderer(__DIR__ . '/Modules/Dashboard/Views/');
});

$container->set(Position::class, function ($container) {
    return new Position($container->get('db'));
});

$container->set(Store::class, function ($container) {
    return new Store($container->get('db'));
});

$container->set(Employee::class, function ($container) {
    return new Employee($container->get('db'));
});

$container->set(Achievement::class, function ($container) {
    return new Achievement($container->get('db'));
});

$container->set(PositionController::class, function ($container) {
    return new PositionController(
        $container->get(Position::class),
        $container->get('view_position')
    );
});

$container->set(StoreController::class, function ($container) {
    return new StoreController(
        $container->get(Store::class),
        $container->get('view_store')
    );
});

$container->set(EmployeeController::class, function ($container) {
    return new EmployeeController(
        $container->get(Employee::class),
        $container->get(Position::class),
        $container->get(Store::class),
        $container->get('view_employee')
    );
});

$container->set(AchievementController::class, function ($container) {
    return new AchievementController(
        $container->get(Achievement::class),
        $container->get(Employee::class),
        $container->get('view_achievement')
    );
});

$container->set(DashboardController::class, function ($container) {
    return new DashboardController(
        $container->get(Employee::class),
        $container->get(Store::class),
        $container->get(Achievement::class),
        $container->get('view_dashboard'),
        $container->get(Dompdf::class),
    );
});
