<?php

namespace App;

use App\Controllers\ControllerFactory;
use Exception;
use ReflectionMethod;
use RuntimeException;


class App
{
    public $requestUri = [];
    public $requestParams = [];
    private $method;


    public function __construct()
    {
        if (trim($_SERVER['REQUEST_URI']) != "/") {
            $uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
            if(count($uri) > 2){
                throw new RuntimeException('Invalid URL', 405);
            }
            $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }
    }

    public function run()
    {
        if (empty($this->requestUri)) {
            throw new RuntimeException('Empty request', 404);
        }
        $action = $this->getAction();
        $controller_factory = new ControllerFactory($this->requestUri[0], $this->requestParams);
        $controller = $controller_factory->getController();
        if (method_exists($controller, $action)) {
            return $controller->{$action}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }

    protected function getAction(): ?string
    {
        $method = $this->method;
        $this->requestParams = json_decode(file_get_contents('php://input'), true);
        switch ($method) {
            case 'GET':
                if (count($this->requestUri) > 1){
                    $this->requestParams = ['id' => $this->requestUri[1]];
                    return 'read';
                } else {
                    $this->requestParams = [];
                    return 'index';
                }
            case 'POST':
                return 'create';
            case 'PUT':
                return 'update';
            case 'DELETE':
                $this->requestParams = ['id' => $this->requestUri[1]];
                return 'delete';
            default:
                return null;
        }
    }
}