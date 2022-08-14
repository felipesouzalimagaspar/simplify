<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    #[\Attribute(\Attribute::TARGET_CLASS)]
    final class Getters implements MagicallyInvokedMethod {
        private string $prefix;

        public function invoke(object $instance, string $name, array $arguments = []) : mixed {
            if($prop = \Code\Property\Analyzer::getPropertyAccessIfExists(str_replace($this->prefix, "", $name), $instance))
                return $prop->getValue($instance);
            throw \Code\Simplify\Solver::UndefinedMethodError($instance, $name, $arguments);
        }

        public function verifySignature(string $name, array $arguments = []) : bool {
            return (strpos($name, $this->prefix) === 0 && count($arguments) === 0);
        }

        public function __construct(string $prefix = 'get') { $this->prefix = $prefix; }
    }