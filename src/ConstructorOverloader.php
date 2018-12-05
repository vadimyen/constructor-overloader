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
    public function construct($object, array $args)
    {
        $this->validate($object);
        $argc = count($args);
        $method = "__construct{$argc}";
        $invoker = \Closure::bind(function ($object, $method, $args) {
            return $object->$method(...$args);
        }, $object, $object);
        return $invoker($object, $method, $args);
    }

    private function validate($object)
    {
        if (!is_object($object)) {
            throw new \TypeError("{$object} is not an object");
        }

    }


}
