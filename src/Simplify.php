<?php
    declare(strict_types=1);
    namespace Code;

    use Code\Simplify\MagicallyInvokedMethod;
    use Code\Simplify\Solver;

    abstract class Simplify implements \JsonSerializable {
        public function __call(string $name, array $arguments = []) : mixed {
            return $this->getMethodSolver()->solve($this, $name, $arguments);
        }
        private function getMethodSolver() : Solver {
            $methods = [];
            foreach((new \ReflectionClass($this))->getAttributes() as $method) {
                $method = $method->newInstance();
                if($method instanceof MagicallyInvokedMethod) $methods[] = $method;
            }
            return new Solver(...$methods);
        }
        public function __construct(mixed ...$params) {
            return $this->__call('__construct', func_get_args());
        }
        public function jsonSerialize() {
            try {
                return json_decode($this->__call('toJson'), true);
            } catch(\Throwable $t) {
                return (object) [];
            }
        }
        public function __toString() {
            return $this->__call('toString');
        }
    }

    