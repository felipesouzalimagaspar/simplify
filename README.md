![IDE](https://img.shields.io/badge/Visual_Studio_Code-0078D4?style=for-the-badge&logo=visual%20studio%20code&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)



# Simplify
A simple way to write classes in PHP. No more getters, setters or constructors.

## Usage

```
#[
    \Code\Simplify\AllArgsConstructor,
    \Code\Simplify\Getters,
    \Code\Simplify\Setters,
    \Code\Simplify\ToString,
    \Code\Simplify\ToJson,
    \Code\Simplify\Equals
]
final class Example extends \Code\Simplify {
    private ?int $id = 1;
    private string $name = 'foo';
}

(new Example(null, 'bar'))->getName(); //bar
```