<?php

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