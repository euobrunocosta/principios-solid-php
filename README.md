# Princípios SOLID em PHP com exemplos

SOLID é um conjunto de princípios do design orientado ao objeto que tem o objetivo de fazer com que seu código fique mais flexível e de mais fácil manutenibilidade.

SOLID é um acrônimo em inglês para o seguinte:

+ Single Responsability (Responsabilidade Única)
+ Open/Cloded (Aberto/Fechado)
+ Liskov Substitution (Substituição Liskov)
+ Interface Segragation (Segregação de Interface)
+ Dependency Inversion (Inversão de Dependência)

## Princípio da Responsabilidade Única (Single Responsability)

Esse princípio diz que uma classe deveria ter apenas uma responsabilidade

Exemplo de como não se deve fazer
```php
class Post
{

  protected $titulo;

  public function getTitulo()
  {
    return $this->titulo;
  }

  public function formataJson()
  {
    return json_encode($this->getTitulo());
  }

}
```

A classe acima sabe da existência de uma propriedade `titulo`, ela nos deixa obter o valor dessa propriedade através do método `getTitulo()` e também utiliza o método `formataJson()` para retornar uma string no formato JSON.

Apesar de parecer uma boa ideia deixar na responsabilidade da classe sua própria formatação, o que acontece é que se quisermos mudar o retorno de JSON para outro formato, por exemplo, teríamos que alterar a classe adicionando um novo método a ela ou modificando o método já existente. Para uma classe simples como essa, tal modificação não seria um problema mas se fosse uma classe maior, como mais métodos e mais propriedades, teríamos que fazer mudanças mais complexas.

A seguir uma forma melhor de organizar o código acima:
```php
class Post
{

  protected $titulo;

  public function getTitulo($titulo)
  {
    return $this->titulo;
  }

}

class JsonPostFormatador
{

  public function formatar(Post $post)
  {
    return json_encode($post->getTitulo());
  }
}
```

## Princípio Aberto/Fechado (Open/Closed)

Segundo esse princípio, uma classe deve ser aberta para extensões e fechada para modificações. Na prática isso significa que classes devem ser estendidas para modificar funcionalidades no lugar de serem alteradas.

Observe as duas classes no exemplo a seguir:
```php
class Retangulo
{
  public $largura;
  public $altura;
}

class Quadro
{

  public $retangulos = [];

  public function calcularArea()
  {
    $area = 0;
    foreach ($this->retangulos as $retangulo) {
      $area += $retangulo->largura * $retangulo->altura;
    }
    return $area;
  }

}
```

Temos uma classe `Retangulo` que contém os dados do retângulo, e um classe `Quadro` que é usada como uma coleção de objetos do tipo `Retangulo`. Com esse esquema podemos calcular facilmente a área total da coleção apenas iterando por seus itens e somando o cálculo suas áreas.

O problema com esse esquema é que estamos restritos a apenas um tipo específico de forma (um retângulo nesse caso). Se quiséssemos por exemplo adicionar um círculo à classe `Quadro` teríamos que adicionar condicionais para detectar e calcular a área.

A forma mais apropriada de desenhar esse esquema seria movendo o código de cálculo da área para uma interface chamada `Forma` e fazer com que todas as classes de formas estendam tal interface.
```php
interface Forma
{
  public function area();
}

class Retangulo implements Forma
{

  public $largura;
  public $altura;

  public function area() {
    return $this->largura * $this->altura;
  }
  
}

class Circulo implements Forma
{

  public $raio;

  public function area() {
    return $this->raio * $this->raio * $this->pi();
  }

}

class Quadro
{

  public $formas = [];

  public function calcularArea()
  {
    $area = 0;
    foreach ($this->formas as $forma) {
      $area += $forma->area();
    }
    return $area;
  }

}
```

Dessa forma a gente desenhou esses objetos de uma forma que não precisamos alterar a classe `Quadro` se tivermos o tipo diferente de objeto. Ao invés disso, apenas criamos o novo objeto implementando a interface `Forma` e passamos ela para a coleção da mesma forma que as outras classes.

## Princípio da Substituição Liskov (Liskov Substitution)

Criada por Barbara Liskov em 1987 esse princípio diz que classes derivadas devem poder substituir suas classes bases sem causar quaisquer tipos de erros.

Por exemplo, o código a seguir define a classe `Retangulo` que pode ser usada para criar e calcular a área de um retângulo:
```php
class Retangulo {

  private $largura;
  private $altura;

  public function setLargura($largura)
  {
    $this->largura = $largura;
  }

  public function setAltura($altura)
  {
    $this->altura = $altura;
  }

  public function getArea() {
    return $this->largura * $this->altura;
  }

}
```

