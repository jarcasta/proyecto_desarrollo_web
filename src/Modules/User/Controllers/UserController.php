<?php
namespace App\Modules\User\Controllers;

use App\Modules\User\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    protected $userModel;
    protected $view;

    public function __construct(User $userModel, $view)
    {
        $this->userModel = $userModel;
        $this->view = $view;
    }

    public function listUsers(Request $request, Response $response, $args)
    {
        $usuarios = $this->userModel->getAll();
        return $this->view->render($response, 'users.php', ['usuarios' => $usuarios]);
    }

    public function showUserForm(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;
        $data = [];
        $errors = [];

        if ($id) {
            $usuario = $this->userModel->getById($id);
            if (!$usuario) {
                return $response->withHeader('Location', '/usuarios')->withStatus(302);
            }
            $data['usuario'] = $usuario;
        }

        return $this->view->render($response, 'user_form.php', $data);
    }

    public function saveUser(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;
        $data = [];
        $errors = [];

        $params = (array) $request->getParsedBody();

        if (empty(trim($params['nombre'] ?? ''))) {
            $errors['nombre'] = 'El campo Nombre es obligatorio.';
        }

        if (empty(trim($params['correo'] ?? ''))) {
            $errors['correo'] = 'El campo Correo es obligatorio.';
        } elseif (!filter_var($params['correo'], FILTER_VALIDATE_EMAIL)) {
            $errors['correo'] = 'El formato del correo no es válido.';
        }

        if (empty(trim($params['clave_acceso'] ?? ''))) {
            $errors['clave_acceso'] = 'El campo Clave de Acceso es obligatorio.';
        } elseif (strlen($params['clave_acceso']) < 6) {
            $errors['clave_acceso'] = 'La clave de acceso debe tener al menos 6 caracteres.';
        }

        if (!empty($errors)) {
            $data['errors'] = $errors;
            $data['usuario'] = [
                'nombre' => htmlspecialchars($params['nombre'] ?? ''),
                'correo' => htmlspecialchars($params['correo'] ?? ''),
            ];
            return $this->view->render($response, 'user_form.php', $data);
        }

        $nombre = trim($params['nombre']);
        $correo = trim($params['correo']);
        $clave_acceso = password_hash(trim($params['clave_acceso']), PASSWORD_DEFAULT);

        try {
            if ($id) {
                $this->userModel->update($id, $nombre, $correo, $clave_acceso);
            } else {
                $this->userModel->create($nombre, $correo, $clave_acceso);
            }

            return $response->withHeader('Location', '/usuarios')->withStatus(302);
        } catch (\PDOException $e) {
            $data['errors']['db'] = 'Error al guardar los datos: ' . $e->getMessage();
            return $this->view->render($response, 'user_form.php', $data);
        }
    }

    public function deleteUser(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;

        if ($id) {
            try {
                $this->userModel->delete($id);
                return $response->withHeader('Location', '/usuarios')->withStatus(302);
            } catch (\PDOException $e) {
                return $response->withHeader('Location', '/usuarios')->withStatus(302);
            }
        }

        return $response->withHeader('Location', '/usuarios')->withStatus(302);
    }
}
