<?php
namespace App\Modules\Achievement\Controllers;

use App\Modules\Achievement\Models\Achievement;
use App\Modules\Employee\Models\Employee;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AchievementController
{
    protected $achievementModel;
    protected $employeeModel;
    protected $view;

    public function __construct(Achievement $achievementModel, Employee $employeeModel, $view)
    {
        $this->achievementModel = $achievementModel;
        $this->employeeModel = $employeeModel;
        $this->view = $view;
    }

    public function listAchievements(Request $request, Response $response, $args)
    {
        $achievements = $this->achievementModel->getAll();
        return $this->view->render($response, 'achievements.php', ['achievements' => $achievements]);
    }

    public function showAchievementForm(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;
        $data = [];
        $errors = [];

        if ($id) {
            $achievement = $this->achievementModel->getById($id);
            if (!$achievement) {
                return $response->withHeader('Location', '/achievements')->withStatus(302);
            }
            $data['achievement'] = $achievement;
        }

        $employees = $this->employeeModel->getAll();

        return $this->view->render($response, 'achievement_form.php', [
            'achievement' => $data['achievement'] ?? null,
            'employees' => $employees,
            'errors' => $errors
        ]);
    }

    public function saveAchievement(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;
        $data = [];
        $errors = [];

        $params = (array) $request->getParsedBody();

        if (empty(trim($params['description'] ?? ''))) {
            $errors['description'] = 'El campo Descripción es obligatorio.';
        }

        if (empty(trim($params['type'] ?? ''))) {
            $errors['type'] = 'El campo Tipo es obligatorio.';
        } elseif (!in_array($params['type'], ['positive', 'negative'])) {
            $errors['type'] = 'Tipo inválido.';
        }

        if (empty(trim($params['occurrence_date'] ?? ''))) {
            $errors['occurrence_date'] = 'El campo Fecha de Ocurrencia es obligatorio.';
        }

        if (empty(trim($params['employee_id'] ?? ''))) {
            $errors['employee_id'] = 'El campo Empleado es obligatorio.';
        }

        if (!empty($errors)) {
            $employees = $this->employeeModel->getAll();

            $data['errors'] = $errors;
            $data['achievement'] = [
                'description' => htmlspecialchars($params['description'] ?? ''),
                'type' => htmlspecialchars($params['type'] ?? ''),
                'occurrence_date' => htmlspecialchars($params['occurrence_date'] ?? ''),
                'employee_id' => htmlspecialchars($params['employee_id'] ?? ''),
            ];

            return $this->view->render($response, 'achievement_form.php', [
                'achievement' => $data['achievement'],
                'employees' => $employees,
                'errors' => $errors
            ]);
        }

        $description = trim($params['description']);
        $type = trim($params['type']);
        $occurrence_date = trim($params['occurrence_date']);
        $employee_id = trim($params['employee_id']);

        $data['description'] = $description;
        $data['type'] = $type;
        $data['occurrence_date'] = $occurrence_date;
        $data['employee_id'] = $employee_id;

        try {
            if ($id) {
                $this->achievementModel->update($id, $data);
            } else {
                $this->achievementModel->create($data);
            }

            return $response->withHeader('Location', '/achievements')->withStatus(302);
        } catch (\PDOException $e) {
            $errors['db'] = 'Error al guardar los datos: ' . $e->getMessage();

            $employees = $this->employeeModel->getAll();

            return $this->view->render($response, 'achievement_form.php', [
                'achievement' => $data,
                'employees' => $employees,
                'errors' => $errors
            ]);
        }
    }

    public function deleteAchievement(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;

        if ($id) {
            try {
                $this->achievementModel->delete($id);
                return $response->withHeader('Location', '/achievements')->withStatus(302);
            } catch (\PDOException $e) {
                return $response->withHeader('Location', '/achievements')->withStatus(302);
            }
        }

        return $response->withHeader('Location', '/achievements')->withStatus(302);
    }
}
