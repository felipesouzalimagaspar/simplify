<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    #[\Attribute(\Attribute::TARGET_CLASS)]
    final class Setters implements MagicallyInvokedMethod {
        private string $prefix;
        private bool $chain;

        public function invoke(object $instance, string $name, array $arguments = []) : mixed {
            if($prop = \Code\Property\Analyzer::getPropertyAccessIfExists(str_replace($this->prefix, "", $name), $instance)) {
                if($prop->getType() === null || ($arguments[0] === null) || (\Code\Type\Analyzer::typeMatch($arguments[0], $prop->getType()))) {
                    $prop->setValue($instance, $arguments[0]);
                    return ($this->chain) ? $instance : null;
                }else throw new \TypeError("Typed property ".get_class($instance)."::{$prop->getName()} must be {$prop->getType()}, ".\Code\Type\Analyzer::getType($arguments[0])." used");
            }
            throw \Code\Simplify\Solver::UndefinedMethodError($instance, $name, $arguments);
        }

        public function verifySignature(string $name, array $arguments = []) : bool {
            return (strpos($name, $this->prefix) === 0 && count($arguments) === 1);
        }

        public function __construct(string $prefix = 'set', bool $chain = true) {
            $this->prefix = $prefix;
            $this->chain = $chain;
        }
    }