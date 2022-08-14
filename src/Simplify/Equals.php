<?php
    declare(strict_types=1);
    namespace Code\Simplify;

    #[\Attribute(\Attribute::TARGET_CLASS)]
    final class Equals implements MagicallyInvokedMethod {
        public function invoke(object $instance, string $name, array $arguments = []) : mixed {
            if(
                \Code\Type\Analyzer::typeMatch($instance, $arguments[0])
                && count($otherProps = \Code\Property\Analyzer::getAllProperties($arguments[0]))
                === count($myProps = \Code\Property\Analyzer::getAllProperties($instance))
            ) {
                for($i=0;$i<count($arguments);$i++)
                    if(!($otherProps[$i]->getValue($arguments[0]) === $myProps[$i]->getValue($instance))) {
                        return false;
                    }
                return true;   
            } else return false;
        }

        public function verifySignature(string $name, array $arguments = []) : bool {
            return $name === 'equals' && count($arguments) === 1;
        }
    }