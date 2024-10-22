<?php
namespace App\Modules\Position\Controllers;

use App\Modules\Position\Models\Position;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PositionController
{
    protected $positionModel;
    protected $view;

    public function __construct(Position $positionModel, $view)
    {
        $this->positionModel = $positionModel;
        $this->view = $view;
    }

    public function listPositions(Request $request, Response $response, $args)
    {
        $posiciones = $this->positionModel->getAll();
        return $this->view->render($response, 'positions.php', ['posiciones' => $posiciones]);
    }

    public function showPositionForm(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;
        $data = [];
        $errors = [];

        if ($id) {
            $posicion = $this->positionModel->getById($id);
            if (!$posicion) {
                return $response->withHeader('Location', '/posiciones')->withStatus(302);
            }
            $data['posicion'] = $posicion;
        }

        return $this->view->render($response, 'position_form.php', $data);
    }

    public function savePosition(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;
        $data = [];
        $errors = [];

        $params = (array) $request->getParsedBody();

        if (empty(trim($params['name'] ?? ''))) {
            $errors['name'] = 'El campo Nombre es obligatorio.';
        }

    
        if (!empty($errors)) {
            $data['errors'] = $errors;
            $data['posicion'] = [
                'name' => htmlspecialchars($params['name'] ?? ''),
            ];
            return $this->view->render($response, 'position_form.php', $data);
        }

        $name = trim($params['name']);

        try {
            if ($id) {
                $this->positionModel->update($id, $name);
            } else {
                $this->positionModel->create($name);
            }

            return $response->withHeader('Location', '/posiciones')->withStatus(302);
        } catch (\PDOException $e) {
            $data['errors']['db'] = 'Error al guardar los datos: ' . $e->getMessage();
            return $this->view->render($response, 'position_form.php', $data);
        }
    }

    public function deletePosition(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;

        if ($id) {
            try {
                $this->positionModel->delete($id);
                return $response->withHeader('Location', '/posiciones')->withStatus(302);
            } catch (\PDOException $e) {
                return $response->withHeader('Location', '/posiciones')->withStatus(302);
            }
        }

        return $response->withHeader('Location', '/posiciones')->withStatus(302);
    }
}
