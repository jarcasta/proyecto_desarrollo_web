<?php
namespace App\Modules\Employee\Controllers;

use App\Modules\Employee\Models\Employee;
use App\Modules\Position\Models\Position;
use App\Modules\Store\Models\Store;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;

class EmployeeController
{
    protected $employeeModel;
    protected $positionModel;
    protected $storeModel;
    protected $view;

    public function __construct(Employee $employeeModel, Position $positionModel, Store $storeModel, $view)
    {
        $this->employeeModel = $employeeModel;
        $this->positionModel = $positionModel;
        $this->storeModel = $storeModel;
        $this->view = $view;
    }

    public function listEmployees(Request $request, Response $response, $args)
    {
        $empleados = $this->employeeModel->getAll();
        return $this->view->render($response, 'employees.php', ['empleados' => $empleados]);
    }

    public function showEmployeeForm(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;
        $data = [];
        $errors = [];

        if ($id) {
            $empleado = $this->employeeModel->getById($id);
            if (!$empleado) {
                return $response->withHeader('Location', '/empleados')->withStatus(302);
            }
            $data['empleado'] = $empleado;
        }

        $posiciones = $this->positionModel->getAll();
        $tiendas = $this->storeModel->getAll();

        return $this->view->render($response, 'employee_form.php', [
            'empleado' => $data['empleado'] ?? null,
            'posiciones' => $posiciones,
            'tiendas' => $tiendas,
            'errors' => $errors
        ]);
    }

    public function saveEmployee(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;
        $data = [];
        $errors = [];

        $params = (array) $request->getParsedBody();

        if (empty(trim($params['first_name'] ?? ''))) {
            $errors['first_name'] = 'El campo Nombre es obligatorio.';
        }

        if (empty(trim($params['last_name'] ?? ''))) {
            $errors['last_name'] = 'El campo Apellido es obligatorio.';
        }

        if (empty(trim($params['date_of_birth'] ?? ''))) {
            $errors['date_of_birth'] = 'El campo Fecha de Nacimiento es obligatorio.';
        }

        if (empty(trim($params['position_id'] ?? ''))) {
            $errors['position_id'] = 'El campo Puesto es obligatorio.';
        }

        if (empty(trim($params['salary'] ?? ''))) {
            $errors['salary'] = 'El campo Salario es obligatorio.';
        } elseif (!is_numeric($params['salary']) || $params['salary'] < 0) {
            $errors['salary'] = 'El Salario debe ser un número positivo.';
        }

        if (empty(trim($params['store_id'] ?? ''))) {
            $errors['store_id'] = 'El campo Tienda es obligatorio.';
        }

        $uploadedFiles = $request->getUploadedFiles();
        $photo = $uploadedFiles['photo'] ?? null;
        $photo_path = null;

        if ($photo && $photo->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($photo->getError() === UPLOAD_ERR_OK) {
                $filename = moveUploadedFile('uploads', $photo);
                $photo_path = 'uploads/' . $filename;
            } else {
                $errors['photo'] = 'Error al subir la fotografía.';
            }
        }

        if (!empty($errors)) {
            $posiciones = $this->positionModel->getAll();
            $tiendas = $this->storeModel->getAll();

            $data['errors'] = $errors;
            $data['empleado'] = [
                'first_name' => htmlspecialchars($params['first_name'] ?? ''),
                'last_name' => htmlspecialchars($params['last_name'] ?? ''),
                'date_of_birth' => htmlspecialchars($params['date_of_birth'] ?? ''),
                'position_id' => htmlspecialchars($params['position_id'] ?? ''),
                'salary' => htmlspecialchars($params['salary'] ?? ''),
                'store_id' => htmlspecialchars($params['store_id'] ?? ''),
            ];

            return $this->view->render($response, 'employee_form.php', [
                'empleado' => $data['empleado'],
                'posiciones' => $posiciones,
                'tiendas' => $tiendas,
                'errors' => $errors
            ]);
        }

        $first_name = trim($params['first_name']);
        $last_name = trim($params['last_name']);
        $date_of_birth = trim($params['date_of_birth']);
        $position_id = trim($params['position_id']);
        $salary = trim($params['salary']);
        $store_id = trim($params['store_id']);

        if ($photo_path) {
            $data['photo_path'] = $photo_path;
        }

        $data['first_name'] = $first_name;
        $data['last_name'] = $last_name;
        $data['date_of_birth'] = $date_of_birth;
        $data['position_id'] = $position_id;
        $data['salary'] = $salary;
        $data['store_id'] = $store_id;

        try {
            if ($id) {
                if (!$photo_path) {
                    $empleadoActual = $this->employeeModel->getById($id);
                    $data['photo_path'] = $empleadoActual['photo_path'];
                }
                $this->employeeModel->update($id, $data);
            } else {
                $this->employeeModel->create($data);
            }

            return $response->withHeader('Location', '/empleados')->withStatus(302);
        } catch (PDOException $e) {
            $errors['db'] = 'Error al guardar los datos: ' . $e->getMessage();

            $posiciones = $this->positionModel->getAll();
            $tiendas = $this->storeModel->getAll();

            return $this->view->render($response, 'employee_form.php', [
                'empleado' => $data,
                'posiciones' => $posiciones,
                'tiendas' => $tiendas,
                'errors' => $errors
            ]);
        }
    }

    // Eliminar un empleado
    public function deleteEmployee(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;

        if ($id) {
            try {
                $empleado = $this->employeeModel->getById($id);
                if ($empleado && $empleado['photo_path']) {
                    $photoFullPath = __DIR__ . '/../../../public/' . $empleado['photo_path'];
                    if (file_exists($photoFullPath)) {
                        unlink($photoFullPath);
                    }
                }

                $this->employeeModel->delete($id);
                return $response->withHeader('Location', '/empleados')->withStatus(302);
            } catch (PDOException $e) {
                return $response->withHeader('Location', '/empleados')->withStatus(302);
            }
        }

        return $response->withHeader('Location', '/empleados')->withStatus(302);
    }
}

function moveUploadedFile($directory, $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}
