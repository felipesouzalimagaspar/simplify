<?php
    declare(strict_types=1);
    namespace Code\Property;
    
    final class Analyzer {
        public static function getPropertyAccessIfExists(string $name, object $instance) : \ReflectionProperty|false {
            $name = str_replace(["_"], '', strtolower($name));
            foreach ((new \ReflectionClass($instance))->getProperties() as $prop)
                if($name ===  str_replace(["_"], '', strtolower($prop->getName()))) {
                    $prop->setAccessible(true);
                    return  $prop;
                }
            return false;
        }

        public static function getAllProperties(object $instance) : array {
            $props = [];
            foreach ((new \ReflectionClass($instance))->getProperties() as $prop) {
                $prop->setAccessible(true);
                $props[] = $prop;
            }
            return $props;
        }
    }