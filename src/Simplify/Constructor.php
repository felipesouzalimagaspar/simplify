<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    #[\Attribute(\Attribute::TARGET_CLASS)]
    class Constructor implements MagicallyInvokedMethod {
        private bool $noArgs;
        private bool $allArgs;

        public function invoke(object $instance, string $name, array $arguments = []) : mixed {
            if($this->noArgs && count($arguments) === 0) return $instance;
            else if($this->allArgs && count($arguments) === count($props = \Code\Property\Analyzer::getAllProperties($instance))) {
                for($i=0;$i<count($arguments);$i++) $props[$i]->setValue($instance, $arguments[$i]);
                return $instance;   
            }
            throw \Code\Simplify\Solver::UndefinedMethodError($instance, $name, $arguments);
        }

        public function verifySignature(string $name, array $arguments = []) : bool {
            return $name === '__construct';
        }

        public function __construct(bool $noArgs = true, bool $allArgs = true, bool $explicitArgs = false, string $signature = '') {
            $this->noArgs = $noArgs;
            $this->allArgs = $allArgs;
        }
    }