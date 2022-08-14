<?php
    declare(strict_types=1);
    namespace Code\Type;
    
    final class Analyzer {
        public static function getType(mixed $param, bool $returnClassname = true) : string {
            if($param instanceof \ReflectionNamedType) {
                return $param->getName();
            } else if($returnClassname && gettype($param) === 'object') {
                return get_class($param);
            }else {
                $format = fn (string $t) => $t === 'boolean' ? 'bool' : ($t === 'integer' ? 'int' : ($t === 'double' ? 'float' : ($t === 'NULL' ? 'null' : $t)));
                return $format(gettype($param));
            }
        }

        public static function isScalar(mixed $param) : bool { return in_array(self::getType($param), ['bool', 'int', 'float', 'string', 'null']); }
        public static function isArray(mixed $param) : bool { return self::getType($param) === 'array'; }
        public static function isObject(mixed $param) : bool { return self::getType($param, false) === 'object'; }
        public static function typeMatch(mixed $param1, mixed $param2) : bool { return self::getType($param1) === self::getType($param2); }
    }