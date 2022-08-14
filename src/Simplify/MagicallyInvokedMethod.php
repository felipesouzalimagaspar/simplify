<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    interface MagicallyInvokedMethod {
        public function invoke(object $instance, string $name, array $arguments = []) : mixed;
        public function verifySignature(string $name, array $arguments = []) : bool;
    }