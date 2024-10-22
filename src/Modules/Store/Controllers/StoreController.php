<?php
namespace App\Modules\Store\Controllers;

use App\Modules\Store\Models\Store;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreController
{
    protected $storeModel;
    protected $view;

    public function __construct(Store $storeModel, $view)
    {
        $this->storeModel = $storeModel;
        $this->view = $view;
    }

    public function listStores(Request $request, Response $response, $args)
    {
        $tiendas = $this->storeModel->getAll();
        return $this->view->render($response, 'stores.php', ['tiendas' => $tiendas]);
    }

    public function showStoreForm(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;
        $data = [];
        $errors = [];

        if ($id) {
            $tienda = $this->storeModel->getById($id);
            if (!$tienda) {
                return $response->withHeader('Location', '/tiendas')->withStatus(302);
            }
            $data['tienda'] = $tienda;
        }

        return $this->view->render($response, 'store_form.php', $data);
    }

    public function saveStore(Request $request, Response $response, $args)
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
            $data['tienda'] = [
                'name' => htmlspecialchars($params['name'] ?? ''),
            ];
            return $this->view->render($response, 'store_form.php', $data);
        }

        $name = trim($params['name']);

        try {
            if ($id) {
                $this->storeModel->update($id, $name);
            } else {
                $this->storeModel->create($name);
            }

            return $response->withHeader('Location', '/tiendas')->withStatus(302);
        } catch (\PDOException $e) {
            $data['errors']['db'] = 'Error al guardar los datos: ' . $e->getMessage();
            return $this->view->render($response, 'store_form.php', $data);
        }
    }

    public function deleteStore(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;

        if ($id) {
            try {
                $this->storeModel->delete($id);
                return $response->withHeader('Location', '/tiendas')->withStatus(302);
            } catch (\PDOException $e) {
                return $response->withHeader('Location', '/tiendas')->withStatus(302);
            }
        }

        return $response->withHeader('Location', '/tiendas')->withStatus(302);
    }
}
