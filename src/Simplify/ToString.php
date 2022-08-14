<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    #[\Attribute(\Attribute::TARGET_CLASS)]
    final class ToString implements MagicallyInvokedMethod {
        public function invoke(object $instance, string $name, array $arguments = []) : mixed {
            $tmp = [];
            foreach (\Code\Property\Analyzer::getAllProperties($instance) as $prop)
                $tmp[] = join("=", [$prop->getName(),var_export($prop->getValue($instance), true)]);
            return join('', [join('', [get_class($instance), '=(']), join("&", $tmp), ')']);
        }

        public function verifySignature(string $name, array $arguments = []) : bool {
            return in_array($name, ['__toString', 'toString']) && count($arguments) === 0;
        }
    }