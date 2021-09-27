<?php

namespace App\Controllers;

use App\Service\ServiceManager;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;

class ControllerFactory
{
    private $name;
    private $request_params;

    public function __construct($name, $request_params)
    {
        $this->name = $name;
        $this->request_params = $request_params;
    }

    public function getController()
    {
        $class_name = 'App\Controllers\\' . ucwords($this->name) . 'Controller';
        if (class_exists($class_name)) {
            $serviceManager = new ServiceManager();
            $class = new ReflectionClass($class_name);
            if ($class->getConstructor() === null){
                return $class->newInstance();
            }
            $reflection = new ReflectionMethod($class_name, '__construct');
            $parameters = $reflection->getParameters();
            $arr = [];
            foreach ($parameters as $parameter) {
                $arr[$parameter->name] = $serviceManager->getService($parameter->getClass()->name);
            }
            $obj = $class->newInstanceArgs($arr);
            $obj->setRequestParams($this->request_params);
            return $obj;
        } else {
            throw new RuntimeException('Invalid URL', 405);
        }
    }
}