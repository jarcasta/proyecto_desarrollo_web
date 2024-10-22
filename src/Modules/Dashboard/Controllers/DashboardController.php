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
    protected $pdf;

    public function __construct(Employee $employeeModel, Store $storeModel, Achievement $achievementModel, $view, $pdf)
    {
        $this->employeeModel = $employeeModel;
        $this->storeModel = $storeModel;
        $this->achievementModel = $achievementModel;
        $this->view = $view;
        $this->pdf = $pdf;
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

        // Pasar los datos a la vista del dashboard
        return $this->view->render($response, 'dashboard.php', [
            'totalEmployees' => $totalEmployees,
            'totalSalary' => $totalSalary,
            'salaryByStore' => $salaryByStore,
            'totalAchievements' => $totalAchievements,
            'totalWarnings' => $totalWarnings
        ]);
    }

    // Método para generar PDF del Total de Empleados
    public function generateEmployeesReportPDF(Request $request, Response $response, $args)
    {
        // Obtener todos los empleados
        $employees = $this->employeeModel->getAll();

        // Renderizar la vista HTML para el PDF
        ob_start();
        include __DIR__ . '/../Views/employees_report_pdf.php';
        $html = ob_get_clean();

        // Cargar HTML en dompdf
        $this->pdf->loadHtml($html);

        // (Opcional) Configurar el tamaño y orientación del papel
        $this->pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $this->pdf->render();

        // Salida del PDF al navegador
        $this->pdf->stream("reporte_empleados_" . date('Ymd') . ".pdf", ["Attachment" => true]);

        // Detener la ejecución para evitar que Slim continúe
        exit;
    }

    // Métodos similares para otros reportes...
}
