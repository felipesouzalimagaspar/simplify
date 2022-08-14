<?php
    /**
     * Arquivo de implementação da classe de testes ExceptionTest utilizando o framework PHPUnit
     * @package Logger\UnitTest
     * @author Felipe Gaspar <desenvolvimento10@arcoinformatica.com.br>
     * @copyright Copyright © 2021, Arco Informática.
     */
    declare(strict_types=1);
    namespace Test\UnitTest;

    /**
     * SimplifyTest é uma classe de testes para a classe Exception utilizando o framework PHPUnit
     * @final
     */
    final class SimplifyTest extends \PHPUnit\Framework\TestCase {
        /**
         * @dataProvider Example1Provider
         */
        public function testNoArgsConsctructorWithNoArgs(string $classname): void {
            $this->assertTrue(new $classname instanceof $classname);
        }
        /**
         * @dataProvider Example1Provider
         */
        public function testErrorOnNoArgsConsctructorWithArgs(string $classname): void {
            $this->expectException(\Error::class);
            new $classname(false);
        }
        /**
         * Provedor de dados para a função de testes testThrowSubclassException
         * @access public
         * @return array
         */
        public function Example1Provider() : array {
            require_once __DIR__ . '/../classes/Example1.php';
            return [
                [\Example1::class]
            ];
        }
        /**
         * @dataProvider Example2Provider
         */
        public function testAllArgsConsctructorWithAllArgs(string $classname): void {
            $this->assertTrue(new $classname(null, 'foo') instanceof $classname);
        }
        /**
         * @dataProvider Example2Provider
         */
        public function testErrorOnAllArgsConsctructorWithNoArgs(string $classname): void {
            $this->expectException(\Error::class);
            new $classname;
        }
        /**
         * @dataProvider Example2Provider
         */
        public function testErrorOnAllArgsConsctructorWithInvalidArgs(string $classname): void {
            $this->expectException(\Error::class);
            new $classname(1, (object)['foo'=>'bar']);
        }
        /**
         * Provedor de dados para a função de testes testThrowSubclassException
         * @access public
         * @return array
         */
        public function Example2Provider() : array {
            require_once __DIR__ . '/../classes/Example2.php';
            return [
                [\Example2::class]
            ];
        }
        /**
         * @dataProvider Example3Provider
         */
        public function testEquals(mixed $p1, mixed $p2, bool $result): void {
            $this->assertEquals($p1->equals($p2), $result);
        }
        /**
         * Provedor de dados para a função de testes testThrowSubclassException
         * @access public
         * @return array
         */
        public function Example3Provider() : array {
            require_once __DIR__ . '/../classes/Example3.php';
            return [
                "Equals" => [new \Example3, new \Example3, true],
                "Type Difference" => [new \Example3, -1, false],
                "Variable Difference" => [new \Example3, new \Example3(0, 'bar'), false]
            ];
        }
        /**
         * @dataProvider Example4Provider
         */
        public function testGetterWithValidProp(string $classname): void {
            $this->assertEquals((new $classname)->getId(), 1);
        }
        /**
         * @dataProvider Example4Provider
         */
        public function testGetterWithInvalidProp(string $classname): void {
            $this->expectError();
            (new $classname)->getInvalidProp();
        }
        /**
         * @dataProvider Example4Provider
         */
        public function testSetterWithValidProp(string $classname): void {
            (new $classname)->setId(0);
            $this->assertTrue(true);
        }
        /**
         * @dataProvider Example4Provider
         */
        public function testSetterWithInvalidProp(string $classname): void {
            $this->expectError();
            (new $classname)->setInvalidProp(1);
        }
        /**
         * @dataProvider Example4Provider
         */
        public function testSetterWithInvalidType(string $classname): void {
            $this->expectError();
            (new $classname)->setId('wrong type');
        }
        /**
         * @dataProvider Example4Provider
         */
        public function testToString(string $classname): void {
            $this->assertTrue(is_string((string)(new $classname)));
        }
        /**
         * @dataProvider Example4Provider
         */
        public function testToJson(string $classname): void {
            $this->assertIsArray(json_decode((new $classname)->toJson(), true));
        }
        public function Example4Provider() : array {
            require_once __DIR__ . '/../classes/Example4.php';
            return [
                [\Example4::class]
            ];
        }
        /**
         * @dataProvider Example5Provider
         */
        public function testJsonEncode(string $classname): void {
            $this->assertIsString(json_encode(new $classname));
        }
        public function Example5Provider() : array {
            return array_merge(
                $this->Example4Provider(),
                $this->Example1Provider()
            );
        }
    }
