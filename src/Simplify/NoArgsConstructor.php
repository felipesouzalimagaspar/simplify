<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    #[\Attribute(\Attribute::TARGET_CLASS)]
    final class NoArgsConstructor extends Constructor {
        public function verifySignature(string $name, array $arguments = []) : bool {
            return $name === '__construct' && count($arguments) === 0;
        }
        public function __construct() {
            parent::__construct();
        }
    }