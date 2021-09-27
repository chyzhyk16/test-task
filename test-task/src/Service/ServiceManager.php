<?php

namespace App\Service;

use ReflectionClass;
use ReflectionMethod;

class ServiceManager
{
    public function getService($name)
    {
        $service = new ReflectionClass($name);
        if ($service->getConstructor() === null) {
            return $service->newInstance();
        } else {
            $reflection = new ReflectionMethod($name, '__construct');
            $parameters = $reflection->getParameters();
            $arr = [];
            foreach ($parameters as $parameter) {
                $arr[$parameter->name] = $this->getService($parameter->getClass()->name);
            }

            return $service->newInstanceArgs($arr);
        }

    }
}