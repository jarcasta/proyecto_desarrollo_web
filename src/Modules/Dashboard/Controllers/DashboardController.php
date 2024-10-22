<?php
namespace App\Modules\Dashboard\Controllers;

use App\Modules\Employee\Models\Employee;
use App\Modules\Store\Models\Store;
use App\Modules\Achievement\Models\Achievement;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DashboardController
{
    protected $employeeModel;
    protected $storeModel;
    protected $achievementModel;
    protected $view;

    public function __construct(Employee $employeeModel, Store $storeModel, Achievement $achievementModel, $view)
    {
        $this->employeeModel = $employeeModel;
        $this->storeModel = $storeModel;
        $this->achievementModel = $achievementModel;
        $this->view = $view;
    }

    // Método para mostrar el dashboard
    public function showDashboard(Request $request, Response $response, $args)
    {
        // a. Lista general de empleados
        $totalEmployees = $this->employeeModel->getTotalEmployees();
        $totalSalary = $this->employeeModel->getTotalSalary();

        // b. Lista de salarios de empleados por tienda
        $salaryByStore = $this->employeeModel->getSalaryByStore();

        // c. Reportes de logros de empleados
        $totalAchievements = $this->achievementModel->getTotalAchievements();

        // d. Reportes de llamadas de atención de empleados
        $totalWarnings = $this->achievementModel->getTotalWarnings();

        // e. Consulta en pantalla de empleados (puede incluirse en otro reporte o como detalle)

        // Pasar los datos a la vista del dashboard
        return $this->view->render($response, 'dashboard.php', [
            'totalEmployees' => $totalEmployees,
            'totalSalary' => $totalSalary,
            'salaryByStore' => $salaryByStore,
            'totalAchievements' => $totalAchievements,
            'totalWarnings' => $totalWarnings
        ]);
    }
}
