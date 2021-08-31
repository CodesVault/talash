<?php
namespace Talash\Facade;

abstract class Facade {

    abstract protected static function getInstance();
    
    public static function __callStatic($method, $arguments) {
        $instance = static::getInstance();

        if (! $instance) {
            throw new \Exception('Method not found');
        }
        
        return $instance->$method(...$arguments);
    }
}