Podemos criar uma classe `Quadrado` que pode extender a classe `Retangulo`. Mas por causa de algumas diferenças entre um quadrado e um retângulo, teríamos que substituir (override) uma parte do código:

Substituir muito código em uma classe para adpata-la a uma situação específica pode trazer muitos problemas de manutenção.

Uma boa solução para esse problema seria criar uma interface chamada `Quadrilatero` e implementa-la em classes separadas (`Retangulo` e `Quadrado`). Dessa forma, a gente permitiria que as classes fossem responsáveis por seus próprios dados ao mesmo tempo forçando-as a seguir o esquema de certos métodos:
```php
interface Quadrilatero
{

  public function setLargura($largura);

  public function setAltura($altura);

  public function getArea();

}

class Retangulo implements Quadrilatero
{
  // implementação aqui ...
}

class Quadrado implements Quadrilatero
{
  // implementação aqui ...
}
```

No final das contas, se você está precisando substituir muito código para adaptar sua classe base, talvez sua arquitetura esteja errada e você deveria pensar nesse princípio.

## Princípio da Segregação de Interface (Interface Segragation)

Esse princípio diz que classes não deveriam ser forçadas a implementar interfaces que elas não usam.

Veja esse exemplo de um classe `Colaborador` em uma típica agência de desenvolvimento de software:
```php
interface Colaborador
{

  public function darUmaPausa();

  public function desenvolver();

  public function ligarParaCliente();

  public function irParaReuniao();

  public function receberPagamento();

}
```

O problema com essa interface é que ela é muito genérica e, por causa disso, temos que criar métodos em classes que implementam essa interface apenas para se adaptar ela.

Por exemplo se criarmos uma classe `Gerente`, seríamos forçados a implementar o método `desenvolver()`e, uma vez que gerentes normalmente não desenvolvem esse método não serviria para nada:
```php
class Gerente implements Colaborador
{
  public function desenvolver()
  {
    return false;
  }
}
```

Ou se criássemos uma classe `Desenvolvedor` teríamos que implementar o método `ligarParaCliente()` que, tipicamente não é função de um desenvolvedor:
```php
class Desenvolvedor implements Colaborador
{
  public function ligarParaCliente()
  {
    echo "Pedirei ao meu gerente que faça ¯\_(ツ)_/¯";
  }
}
```

Podemos corrigir esse tipo de situação dividindo a interface genérica em interfaces mais específicas:
```php
interface Colaborador
{

  public function darUmaPausa();

  public function receberPagamento();

}

interface Dev
{
  public function desenvolver(); 
}

interface AtendimentoCliente
{

  public function ligarParaCliente();

  public function irParaReuniao();

}
```

E na hora de implementar:
```php
class Desenvolvedor implements Colaborador, Dev
{
  // código aqui ...
}

class Gerente implements Colaborador, AtendimentoCliente
{
  // código aqui ...
}
```

## Princípio da Inversão de Dependência (Dependency Inversion)

Esse princípio orienta que classes devem depender de abstrações e não de concreções. Classes não devem depender de classes concretas e sim de interfaces.

Vejamos esse exemplo de uma classe `CarregarPagina` que usa uma class `MySQLConexao` para carregar páginas do banco de dados. Podemos criar as classes de uma forma que a conexão com o banco de dados é passada pelo constructor da classe `CarregarPagina`
```php
class MySQLConexao
{
  public function conectar()
  {
    // código aqui ...
  }
}

class CarregarPagina
{

  private $conexaoBD;

  public function __construct(MySQLConexao $conexaoBD)
  {
    $this->conexaoBD = $conexaoBD;
  }

}
```

Se utilizarmos a estrutura acima, estamos essencialmente obrigados a utilizar MySQL como nosso banco de dados. 

A solução aqui seria uma interface chamada `BdConexaoInterface` e depois implementá-la na class `MySQLConexao`. Fazendo isso, ao invés de confiar em uma classe `MySQLConexao` sendo passada para uma classe `CarregarPagina`, a gente confia em qualquer classe que implementa a interface `BdConexaoInterface``
```php
interface BdConexaoInterface
{
  public function connect();
}

class MySQLConexao implements BdConexaoInterface
{
  public function connect()
  {
    // código aqui ...
  }
}

class CarregarPagina
{

  private $bdConexao;

  public function __construct(BdConexaoInterface $bdConexao)
  {
    $this->bdConexao = $bdConexao;
  }

}
```
