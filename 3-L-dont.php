<?php

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