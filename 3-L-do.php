<?php

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