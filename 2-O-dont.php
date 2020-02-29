<?php

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