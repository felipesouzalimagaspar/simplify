<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    final class Solver {

        private array $declared_methods = [];

        public function __construct(MagicallyInvokedMethod ...$methods) {
            $this->declared_methods = $methods;
        }

        public function solve(object $instance, string $name, array $arguments = []) : mixed {
            foreach($this->declared_methods as $method)
                if($method->verifySignature($name, $arguments))
                    return $method->invoke($instance, $name, $arguments);
            throw self::UndefinedMethodError($instance, $name, $arguments);
        }

        public static function UndefinedMethodError(object $instance, string $name, array $arguments) : \Error {
            return new \Error("Call to undefined method ".get_class($instance)."::{$name}(".join(", ", $arguments).")");
        }
    }
