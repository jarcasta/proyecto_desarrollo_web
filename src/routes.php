<?php
/**
 * @var \DI\Container $container
 * @var \Slim\App $app
 */

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Modules\Dashboard\Controllers\DashboardController;
use App\Modules\Position\Controllers\PositionController;
use App\Modules\Store\Controllers\StoreController;
use App\Modules\Employee\Controllers\EmployeeController;
use App\Modules\Achievement\Controllers\AchievementController;

/** @var App $app */

$positionController = $container->get(PositionController::class);
$storeController = $container->get(StoreController::class);
$employeeController = $container->get(EmployeeController::class);
$achievementController = $container->get(AchievementController::class);
$dashboardController = $container->get(DashboardController::class);

$app->get('/', [$dashboardController, 'showDashboard'])->setName('dashboard');
$app->get('/dashboard', [$dashboardController, 'showDashboard']);

$app->get('/dashboard/pdf/empleados', [$dashboardController, 'generateEmployeesReportPDF'])->setName('dashboard.pdf.empleados');
$app->get('/dashboard/pdf/salarios_tienda', [$dashboardController, 'generateSalaryPerShopReportPDF'])->setName('dashboard.pdf.salarios_tienda');
$app->get('/dashboard/pdf/logros', [$dashboardController, 'generateAchievementsReportPDF'])->setName('dashboard.pdf.logros');
$app->get('/dashboard/pdf/llamadas', [$dashboardController, 'generateWarningsReportPDF'])->setName('dashboard.pdf.llamadas');

$app->get('/posiciones', [$positionController, 'listPositions']);
$app->get('/posicion', [$positionController, 'showPositionForm']);
$app->get('/posicion/{id}', [$positionController, 'showPositionForm']);
$app->post('/posicion', [$positionController, 'savePosition']);
$app->post('/posicion/{id}', [$positionController, 'savePosition']);
$app->post('/posicion/eliminar/{id}', [$positionController, 'deletePosition']);
$app->get('/tiendas', [$storeController, 'listStores']);
$app->get('/tienda', [$storeController, 'showStoreForm']);
$app->get('/tienda/{id}', [$storeController, 'showStoreForm']);
$app->post('/tienda', [$storeController, 'saveStore']);
$app->post('/tienda/{id}', [$storeController, 'saveStore']);
$app->post('/tienda/eliminar/{id}', [$storeController, 'deleteStore']);
$app->get('/empleados', [$employeeController, 'listEmployees']);
$app->get('/empleado', [$employeeController, 'showEmployeeForm']);
$app->get('/empleado/{id}', [$employeeController, 'showEmployeeForm']);
$app->post('/empleado', [$employeeController, 'saveEmployee']);
$app->post('/empleado/{id}', [$employeeController, 'saveEmployee']);
$app->post('/empleado/eliminar/{id}', [$employeeController, 'deleteEmployee']);
$app->get('/achievements', [$achievementController, 'listAchievements']);
$app->get('/achievement', [$achievementController, 'showAchievementForm']);
$app->get('/achievement/{id}', [$achievementController, 'showAchievementForm']);
$app->post('/achievement', [$achievementController, 'saveAchievement']);
$app->post('/achievement/{id}', [$achievementController, 'saveAchievement']);
$app->post('/achievement/eliminar/{id}', [$achievementController, 'deleteAchievement']);