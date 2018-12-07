<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 05.12.2018
 * Time: 11:28
 */

namespace Vadimyen;


class ConstructorOverloader
{
    private $name;

    public function __construct($name = "__construct")
    {
        $this->name = $name;
    }

    public function construct($object, array $args = array())
    {
        $this->validateParam($object);
        $argc = count($args);
        $methodName = "{$this->name}{$argc}";
        $this->checkMethodExists($object, $methodName, $argc);
        $constructor = $this->getConstructor($object);
        return $constructor($object, $methodName, $args);
    }

    private function validateParam($object)
    {
        if (!is_object($object)) {
            throw new \TypeError("{
        $object} is not an object");
        }

    }

    private function getConstructor($object): \Closure
    {
        return \Closure::bind(function ($object, $method, $args) {
            return $object->$method(...$args);
        }, $object, get_class($object));

    }

    private function checkMethodExists($object, $methodName, $argc)
    {
        if (!method_exists($object, $methodName)) {
            $className = get_class($object);
            throw new \InvalidArgumentException("There's no {$methodName} method with {$argc} arguments in {$className} class.");
        }
    }

}
