<?php
namespace App\Modules\Dashboard\Controllers;

use App\Modules\Employee\Models\Employee;
use App\Modules\Store\Models\Store;
use App\Modules\Achievement\Models\Achievement;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Dompdf\Dompdf;

class DashboardController
{
    protected $employeeModel;
    protected $storeModel;
    protected $achievementModel;
    protected $view;
    protected $pdf;

    public function __construct(Employee $employeeModel, Store $storeModel, Achievement $achievementModel, $view, Dompdf $pdf)
    {
        $this->employeeModel = $employeeModel;
        $this->storeModel = $storeModel;
        $this->achievementModel = $achievementModel;
        $this->view = $view;
        $this->pdf = $pdf;
    }

    public function showDashboard(Request $request, Response $response, $args)
    {
        $totalEmployees = $this->employeeModel->getTotalEmployees();
        $totalSalary = $this->employeeModel->getTotalSalary();
        $salaryByStore = $this->employeeModel->getSalaryByStore();
        $totalAchievements = $this->achievementModel->getTotalAchievements();
        $totalWarnings = $this->achievementModel->getTotalWarnings();

        return $this->view->render($response, 'dashboard.php', [
            'totalEmployees' => $totalEmployees,
            'totalSalary' => $totalSalary,
            'salaryByStore' => $salaryByStore,
            'totalAchievements' => $totalAchievements,
            'totalWarnings' => $totalWarnings
        ]);
    }

    public function generateEmployeesReportPDF(Request $request, Response $response, $args)
    {
        try {
            $employees = $this->employeeModel->getAll();

            ob_start();
            include __DIR__ . '/../Views/employees_report_pdf.php';
            $html = ob_get_clean();

            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $this->pdf->stream("reporte_empleados_" . date('Ymd') . ".pdf", ["Attachment" => true]);

            exit;
        } catch (\Exception $e) {
            error_log("Error generando PDF de empleados: " . $e->getMessage());
            $response->getBody()->write("Ocurrió un error al generar el PDF. Por favor, intenta nuevamente más tarde.");
            return $response->withStatus(500);
        }
    }

    public function generateSalaryReportPDF(Request $request, Response $response, $args)
    {
        try {
            $totalSalary = $this->employeeModel->getTotalSalary();

            ob_start();
            include __DIR__ . '/../Views/salary_report_pdf.php';
            $html = ob_get_clean();

            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $this->pdf->stream("reporte_salario_total_" . date('Ymd') . ".pdf", ["Attachment" => true]);

            exit;
        } catch (\Exception $e) {
            error_log("Error generando PDF de salarios: " . $e->getMessage());
            $response->getBody()->write("Ocurrió un error al generar el PDF. Por favor, intenta nuevamente más tarde.");
            return $response->withStatus(500);
        }
    }

    // Método para generar PDF de Salarios por Tienda
    public function generateSalaryPerShopReportPDF(Request $request, Response $response, $args)
    {
        try {
            $salaryByStore = $this->employeeModel->getSalaryByStoreDetailed();

            ob_start();
            include __DIR__ . '/../Views/salary_per_shop_report_pdf.php';
            $html = ob_get_clean();

            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $this->pdf->stream("reporte_salarios_por_tienda_" . date('Ymd') . ".pdf", ["Attachment" => true]);

            exit;
        } catch (\Exception $e) {
            error_log("Error generando PDF de salarios por tienda: " . $e->getMessage());
            $response->getBody()->write("Ocurrió un error al generar el PDF. Por favor, intenta nuevamente más tarde.");
            return $response->withStatus(500);
        }
    }

    public function generateAchievementsReportPDF(Request $request, Response $response, $args)
    {
        try {
            $achievements = $this->achievementModel->getAchievementsByType('positive');

            ob_start();
            include __DIR__ . '/../Views/achievements_report_pdf.php';
            $html = ob_get_clean();

            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $this->pdf->stream("reporte_logros_" . date('Ymd') . ".pdf", ["Attachment" => true]);

            exit;
        } catch (\Exception $e) {
            error_log("Error generando PDF de logros: " . $e->getMessage());
            $response->getBody()->write("Ocurrió un error al generar el PDF. Por favor, intenta nuevamente más tarde.");
            return $response->withStatus(500);
        }
    }

    public function generateWarningsReportPDF(Request $request, Response $response, $args)
    {
        try {
            $warnings = $this->achievementModel->getAchievementsByType('negative');

            ob_start();
            include __DIR__ . '/../Views/warnings_report_pdf.php';
            $html = ob_get_clean();

            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $this->pdf->stream("reporte_llamadas_atencion_" . date('Ymd') . ".pdf", ["Attachment" => true]);

            exit;
        } catch (\Exception $e) {
            error_log("Error generando PDF de llamadas de atención: " . $e->getMessage());
            $response->getBody()->write("Ocurrió un error al generar el PDF. Por favor, intenta nuevamente más tarde.");
            return $response->withStatus(500);
        }
    }
}
