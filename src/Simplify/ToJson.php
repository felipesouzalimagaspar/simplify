<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    #[\Attribute(\Attribute::TARGET_CLASS)]
    final class ToJson implements MagicallyInvokedMethod {
        public function invoke(object $instance, string $name, array $arguments = []) : mixed {
            $tmp = [];
            foreach (\Code\Property\Analyzer::getAllProperties($instance) as $prop)
                try{ $tmp[$prop->getName()] = $this->resolv($prop->getValue($instance)); }
                catch(\TypeError $te) { continue; }
            return json_encode($tmp, JSON_UNESCAPED_UNICODE);
        }

        public function verifySignature(string $name, array $arguments = []) : bool {
            return in_array($name, ['toJson', 'toJson']) && count($arguments) === 0;
        }

        private function resolv(mixed $prop) : mixed {
            if($prop instanceof \JsonSerializable) {
                return $prop->jsonSerialize();
            } else if(
                \Code\Type\Analyzer::isScalar($prop) || 
                (\Code\Type\Analyzer::isObject($prop) && !($prop instanceof \Closure))
            ) {
                return $prop;
            } else if(\Code\Type\Analyzer::isArray($prop) || $prop instanceof \iterable) {
                $tmp = [];
                foreach ($prop as $key => $value) {
                    try { $tmp[$key] = $this->resolv($value);}
                    catch(\TypeError $te) { continue; }
                }
                return $tmp;
            }
            throw new \TypeError(\Code\Type\Analyzer::getType($prop) . ' is not serializable');
        }
    }