<?php

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