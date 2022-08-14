<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    #[\Attribute(\Attribute::TARGET_CLASS)]
    final class AllArgsConstructor extends Constructor {
        public function __construct() {
            parent::__construct(false, true);
        }
    }